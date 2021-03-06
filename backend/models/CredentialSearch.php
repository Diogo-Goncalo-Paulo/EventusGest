<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Credential;

/**
 * CredentialSearch represents the model behind the search form of `app\models\Credential`.
 */
class CredentialSearch extends Credential
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idEntity', 'idCurrentArea', 'idEvent', 'flagged', 'blocked'], 'integer'],
            [['ucid', 'createdAt', 'updatedAt', 'deletedAt'], 'safe'],
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
        $query = Credential::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ucid' => $this->ucid,
            'idEntity' => $this->idEntity,
            'idCurrentArea' => $this->idCurrentArea,
            'idEvent' => $this->idEvent,
            'flagged' => $this->flagged,
            'blocked' => $this->blocked,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'deletedAt' => $this->deletedAt,
        ]);

        $query->andFilterWhere(['like', 'ucid', $this->ucid]);

        $query->andFilterWhere(['deletedAt' => null]);

        return $dataProvider;
    }
}
