<?php
use Migrations\AbstractMigration;

class Cats extends AbstractMigration
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
        $table->addColumn('ear_shape', 'integer', [
            'default' => 0,
            'limit' => 1,
            'null' => true,
        ]);
    }
}
