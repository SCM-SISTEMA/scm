<?php

namespace app\modules\posoutorga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\posoutorga\models\TabSici;

/**
 * TabSiciSearch represents the model behind the search form about `app\modules\posoutorga\models\TabSici`.
 */
class TabSiciSearch extends TabSici {

    /**
     * @inheritdoc
     */
    public $total_aliquota;
    public $total_icms;
    public $total_pis;
    public $total_confins;
    public $total_despesa;
    public $total_planta;
    public $file;

    public function rules() {

        $rules = [
            [['file'], 'safe'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xls, xlsx'],
        ];

        return $rules;
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
        $query = TabSiciSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_sici' => $this->cod_sici,
            $this->tableName() . '.cod_tipo_contrato_fk' => $this->cod_tipo_contrato_fk,
            $this->tableName() . '.receita_bruta' => $this->receita_bruta,
            $this->tableName() . '.despesa_operacao_manutencao' => $this->despesa_operacao_manutencao,
            $this->tableName() . '.despesa_publicidade' => $this->despesa_publicidade,
            $this->tableName() . '.despesa_vendas' => $this->despesa_vendas,
            $this->tableName() . '.despesa_link' => $this->despesa_link,
            $this->tableName() . '.aliquota_nacional' => $this->aliquota_nacional,
            $this->tableName() . '.receita_icms' => $this->receita_icms,
            $this->tableName() . '.receita_pis' => $this->receita_pis,
            $this->tableName() . '.receita_confins' => $this->receita_confins,
            $this->tableName() . '.receita_liquida' => $this->receita_liquida,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.mes_ano_referencia', $this->mes_ano_referencia])
                ->andFilterWhere(['ilike', $this->tableName() . '.fust', $this->fust])
                ->andFilterWhere(['ilike', $this->tableName() . '.obs_receita', $this->obs_receita])
                ->andFilterWhere(['ilike', $this->tableName() . '.obs_despesa', $this->obs_despesa]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    public function array1() {
        
    }

}
