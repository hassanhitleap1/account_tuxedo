<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalesEmployees;

/**
 * SalesEmployeesSearch represents the model behind the search form of `app\models\SalesEmployees`.
 */
class SalesEmployeesSearch extends SalesEmployees
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'tiger'], 'integer'],
            [['amount'], 'number'],
            [['note', 'date', 'created_at', 'updated_at'], 'safe'],
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
        $query = SalesEmployees::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'amount' => $this->amount,
            'tiger' => $this->tiger,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        if (isset($_GET['date_range']) && $_GET['date_range'] != '') {
            echo $_GET['date_range'];
            $dataRange = explode("+", $_GET['date_range']);

            $query->andWhere(['between', 'date', $dataRange[0], $dataRange[1]]);

        }

        $query->andFilterWhere(['like', 'note', $this->note])->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
