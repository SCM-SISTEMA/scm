<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TabContato;

/**
 * ContatoSearch represents the model behind the search form about `app\models\TabContato`.
 */
class ContatoSearch extends TabContato
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
        $query = ContatoSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_contato' => $this->cod_contato,
            $this->tableName() . '.ativo' => $this->ativo,
            $this->tableName() . '.dt_inclusao' => $this->dt_inclusao,
            $this->tableName() . '.tipo' => $this->tipo,
            $this->tableName() . '.tipo_usuario' => $this->tipo_usuario,
            $this->tableName() . '.chave_fk' => $this->chave_fk,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.contato', $this->contato])
            ->andFilterWhere(['ilike', $this->tableName() . '.ramal', $this->ramal]);

		$query->andWhere($this->tableName().'.dt_exclusao IS NULL');
		
        return $dataProvider;
    }
}
