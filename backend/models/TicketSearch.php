<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Ticket;
use yii\db\Query;

/**
 * TicketSearch represents the model behind the search form about `backend\models\Ticket`.
 */
class TicketSearch extends Ticket
{
    public function rules()
    {
        return [
            [['id_ticket', 'match_id'], 'integer'],
            [['label'], 'safe'],
            [['price'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Ticket::find();

        //start test
        /*$query = new Query();
        $query->select('*')
            ->from('ticket')
            ->innerJoin('match', 'match.id_match = ticket.match_id');*/
        //end test

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_ticket' => $this->id_ticket,
            'price' => $this->price,
            'match_id' => $this->match_id,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label]);

        return $dataProvider;
    }
}
