<?php

namespace frontend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Client;

class ClientSearch extends Client
{
    public $date_range;
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['full_name', 'gender', 'date_range', 'date_from', 'date_to'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Client::find()->with('clubs');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['gender' => $this->gender])
            ->andFilterWhere(['>=', 'birth_date', $this->date_from])
            ->andFilterWhere(['<=', 'birth_date', $this->date_to]);

        $query->andWhere(['deleted_at' => null]);

        return $dataProvider;
    }
}