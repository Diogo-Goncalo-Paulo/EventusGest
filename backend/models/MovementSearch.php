<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Movement;

/**
 * MovementSearch represents the model behind the search form of `app\models\Movement`.
 */
class MovementSearch extends Movement
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idCredential', 'idAccessPoint', 'idAreaFrom', 'idAreaTo', 'idUser'], 'integer'],
            [['time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Movement::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'time' => SORT_DESC,
                ]
            ],
        ]);



        if(isset($params['MovementSearch']['time']) && $params['MovementSearch']['time'] > 0)
            $params['MovementSearch']['time'] = date('Y-m-d H:i:s', strtotime($params['MovementSearch']['time']));
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'time' => $this->time,
            'idCredential' => $this->idCredential,
            'idAccessPoint' => $this->idAccessPoint,
            'idAreaFrom' => $this->idAreaFrom,
            'idAreaTo' => $this->idAreaTo,
            'idUser' => $this->idUser,
        ]);

        return $dataProvider;
    }
}
