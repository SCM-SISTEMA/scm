<?php

namespace app\modules\posoutorga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\posoutorga\models\TabPlanos;

/**
 * TabPlanosSearch represents the model behind the search form about `app\modules\posoutorga\models\TabPlanos`.
 */
class TabPlanosSearch extends TabPlanos {

    /**
     * @inheritdoc
     */
    public $total_fisica;
    public $total_juridica;
    public $total_512;
    public $total_512k_2m;
    public $total_2m_12m;
    public $total_12m_34m;
    public $total_34m;
    public $total;
    public $tipo_plano_sgl;

    public function rules() {
        return [
            [['valor_512', 'valor_512k_2m', 'valor_2m_12m', 'valor_12m_34m', 'valor_34m'], 'number'],
            [['obs'], 'string'],
            [['tipo_plano_fk', 'tipo_plano_sgl'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        $labels = [
                //exemplo 'campo' => 'label',         
        ];

        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = TabPlanosSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_plano' => $this->cod_plano,
            $this->tableName() . '.valor_512' => $this->valor_512,
            $this->tableName() . '.valor_512k_2m' => $this->valor_512k_2m,
            $this->tableName() . '.valor_2m_12m' => $this->valor_2m_12m,
            $this->tableName() . '.valor_12m_34m' => $this->valor_12m_34m,
            $this->tableName() . '.valor_34m' => $this->valor_34m,
            $this->tableName() . '.tipo_plano_fk' => $this->tipo_plano_fk,
            $this->tableName() . '.cod_chave' => $this->cod_chave,
            $this->tableName() . '.tipo_tabela_fk' => $this->tipo_tabela_fk,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.obs', $this->obs]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    public static function getITEM9($cod_sici, $tipo_tabela_fk) {
        $planos = \app\modules\posoutorga\models\TabPlanosSearch::find()->select(' valor_512, valor_512k_2m, valor_2m_12m, valor_12m_34m, 
       valor_34m, (SELECT sgl_valor
  FROM public.tab_atributos_valores
  where cod_atributos_valores=tipo_plano_fk) as tipo_plano_sgl')->where(['cod_chave' => $cod_sici, 'tipo_tabela_fk' => $tipo_tabela_fk])->orderBy('tipo_plano_sgl')->asArray()->all();


        foreach ($planos as $valor) {

            foreach ($valor as $key => $value) {
                if ($key == 'tipo_plano_sgl')
                    continue;
                switch ($key) {
                    case 'valor_512': $item = 'a';
                        break;
                    case 'valor_512k_2m': $item = 'b';
                        break;
                    case 'valor_2m_12m': $item = 'c';
                        break;
                    case 'valor_12m_34m': $item = 'd';
                        break;
                    case 'valor_34m': $item = 'e';
                        break;
                }

                $dados[$valor['tipo_plano_sgl']][$item] = $value;
            }
        }
        return $dados;
    }

}
