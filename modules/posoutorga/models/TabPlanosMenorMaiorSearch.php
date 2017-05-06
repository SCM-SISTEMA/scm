<?php

namespace app\modules\posoutorga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\posoutorga\models\TabPlanosMenorMaior;

/**
 * TabPlanosMenorMaiorSearch represents the model behind the search form about `app\modules\posoutorga\models\TabPlanosMenorMaior`.
 */
class TabPlanosMenorMaiorSearch extends TabPlanosMenorMaior
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
        $query = TabPlanosMenorMaiorSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_plano_menor_maior' => $this->cod_plano_menor_maior,
            $this->tableName() . '.valor_menos_1m_ded' => $this->valor_menos_1m_ded,
            $this->tableName() . '.valor_menos_1m' => $this->valor_menos_1m,
            $this->tableName() . '.valor_maior_1m_ded' => $this->valor_maior_1m_ded,
            $this->tableName() . '.valor_maior_1m' => $this->valor_maior_1m,
            $this->tableName() . '.cod_plano_fk' => $this->cod_plano_fk,
        ]);

		$query->andWhere($this->tableName().'.dt_exclusao IS NULL');
		
        return $dataProvider;
    }
}
