<?php

namespace frontend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Club;

class ClubSearch extends Club
{
    public $archive = false;

    public function rules()
    {
        return [
            [['name', 'archive'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Club::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        if (!$this->archive) {
            $query->andWhere(['deleted_at' => null]);
        }

        return $dataProvider;
    }
}