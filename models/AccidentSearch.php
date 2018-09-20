<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class AccidentSearch extends Accident
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'address', 'suffer_amount', 'loss_amount',], 'safe']
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = parent::find();

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
            ]
        );

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'region_code'  => (string)$this->region_code,
                'type'         => $this->type,
                'suffer_amount' => $this->suffer_amount,
                'loss_amount'  => $this->loss_amount,
            ]
        );

        return $dataProvider;
    }
}
