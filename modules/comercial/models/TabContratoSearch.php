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
            $this->tableName() . '.dt_inclusao' => $this->dt_inclusao,
            $this->tableName() . '.dt_vencimento' => $this->dt_vencimento,
            $this->tableName() . '.responsavel_fk' => $this->responsavel_fk,
            $this->tableName() . '.operando' => $this->operando,
            $this->tableName() . '.qnt_clientes' => $this->qnt_clientes,
            $this->tableName() . '.link' => $this->link,
            $this->tableName() . '.zero800' => $this->zero800,
            $this->tableName() . '.parceiria' => $this->parceiria,
            $this->tableName() . '.consultoria_scm' => $this->consultoria_scm,
            $this->tableName() . '.engenheiro_tecnico' => $this->engenheiro_tecnico,
            $this->tableName() . '.cod_cliente_fk' => $this->cod_cliente_fk,
            $this->tableName() . '.ativo' => $this->ativo,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.contador', $this->contador]);

		$query->andWhere($this->tableName().'.dt_exclusao IS NULL');
		
        return $dataProvider;
    }
}
