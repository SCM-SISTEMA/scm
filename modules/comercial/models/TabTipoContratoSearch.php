<?php

namespace app\modules\comercial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\comercial\models\TabTipoContrato;

/**
 * TabTipoContratoSearch represents the model behind the search form about `app\modules\comercial\models\TabTipoContrato`.
 */
class TabTipoContratoSearch extends TabTipoContrato
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
        $query = TabTipoContratoSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_tipo_contrato' => $this->cod_tipo_contrato,
            $this->tableName() . '.cod_usuario_fk' => $this->cod_usuario_fk,
            $this->tableName() . '.cod_contrato_fk' => $this->cod_contrato_fk,
        ]);

		$query->andWhere($this->tableName().'.dt_exclusao IS NULL');
		
        return $dataProvider;
    }
}
