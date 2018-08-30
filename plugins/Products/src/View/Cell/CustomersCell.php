<?php
namespace Products\View\Cell;

use Cake\View\Cell;

/**
 * Customers cell
 */
class CustomersCell extends Cell
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
    public function menu()
    {
        $this->loadModel('Products.Addresses');
        $count_address = $this->Addresses->find()
                ->where(['user_id'=>$this->request->session()->read('Auth.Registered.id'),'delete'=>0])
                ->count();
        
        $this->loadModel('Products.Orders');
        $count_order = $this->Orders->find()
                ->where(['user_id'=>$this->request->session()->read('Auth.Registered.id'),'delete'=>0])
                ->count();
        
        $this->loadModel('Products.Wishlists');
        $count_wishlist = $this->Wishlists->find()
                ->where(['user_id'=>$this->request->session()->read('Auth.Registered.id'),'delete'=>0])
                ->count();
        
        $this->set('count_wishlist',$count_wishlist);
        $this->set('count_address',$count_address);
        $this->set('count_order',$count_order);
    }
}
