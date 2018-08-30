<?php
namespace Products\View\Cell;

use Cake\View\Cell;
use Cake\Utility\Hash;
/**
 * Orders cell
 */
class OrdersCell extends Cell
{

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
    public function recent()
    {
        $this->loadModel('Products.Orders');
        $this->loadModel('Contents.Contents');
        
        $orders = $this->Orders->find()
                ->contain([
                    'Orderdetails' => function($q){
                        return $q->select(['id','content_id','order_id'])->limit(1)->orderDesc('id');
                    }
                ])
                ->where(['Orders.user_id'=>$this->request->session()->read('Auth.Registered.id'),'Orders.delete'=>0])->limit(5)->orderDesc('Orders.id');
        
        $product_id = [];
        if($orders->count() >0 ){
            $product_id = Hash::extract($orders->toArray(), '{n}.orderdetails.{n}.content_id');
        }
        
        $products = [];
        if(count($product_id) > 0){
            $this->loadModel('Contents.Contents');
            $products = $this->Contents->find('list',['keyField'=>'id','valueField'=>'name'])
                    ->where(['delete'=>0,'status'=>1]);
            if($products->count() > 0){
                $products = $products->toArray();
            }
        }

        $this->set('orders',$orders);
        $this->set('products',$products);
    }
}
