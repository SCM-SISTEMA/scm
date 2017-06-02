<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TabAtividade;

/**
 * TabAtividadeSearch represents the model behind the search form about `app\models\TabAtividade`.
 */
class TabAtividadeSearch extends TabAtividade
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
        $query = TabAtividadeSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_atividade' => $this->cod_atividade,
            $this->tableName() . '.primario' => $this->primario,
            $this->tableName() . '.cod_cliente_fk' => $this->cod_cliente_fk,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.descricao', $this->descricao])
            ->andFilterWhere(['ilike', $this->tableName() . '.codigo', $this->codigo]);

		$query->andWhere($this->tableName().'.dt_exclusao IS NULL');
		
        return $dataProvider;
    }
}
