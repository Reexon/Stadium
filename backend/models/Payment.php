<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id_payment
 * @property integer $ticket_id
 * @property string $date
 * @property integer $qty
 * @property integer $user_id
 *
 * @property User $user
 * @property Ticket $ticket
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ticket_id', 'qty', 'user_id'], 'required'],
            [['ticket_id', 'qty', 'user_id'], 'integer'],
            [['date','user.username'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_payment' => 'Id Payment',
            'ticket_id' => 'Ticket ID',
            'date' => 'Date',
            'qty' => 'Qty',
            'user_id' => 'User ID',
            'user.username' =>'Username',
        ];
    }

    public function attributes(){
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['user.username']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['id_ticket' => 'ticket_id']);
    }
}
