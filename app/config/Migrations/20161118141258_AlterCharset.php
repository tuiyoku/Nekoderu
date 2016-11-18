<?php
use Migrations\AbstractMigration;

class AlterCharset extends AbstractMigration
{
    function tables(){
        return [
            'answers', 'avatars','cake_d_c_users_phinxlog','cats','cat_images','comments','favorites','notifications',
            'phinxlog','questions','response_statuses','social_accounts','users'
        ];
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        // execute()
        $result = $this->execute('ALTER DATABASE '.env('DB_DATABASE').' CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;'); 
        
        $tables = $this->tables();
        foreach($tables as $table){
            $result = $this->execute('ALTER TABLE '.$table.' DEFAULT CHARACTER SET utf8mb4;');
        }

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $result = $this->execute('ALTER DATABASE '.env('DB_DATABASE').' CHARACTER SET utf8 COLLATE utf8_general_ci;'); // returns the number of affected rows
        
        $tables = $this->tables();
        foreach($tables as $table){
            $result = $this->execute('ALTER TABLE '.$table.' DEFAULT CHARACTER SET utf8;');
        }
    }
}
