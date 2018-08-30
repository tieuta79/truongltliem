<?php

use Migrations\AbstractMigration;

class Products extends AbstractMigration {

    public $autoId = false;

    public function up() {
        $this->table('addresses')
                ->addColumn('id', 'integer', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                    'signed' => false,
                ])
                ->addPrimaryKey(['id'])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('company', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('phone', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('country_id', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('province_id', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('city_id', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('ward_id', 'integer', [
                    'default' => null,
                    'limit' => 11,
                    'null' => true,
                ])
                ->addColumn('address', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('user_id', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('default', 'boolean', [
                    'default' => false,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('delete', 'boolean', [
                    'default' => false,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

        $this->table('attributes')
                ->addColumn('id', 'integer', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addPrimaryKey(['id'])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('type', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('options', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('status', 'boolean', [
                    'default' => true,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('delete', 'boolean', [
                    'default' => false,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

        $this->table('attribute_products')
                ->addColumn('id', 'integer', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addPrimaryKey(['id'])
                ->addColumn('content_id', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('attribute_id', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('value', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

        $this->table('filters')
                ->addColumn('id', 'integer', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                    'signed' => false,
                ])
                ->addPrimaryKey(['id'])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('slug', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('description', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('attributes', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('delete', 'boolean', [
                    'default' => false,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

        $this->table('orderdetails')
                ->addColumn('id', 'integer', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                    'signed' => false,
                ])
                ->addPrimaryKey(['id'])
                ->addColumn('content_id', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('order_id', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('price', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('quantity', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('total', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->create();

        $this->table('orders')
                ->addColumn('id', 'integer', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                    'signed' => false,
                ])
                ->addPrimaryKey(['id'])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('request', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('user_id', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('receiver', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('address', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('phone', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('fee', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('payment_id', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('price', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('status', 'integer', [
                    'default' => 0,
                    'limit' => 1,
                    'null' => true,
                ])
                ->addColumn('check', 'integer', [
                    'default' => 0,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('delete', 'boolean', [
                    'default' => false,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

        $this->table('payments')
                ->addColumn('id', 'integer', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                    'signed' => false,
                ])
                ->addPrimaryKey(['id'])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('image', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('fee', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('description', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('element', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('options', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('status', 'boolean', [
                    'default' => true,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('delete', 'boolean', [
                    'default' => false,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

        $this->table('wishlists')
                ->addColumn('id', 'integer', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                    'signed' => false,
                ])
                ->addPrimaryKey(['id'])
                ->addColumn('content_id', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('user_id', 'integer', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('delete', 'boolean', [
                    'default' => false,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();
    }

    public function down() {
        die('sss');
        if ($this->hasTable('addresses')) {
            $this->dropTable('addresses');
        }
        if ($this->hasTable('attribute_products')) {
            $this->dropTable('attribute_products');
        }
        if ($this->hasTable('attributes')) {
            $this->dropTable('attributes');
        }
        if ($this->hasTable('filters')) {
            $this->dropTable('filters');
        }
        if ($this->hasTable('orderdetails')) {
            $this->dropTable('orderdetails');
        }
        if ($this->hasTable('orders')) {
            $this->dropTable('orders');
        }
        if ($this->hasTable('payments')) {
            $this->dropTable('payments');
        }
        if ($this->hasTable('wishlists')) {
            $this->dropTable('wishlists');
        }
    }

}
