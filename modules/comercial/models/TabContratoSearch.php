<?php

namespace app\modules\comercial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\comercial\models\TabContrato;

/**
 * TabContratoSearch represents the model behind the search form about `app\modules\comercial\models\TabContrato`.
 */
class TabContratoSearch extends TabContrato
{
    /**
     * @inheritdoc
     */ 
    public function rules()
    {

		$rules =  [
             //exemplo [['txt_nome', 'cod_modulo_fk'], 'required'],
        ];
		
		return array_merge($rules, parent::rules());
    }
	
	/**
    * @inheritdoc
    */
	public function attributeLabels()
    {

		$labels = [
            //exemplo 'campo' => 'label',         
        ];
		
		return array_merge( parent::attributeLabels(), $labels);
    }
	
    /**
     * @inheritdoc
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
        $query = TabContratoSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_contrato' => $this->cod_contrato,
            $this->tableName() . '.tipo_contrato_fk' => $this->tipo_contrato_fk,
            $this->tableName() . '.valor_contrato' => $this->valor_contrato,
            $this->tableName() . '.dia_vencimento' => $this->dia_vencimento,
            $this->tableName() . '.qnt_parcelas' => $this->qnt_parcelas,
            $this->tableName() . '.dt_prazo' => $this->dt_prazo,
        ]);

		$query->andWhere($this->tableName().'.dt_exclusao IS NULL');
		
        return $dataProvider;
    }
}
