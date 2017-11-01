<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TabSetores;

/**
 * TabSetoresSearch represents the model behind the search form about `app\models\TabSetores`.
 */
class TabSetoresSearch extends TabSetores
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
        $query = TabSetoresSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_setor' => $this->cod_setor,
            $this->tableName() . '.cod_tipo_contrato_fk' => $this->cod_tipo_contrato_fk,
            $this->tableName() . '.cod_usuario_responsavel_fk' => $this->cod_usuario_responsavel_fk,
            $this->tableName() . '.cod_tipo_setor_fk' => $this->cod_tipo_setor_fk,
            $this->tableName() . '.dt_inclusao' => $this->dt_inclusao,
            $this->tableName() . '.dt_exclusao' => $this->dt_exclusao,
        ]);

		$query->andWhere($this->tableName().'.dt_exclusao IS NULL');
		
        return $dataProvider;
    }
}
