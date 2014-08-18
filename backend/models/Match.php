<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "match".
 *
 * @property integer $id_match
 * @property string $home_team
 * @property string $guest_team
 * @property string $date
 */
class Match extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'match';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['home_team', 'guest_team', 'date'], 'required'],
            [['date'], 'safe'],
            [['home_team', 'guest_team'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_match' => 'Id Match',
            'home_team' => 'Home Team',
            'guest_team' => 'Guest Team',
            'date' => 'Date',
        ];
    }

    public function beforeSave($insert)
    {
        // convert to storage format
        $this->date = date("Y-m-d H:i:s",strtotime($this->date));

        if (parent::beforeSave($insert)) {
            return true;
        } else {
            return false;
        }
    }
    public function afterFind(){
        //Each Time Select From db, need to convert TIMESTAMP->DATE
        $this->date = date("d/m/Y",strtotime($this->date));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['match_id' => 'id_match']);
    }
}
