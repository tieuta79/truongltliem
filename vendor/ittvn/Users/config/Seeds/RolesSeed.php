<?php

use Migrations\AbstractSeed;

/**
 * Roles seed.
 */
class RolesSeed extends AbstractSeed {

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
                'name' => 'Admin',
                'slug' => 'admin',
                'admin_login' => 1,
                'url_after_login' => '',
                'url_after_logout' => '',
                'delete' => 0
            ],
                [
                'name' => 'Manage',
                'slug' => 'manage',
                'admin_login' => 1,
                'url_after_login' => '',
                'url_after_logout' => '',
                'delete' => 0
            ],
                [
                'name' => 'Editor',
                'slug' => 'editor',
                'admin_login' => 1,
                'url_after_login' => '',
                'url_after_logout' => '',
                'delete' => 0
            ],
                [
                'name' => 'User',
                'slug' => 'user',
                'admin_login' => 0,
                'url_after_login' => '',
                'url_after_logout' => '',
                'delete' => 0
            ]
        ];

        $table = $this->table('roles');
        $table->insert($data)->save();
    }

}
