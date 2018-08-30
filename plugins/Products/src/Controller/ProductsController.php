<?php

namespace Products\Controller;

use Extensions\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\View\View;
/**
 * Themes Controller
 *
 * @property \Themes\Model\Table\ThemesTable $Themes
 */
class ProductsController extends AppController {
    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['viewAjax','viewDescriptionAjax','addCart','cart']);
        if(in_array($this->request->action,['checkout','payment'])){
            $this->Auth->config('loginAction', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login','role'=>'customers']);
            $this->Auth->config('logoutRedirect', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login','role'=>'customers']);
        }
    }

    public function viewAjax() {
        $this->viewBuilder()->layout(false);
        $this->loadModel('Contents.Contents');
        $content = $this->Contents->find()
                ->select(['Contents.id', 'Contents.slug', 'Contents.name', 'Contents.image', 'Contents.excerpt'])
                ->contain(['ContentMetas' => function($q) {
                        return $q->select(['id', 'key', 'value', 'content_id']);
                    }, 'Categories' => function($q) {
                        return $q->select(['Categories.id']);
                    }])
                ->where(['Contents.slug' => $this->request->slug, 'Contents.delete' => 0])
                ->first();

        //update hits
        $hit = $content->hits;
        $content->hits = intval($hit) + 1;
        $this->Contents->save($content);        

        $categories = [];
        if (count($content->categories) > 0) {
            $categories = Hash::extract($content->categories, '{n}.id');
        }

        $this->set(compact('content', 'categories'));
        $this->set('_serialize', ['content']);

        $this->renderViews([
            'view-' . $this->request->type . '-' . $this->request->slug,
            'view-' . $this->request->type,
            'view',
        ]);
    }    
    
    public function viewDescriptionAjax() {
        $this->viewBuilder()->layout(false);
                $this->loadModel('Contents.Contents');
        $product = $this->Contents
                ->findBySlug($this->request->slug)
                ->select(['name','description'])
                ->first();
        $this->set(compact('product'));
    }
    
    public function addCart() {
        $return = ['status'=>false,'data'=>[]];
        if($this->request->is('post') && !empty($this->request->data['cart'])){
            $this->loadModel('Contents.Contents');
            $view = new View();
            $carts = json_decode($this->request->data['cart']);
            $notify = json_decode($this->request->data['notify']);
            $info = '';
            $products = [];
            $quantity = 0;
            foreach($carts as $cart){
                $product = $this->Contents
                        ->findById($cart->product_id)
                        ->select(['Contents.id','Contents.name','Contents.slug','Contents.image'])
                        ->contain(['ContentMetas' => function($q) {
                                return $q->select(['id', 'key', 'value', 'content_id'])->where(['key'=>'Price']);
                            }])
                        ->where(['Contents.delete' => 0]);
                            
                if($product->count() > 0){
                    $product = $product->first();
                    $product['quantity'] = $cart->quantity;
                    $product['amount'] = intval($cart->quantity) * intval($product['Price_meta']);
                    if($product['id']==$notify->product_id){
                        $info = $view->element('Products.notify_product', ['product' => $product]);
                    }
                    $quantity += intval($product['quantity']);
                    $products[] = $product;
                }
            }

            $return = [
                'status'=>true,
                'data' => [
                    'notify' => $info,
                    'cart_number' => $view->element('Products.cart_number', ['quantity' => $quantity]),
                    'cart_info' => $view->element('Products.cart_info', ['products' => $products]),
                ]
            ];
        }
        $this->set('return', $return);
        $this->set('_serialize', 'return');
    }

    public function cart() {
        $this->loadModel('Contents.Contents');
        $carts = [];
        if($this->request->cookie('cart')!=''){
            $carts = json_decode($this->request->cookie('cart'));
        }
        $products = [];
        
        foreach($carts as $cart){
            $product = $this->Contents
                    ->findById($cart->product_id)
                    ->select(['Contents.id','Contents.name','Contents.slug','Contents.image'])
                    ->contain(['ContentMetas' => function($q) {
                            return $q->select(['id', 'key', 'value', 'content_id'])->where(['key'=>'Price']);
                        }])
                    ->where(['Contents.delete' => 0]);

            if($product->count() > 0){
                $product = $product->first();
                $product->quantity = $cart->quantity;
                $product->amount = intval($cart->quantity) * intval($product->Price_meta);
                $products[] = $product;
            }
        }
        
        if($this->request->is('post')){
            $view = new View();
            $return = [
                'status'=>true,
                'data'=>$view->element('Products.view_cart',['products'=>$products])
            ];
            $this->set(compact('return'));
            $this->set('_serialize', 'return');
        }else{
            $this->set(compact('products'));
        }
    }
    
    public function checkout() {
        $this->loadModel('Products.Addresses');
        $addresses = $this->Addresses->find()
                ->contain(['Countries', 'Provinces', 'Cities', 'Wards'])
                ->where(['Addresses.user_id'=>$this->Auth->user('id'),'Addresses.delete'=>0]);
        $this->set(compact('addresses'));
    }
    
    public function payment() {
        $this->loadModel('Products.Payments');
        $payments = $this->Payments->find()
                ->where(['status'=>1,'delete'=>0]);
        $this->set(compact('payments'));
    }
}
