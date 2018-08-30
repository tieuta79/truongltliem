<?php

use Migrations\AbstractSeed;

/**
 * MetaCategories seed.
 */
class MetaCategoriesSeed extends AbstractSeed {

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                'name' => 'Categories',
                'slug' => 'categories',
                'description' => 'Manage category for post',
                'meta_type_id' => 1,
                'delete' => ''
            ],
        ];

        $table = $this->table('meta_categories');
        $table->insert($data)->save();
    }

}
