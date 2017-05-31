<?php

namespace app\modules\comercial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\comercial\models\TabSocios;

/**
 * TabSociosSearch represents the model behind the search form about `app\modules\comercial\models\TabSocios`.
 */
class TabSociosSearch extends TabSocios
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
        $query = TabSociosSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_socio' => $this->cod_socio,
            $this->tableName() . '.estado_civil_fk' => $this->estado_civil_fk,
            $this->tableName() . '.cod_cliente_fk' => $this->cod_cliente_fk,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.nome', $this->nome])
            ->andFilterWhere(['ilike', $this->tableName() . '.nacionalidade', $this->nacionalidade])
            ->andFilterWhere(['ilike', $this->tableName() . '.profissao', $this->profissao])
            ->andFilterWhere(['ilike', $this->tableName() . '.rg', $this->rg])
            ->andFilterWhere(['ilike', $this->tableName() . '.orgao_uf', $this->orgao_uf])
            ->andFilterWhere(['ilike', $this->tableName() . '.cpf', $this->cpf])
            ->andFilterWhere(['ilike', $this->tableName() . '.qual', $this->qual]);

		$query->andWhere($this->tableName().'.dt_exclusao IS NULL');
		
        return $dataProvider;
    }
}
