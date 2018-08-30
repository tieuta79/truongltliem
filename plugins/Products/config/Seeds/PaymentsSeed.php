<?php
use Migrations\AbstractSeed;

/**
 * Payments seed.
 */
class PaymentsSeed extends AbstractSeed
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

        $table = $this->table('payments');
        $table->insert($data)->save();
    }
}
