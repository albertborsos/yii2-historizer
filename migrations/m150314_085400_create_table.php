<?php

use yii\db\Schema;
use yii\db\Migration;

class m150314_085400_create_table extends Migration
{
    public function up()
    {
        $this->createTable('ext_historizer_archives', [
            'id' => 'pk',
            'model_class' => "VARCHAR(512)",
            'model_id' => 'integer',
            'model_attributes' => 'text',
            "created_at" => "integer",
            "created_user" => "integer",
            "updated_at" => "integer",
            "updated_user" => "integer",
            "status" => "VARCHAR(1)",
        ]);
    }

    public function down()
    {
        $this->dropTable('ext_historizer_archives');
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
