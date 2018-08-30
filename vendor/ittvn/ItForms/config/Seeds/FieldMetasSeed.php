<?php
use Migrations\AbstractSeed;

/**
 * FieldMetas seed.
 */
class FieldMetasSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        $table = $this->table('field_metas');
        //$table->insert($data)->save();
    }
}
