<?php
use Migrations\AbstractMigration;

class AlterCharset2 extends AbstractMigration
{
    function tables(){
        return [
            'answers', 'avatars','cake_d_c_users_phinxlog','cats','cat_images','comments','favorites','notifications',
            'phinxlog','questions','response_statuses',/*'social_accounts','users'*/
        ];
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        
        $tables = $this->tables();
        foreach($tables as $table){
            
            $result = $this->execute('ALTER TABLE `'.$table.'` ROW_FORMAT = DYNAMIC;');
        }
         foreach($tables as $table){
            
            $result = $this->execute('ALTER TABLE `'.$table.'` CONVERT TO CHARACTER SET utf8mb4;');
        }

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $tables = $this->tables();
        foreach($tables as $table){
            $result = $this->execute('ALTER TABLE `'.$table.'` ROW_FORMAT = COMPACT;');
        }
         foreach($tables as $table){
            $result = $this->execute('ALTER TABLE `'.$table.'` CONVERT TO CHARACTER SET utf8;');
        }
    }
}
