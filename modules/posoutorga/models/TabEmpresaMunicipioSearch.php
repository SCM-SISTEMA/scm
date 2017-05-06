<?php

namespace app\modules\posoutorga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\posoutorga\models\TabEmpresaMunicipio;

/**
 * TabEmpresaMunicipioSearch represents the model behind the search form about `app\modules\posoutorga\models\TabEmpresaMunicipio`.
 */
class TabEmpresaMunicipioSearch extends TabEmpresaMunicipio
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
                $labels = parent::attributeLabels();

		$labels['cod_municipio_fk'] = 'Município';
                $labels['uf'] = 'UF';
		
		return $labels;
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
        $query = TabEmpresaMunicipioSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_empresa_municipio' => $this->cod_empresa_municipio,
            $this->tableName() . '.capacidade_municipio' => $this->capacidade_municipio,
            $this->tableName() . '.capacidade_servico' => $this->capacidade_servico,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.tecnologia', $this->tecnologia])
            ->andFilterWhere(['ilike', $this->tableName() . '.cod_municipio_fk', $this->cod_municipio_fk])
            ->andFilterWhere(['ilike', $this->tableName() . '.municipio', $this->municipio])
            ->andFilterWhere(['ilike', $this->tableName() . '.uf', $this->uf]);

		$query->andWhere($this->tableName().'.dt_exclusao IS NULL');
		
        return $dataProvider;
    }
}
