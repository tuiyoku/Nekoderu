<?php
use Migrations\AbstractMigration;

class CreateCats extends AbstractMigration
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
        $table->addColumn('time', 'integer', [
            'default' => null,
            'limit' => 20,
            'null' => true,
        ]);
        $table->addColumn('locate', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => true,
        ]);
        $table->addColumn('image_url', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('flg', 'integer', [
            'default' => null,
            'limit' => 1,
            'null' => true,
        ]);
        $table->addColumn('comment', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('address', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('status', 'integer', [
            'default' => null,
            'limit' => 1,
            'null' => true,
        ]);
        $table->create();
    }
}
