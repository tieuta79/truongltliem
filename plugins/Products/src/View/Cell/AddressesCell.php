<?php
namespace Products\View\Cell;

use Cake\View\Cell;

/**
 * Addresses cell
 */
class AddressesCell extends Cell
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
        $this->loadModel('Products.Addresses');
        $addresses = $this->Addresses->find()
                ->contain(['Countries', 'Provinces', 'Cities', 'Wards'])
                ->where(['Addresses.delete'=>0])
                ->order(['Addresses.default'=>'desc','Addresses.id'=>'desc'])->limit(2);

        $this->set('addresses', $addresses);
    }
}
