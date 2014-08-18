<?php

use yii\db\Schema;

class m140814_233226_ticket extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%ticket}}', [
            'id_ticket' => Schema::TYPE_PK,
            'label' => Schema::TYPE_STRING . '(50) NOT NULL',
            'price' => Schema::TYPE_FLOAT . ' NOT NULL',
            'description' => Schema::TYPE_STRING . '(255) NOT NULL',
            'match_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey('FK_ticket', 'ticket', 'match_id', 'match', 'id_match');
    }

    public function down()
    {
        echo "m140814_233226_ticket cannot be reverted.\n";

        return false;
    }
}
