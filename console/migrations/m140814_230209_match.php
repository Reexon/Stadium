<?php

use yii\db\Schema;

class m140814_230209_match extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%match}}', [
            'id_match' => Schema::TYPE_PK,
            'home_team' => Schema::TYPE_STRING . '(32) NOT NULL',
            'guest_team' => Schema::TYPE_STRING . '(32) NOT NULL',
            'date' => Schema::TYPE_DATETIME . ' NOT NULL',
        ], $tableOptions);


    }

    public function down()
    {
        echo "m140814_230209_match cannot be reverted.\n";

        return false;
    }
}
