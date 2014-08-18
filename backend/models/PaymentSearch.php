<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Payment;

/**
 * PaymentSearch represents the model behind the search form about `backend\models\Payment`.
 */
class PaymentSearch extends Payment
{
    public function rules()
    {
        return [
            [['id_payment', 'ticket_id', 'qty', 'user_id'], 'integer'],
            [['date','user.username'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Payment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //effettuo join con la tabella user (mi serve per poter rilevare l'username di chi ha fatto il pagamento)
        $query->joinWith('user',true);

        // enable sorting for the related column
        $dataProvider->sort->attributes['user.username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_payment' => $this->id_payment,
            'ticket_id' => $this->ticket_id,
            'date' => $this->date,
            'qty' => $this->qty,
            //'user_id' => $this->user_id,
        ]);
        //filtro i risultati per l'username
        $query->andFilterWhere(['LIKE', 'user.username', $this->user->username]);

        return $dataProvider;
    }
}
