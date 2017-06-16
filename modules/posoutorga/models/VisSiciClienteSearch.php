<?php

namespace app\modules\posoutorga\models;

use Yii;

class VisSiciClienteSearch extends VisSiciCliente {

    /**
     * @inheritdoc
     */
    public function rules() {

        $rules = [
        ];

        return array_merge($rules, parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        $labels = [
            'usuario_inclusao_sici' => 'Usuário',
            'cnpj' => 'CNPJ',
            'razao_social' => 'Razão Social',
            'dsc_situacao' => 'Situação',
           // 'cod_protocolo' => 'Protocolo'
                //exemplo 'campo' => 'label',         
        ];

        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $ordem = 'cod_sici desc') {
        $query = VisSiciClienteSearch::find();

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_cliente' => $this->cod_cliente,
       
            $this->tableName() . '.situacao_sigla' => $this->dsc_situacao,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.razao_social', $this->razao_social])
                ->andFilterWhere(['ilike', $this->tableName() . '.cnpj', $this->cnpj])
                ->andFilterWhere(['ilike', $this->tableName() . 'usuario_inclusao_sici', $this->usuario_inclusao_sici])
                ->andFilterWhere(['ilike', $this->tableName() . '.fistel', $this->fistel])
                ->andFilterWhere(['ilike', $this->tableName() . '.mes_ano_referencia', $this->mes_ano_referencia]);
        
        $query->orderBy($ordem);
        

        return $dataProvider;
    }

}
