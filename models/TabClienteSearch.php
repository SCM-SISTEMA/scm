<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TabCliente;

/**
 * TabClienteSearch represents the model behind the search form about `app\models\TabCliente`.
 */
class TabClienteSearch extends TabCliente {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['dt_inclusao', 'dt_exclusao'], 'safe'],
            [['situacao'], 'boolean'],
            [['cnpj'], 'string', 'max' => 18],
            [['fantasia', 'razao_social'], 'string', 'max' => 200]
        ];

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        $labels =   parent::attributeLabels();
            $labels['cnpj'] = 'CNPJ';
            $labels['ie'] = 'Inscrição Estadual';
            $labels['fantasia'] = 'Fantasia';
            $labels['razao_social'] =  'Razão Social';
            $labels['situacao'] = 'Ativo?';
        
        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = TabClienteSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.ie' => $this->ie,
            $this->tableName() . '.dt_inclusao' => $this->dt_inclusao,
            $this->tableName() . '.dt_exclusao' => $this->dt_exclusao,
            $this->tableName() . '.cod_cliente' => $this->cod_cliente,
            $this->tableName() . '.situacao' => $this->situacao,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.cnpj', $this->cnpj])
                ->andFilterWhere(['ilike', $this->tableName() . '.fantasia', $this->fantasia])
                ->andFilterWhere(['ilike', $this->tableName() . '.razao_social', $this->razao_social]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

}
