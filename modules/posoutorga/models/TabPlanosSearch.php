<?php

namespace app\modules\posoutorga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\posoutorga\models\TabPlanos;

/**
 * TabPlanosSearch represents the model behind the search form about `app\modules\posoutorga\models\TabPlanos`.
 */
class TabPlanosSearch extends TabPlanos {

    /**
     * @inheritdoc
     */
    public $total_fisica;
    public $total_juridica;
    public $total_512;
    public $total_512k_2m;
    public $total_2m_12m;
    public $total_12m_34m;
    public $total_34m;
    public $total;

    public function rules() {

        $rules = [
                //exemplo [['txt_nome', 'cod_modulo_fk'], 'required'],
        ];

        return array_merge($rules, parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        $labels = [
                //exemplo 'campo' => 'label',         
        ];

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
        $query = TabPlanosSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_plano' => $this->cod_plano,
            $this->tableName() . '.valor_512' => $this->valor_512,
            $this->tableName() . '.valor_512k_2m' => $this->valor_512k_2m,
            $this->tableName() . '.valor_2m_12m' => $this->valor_2m_12m,
            $this->tableName() . '.valor_12m_34m' => $this->valor_12m_34m,
            $this->tableName() . '.valor_34m' => $this->valor_34m,
            $this->tableName() . '.tipo_plano_fk' => $this->tipo_plano_fk,
            $this->tableName() . '.cod_chave' => $this->cod_chave,
            $this->tableName() . '.tipo_tabela_fk' => $this->tipo_tabela_fk,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.obs', $this->obs]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

}
