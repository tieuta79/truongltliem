<?php

use Migrations\AbstractMigration;

class ItForms extends AbstractMigration {

    public function up() {

        $this->table('field_metas')
                ->addColumn('key', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('value', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('field_id', 'integer', [
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

        $this->table('fields')
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
                ->addColumn('value', 'string', [
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
                ->addColumn('attributes', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('form_id', 'integer', [
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

        $this->table('forms')
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
                ->addColumn('menu', 'boolean', [
                    'default' => true,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('list', 'boolean', [
                    'default' => true,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('before_submit', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('after_submit', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('js', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('css', 'text', [
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
    }

    public function down() {
        $this->dropTable('field_metas');
        $this->dropTable('fields');
        $this->dropTable('forms');
    }

}
