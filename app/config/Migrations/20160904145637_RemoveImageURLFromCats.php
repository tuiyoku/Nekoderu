<?php
use Migrations\AbstractMigration;

class RemoveImageURLFromCats extends AbstractMigration
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
        $table->removeColumn('image_url');
        $table->update();
    }
}
