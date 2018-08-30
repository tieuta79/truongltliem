<?php
use Migrations\AbstractSeed;

/**
 * Wishlists seed.
 */
class WishlistsSeed extends AbstractSeed
{
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
    public function run()
    {
        $data = [];

        $table = $this->table('wishlists');
        $table->insert($data)->save();
    }
}
