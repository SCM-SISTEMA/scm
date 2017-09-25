<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TabAndamento;

/**
 * TabAndamentoSearch represents the model behind the search form about `app\models\TabAndamento`.
 */
class TabAndamentoSearch extends TabAndamento {

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

        $labels = parent::attributeLabels();
        $labels['cod_assunto_fk']='Tipo Andamento';
        

        return $labels;
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
        $query = TabAndamentoSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_andamento' => $this->cod_andamento,
            $this->tableName() . '.cod_assunto_fk' => $this->cod_assunto_fk,
            $this->tableName() . '.dt_inclusao' => $this->dt_inclusao,
            $this->tableName() . '.dt_exclusao' => $this->dt_exclusao,
            $this->tableName() . '.cod_tipo_contrato_fk' => $this->cod_tipo_contrato_fk,
            $this->tableName() . '.cod_contrato_fk' => $this->cod_contrato_fk,
            $this->tableName() . '.dt_retorno' => $this->dt_retorno,
            $this->tableName() . '.cod_modulo_fk' => $this->cod_modulo_fk,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.txt_notificacao', $this->txt_notificacao]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

}
