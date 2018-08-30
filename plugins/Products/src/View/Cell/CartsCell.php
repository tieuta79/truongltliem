<?php
namespace Products\View\Cell;

use Cake\View\Cell;

/**
 * Carts cell
 */
class CartsCell extends Cell
{
    public $helpers = [
        'Ittvn.Layout'
    ];
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        $this->loadModel('Contents.Contents');
        $carts = [];
        if($this->request->cookie('cart')!=''){
            $carts = json_decode($this->request->cookie('cart'));
        }

        $products = [];
        $quantity = 0;
        if(count($carts) > 0){
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
                    $quantity += intval($product['quantity']);
                    $products[] = $product;
                }
            }
        }
        $this->set('quantity', $quantity);
        $this->set('products', $products);
    }
}
