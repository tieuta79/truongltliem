<?php

use Migrations\AbstractSeed;

/**
 * MetaTypes seed.
 */
class MetaTypesSeed extends AbstractSeed {

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
                'name' => 'Posts',
                'slug' => 'posts',
                'icon' => 'fa fa-edit',
                'description' => '',
                'model' => 'Contents',
                'category' => 1,
                'multi_category' => 1,
                'menu' => 1,
                'delete' => 0,
                'options' => '{"hideFeatureImage":"0","hideExcerpt":"0","hideDescription":"0","hideFeatureImage":"0"}'
            ],
            [
                'name' => 'Pages',
                'slug' => 'pages',
                'icon' => 'fa fa-book',
                'description' => '',
                'model' => 'Contents',
                'category' => '',
                'multi_category' => 1,
                'menu' => 1,
                'delete' => 0,
                'options' => '{"hideFeatureImage":"1","hideExcerpt":"1","hideDescription":"0","hideFeatureImage":"1"}'
            ],
        ];

        $table = $this->table('meta_types');
        $table->insert($data)->save();
    }

}
