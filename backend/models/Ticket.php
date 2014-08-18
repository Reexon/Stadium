<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property integer $id_ticket
 * @property string $label
 * @property double $price
 * @property integer $match_id
 *
 * @property Match $match
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'price', 'match_id'], 'required'],
            [['price'], 'number'],
            [['match_id'], 'integer'],
            [['label'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ticket' => 'Id Ticket',
            'label' => 'Label',
            'price' => 'Price',
            'match_id' => 'Match ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatch()
    {
        return $this->hasOne(Match::className(), ['id_match' => 'match_id']);
    }

}
