<?php
use Migrations\AbstractSeed;

/**
 * Attributes seed.
 */
class AttributesSeed extends AbstractSeed
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

        $table = $this->table('attributes');
        $table->insert($data)->save();
		
        $table = $this->table('attribute_products');
        $table->insert($data)->save();
    }
}
