<?php

use Migrations\AbstractMigration;

class Acl extends AbstractMigration {

    public function up() {
        $table = $this->table('acos');
        $table->addColumn('parent_id', 'integer', ['null' => true])
                ->addColumn('model', 'string', ['limit' => 255, 'null' => true])
                ->addColumn('foreign_key', 'integer', ['null' => true])
                ->addColumn('alias', 'string', ['limit' => 255, 'null' => true])
                ->addColumn('lft', 'integer', ['null' => true])
                ->addColumn('rght', 'integer', ['null' => true])
                ->addIndex(['lft', 'rght'])
                ->addIndex(['alias'])
                ->create();

        $table = $this->table('aros');
        $table->addColumn('parent_id', 'integer', ['null' => true])
                ->addColumn('model', 'string', ['limit' => 255, 'null' => true])
                ->addColumn('foreign_key', 'integer', ['null' => true])
                ->addColumn('alias', 'string', ['limit' => 255, 'null' => true])
                ->addColumn('lft', 'integer', ['null' => true])
                ->addColumn('rght', 'integer', ['null' => true])
                ->addIndex(['lft', 'rght'])
                ->addIndex(['alias'])
                ->create();

        $table = $this->table('aros_acos');
        $table->addColumn('aro_id', 'integer', ['null' => false])
                ->addColumn('aco_id', 'integer', ['null' => false])
                ->addColumn('_create', 'string', ['default' => '0', 'limit' => 2, 'null' => false])
                ->addColumn('_read', 'string', ['default' => '0', 'limit' => 2, 'null' => false])
                ->addColumn('_update', 'string', ['default' => '0', 'limit' => 2, 'null' => false])
                ->addColumn('_delete', 'string', ['default' => '0', 'limit' => 2, 'null' => false])
				->addColumn('params', 'string', ['default' => '0', 'limit' => 255, 'null' => true])
                ->addIndex(['aro_id', 'aco_id', 'params'], ['unique' => true])
                ->addIndex(['aco_id','params'])
                ->create();
    }

    public function down() {
        $this->dropTable('acos');
        $this->dropTable('aros');
        $this->dropTable('aros_acos');
    }

}
