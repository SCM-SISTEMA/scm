<?php

namespace app\modules\comercial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\comercial\models\TabRepresentanteComercial;

/**
 * TabRepresentanteComercialSearch represents the model behind the search form about `app\modules\comercial\models\TabRepresentanteComercial`.
 */
class TabRepresentanteComercialSearch extends TabRepresentanteComercial
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
        $query = TabRepresentanteComercialSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_representante_comercial' => $this->cod_representante_comercial,
            $this->tableName() . '.estado_civil_fk' => $this->estado_civil_fk,
            $this->tableName() . '.dt_nascimento' => $this->dt_nascimento,
            $this->tableName() . '.cod_cliente_fk' => $this->cod_cliente_fk,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.nome', $this->nome])
            ->andFilterWhere(['ilike', $this->tableName() . '.nacionalidade', $this->nacionalidade])
            ->andFilterWhere(['ilike', $this->tableName() . '.profissao', $this->profissao])
            ->andFilterWhere(['ilike', $this->tableName() . '.cpf', $this->cpf])
            ->andFilterWhere(['ilike', $this->tableName() . '.rg', $this->rg])
            ->andFilterWhere(['ilike', $this->tableName() . '.secretaria', $this->secretaria])
            ->andFilterWhere(['ilike', $this->tableName() . '.contador', $this->contador]);

		$query->andWhere($this->tableName().'.dt_exclusao IS NULL');
		
        return $dataProvider;
    }
}
