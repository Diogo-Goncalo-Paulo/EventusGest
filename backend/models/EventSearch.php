<?php

namespace app\models;

use DateTime;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Event;
use yii\helpers\VarDumper;
use function GuzzleHttp\Psr7\str;

/**
 * EventSearch represents the model behind the search form of `app\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'default_area'], 'integer'],
            [['name', 'startDate', 'endDate', 'createdAt', 'updateAt', 'deletedAt'], 'safe'],
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
        $query = Event::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        if(isset($params['EventSearch']['startDate']) && $params['EventSearch']['startDate'] > 0)
            $params['EventSearch']['startDate'] = date('Y-m-d H:i:s', strtotime($params['EventSearch']['startDate']));

        if(isset($params['EventSearch']['endDate']) && $params['EventSearch']['endDate'] > 0)
            $params['EventSearch']['endDate'] = date('Y-m-d H:i:s', strtotime($params['EventSearch']['endDate']));


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'createdAt' => $this->createdAt,
            'updateAt' => $this->updateAt,
            'deletedAt' => $this->deletedAt,
            'default_area' => $this->default_area,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
