<?php

use yii\db\Schema;

class m140816_085331_payment extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%payment}}', [
            'id_payment' => Schema::TYPE_PK,
            'ticket_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'date' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP NOT NULL',
            'qty' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey('FK_payment_ticket', 'payment', 'ticket_id', 'ticket', 'id_ticket');
        $this->addForeignKey('FK_payment_user', 'payment', 'user_id', 'user', 'id');
    }

    public function down()
    {
        echo "m140816_085331_payment cannot be reverted.\n";

        return false;
    }
}
