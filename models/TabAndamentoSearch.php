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

    public $cod_contrato;

    /**
     * @inheritdoc
     */
    public function rules() {
        
        $rules = [
            [['cod_contrato'], 'safe'],
        ];

        return array_merge($rules, parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        $labels = parent::attributeLabels();
        $labels['txt_notificacao'] = 'Andamento';
        $labels['dt_retorno'] = 'Dt. retorno';


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
            $this->tableName() . '.dt_inclusao' => $this->dt_inclusao,
            $this->tableName() . '.dt_exclusao' => $this->dt_exclusao,
            $this->tableName() . '.dt_retorno' => $this->dt_retorno,
            $this->tableName() . '.cod_usuario_inclusao_fk' => $this->cod_usuario_inclusao_fk,
            $this->tableName() . '.cod_setor_fk' => $this->cod_setor_fk,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.txt_notificacao', $this->txt_notificacao]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

}
