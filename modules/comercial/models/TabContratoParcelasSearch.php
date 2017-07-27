<?php

namespace app\modules\comercial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\comercial\models\TabContratoParcelas;

/**
 * TabContratoParcelasSearch represents the model behind the search form about `app\modules\comercial\models\TabContratoParcelas`.
 */
class TabContratoParcelasSearch extends TabContratoParcelas {

    /**
     * @inheritdoc
     */
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
        $query = TabContratoParcelasSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_contrato_parcelas' => $this->cod_contrato_parcelas,
            $this->tableName() . '.cod_contrato_fk' => $this->cod_contrato_fk,
            $this->tableName() . '.numero' => $this->numero,
            $this->tableName() . '.valor' => $this->valor,
            $this->tableName() . '.dt_inclusao' => $this->dt_inclusao,
            $this->tableName() . '.dt_vencimento' => $this->dt_vencimento,
            $this->tableName() . '.dt_alteracao' => $this->dt_alteracao,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.txt_login_inclusao', $this->txt_login_inclusao])
                ->andFilterWhere(['ilike', $this->tableName() . '.txt_login_alteracao', $this->txt_login_alteracao]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    public static function salvarContratoParcelas($parcelas, $model) {

        TabContratoParcelasSearch::deleteAll('cod_contrato_fk=' . $model->cod_contrato);

        foreach ($parcelas as $skey => $par) {
            $parcelas = new \app\modules\comercial\models\TabContratoParcelasSearch();
            $parcelas->attributes = $par;
            $parcelas->dt_vencimento = date('d-m-Y');
            $parcelas->cod_contrato_fk = (int) $model->cod_contrato;
            $parcelas->save();
        }
    }
    
}
