<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Match;

/**
 * MatchSearch represents the model behind the search form about `backend\models\Match`.
 */
class MatchSearch extends Match
{
    public function rules()
    {
        return [
            [['id_match'], 'integer'],
            [['home_team', 'guest_team', 'date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Match::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_match' => $this->id_match,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'home_team', $this->home_team])
            ->andFilterWhere(['like', 'guest_team', $this->guest_team]);

        return $dataProvider;
    }
}
