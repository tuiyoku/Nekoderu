<?php
use Migrations\AbstractMigration;

class AddResponseStatusesIdToCats extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('cats');
         $table->addColumn('response_statuses_id', 'integer', [
            'default' => 1,
            'limit' => 11,
            'null' => false,
        ]);
        $table->update();
    }
}
