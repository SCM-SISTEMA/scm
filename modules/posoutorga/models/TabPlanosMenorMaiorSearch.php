<?php

namespace app\modules\posoutorga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\posoutorga\models\TabPlanosMenorMaior;

/**
 * TabPlanosMenorMaiorSearch represents the model behind the search form about `app\modules\posoutorga\models\TabPlanosMenorMaior`.
 */
class TabPlanosMenorMaiorSearch extends TabPlanosMenorMaior {

    /**
     * @inheritdoc
     */
    public function rules() {

        $rules = [
            [['valor_menos_1m_ded_check',
            'valor_menos_1m_check', 'valor_maior_1m_ded_check', 'valor_maior_1m_check'], 'safe'],
        ];

        return array_merge($rules, parent::rules());
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

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    public static function getIEM10($cod_sici) {
        $planos = \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch::find()->select('valor_menos_1m, valor_menos_1m_ded, valor_maior_1m ,valor_maior_1m_ded 
       , (SELECT sgl_valor
  FROM public.tab_atributos_valores
  where cod_atributos_valores=tipo_plano_fk) as tipo_plano_sgl')->where(['cod_sici_fk' => $cod_sici])->orderBy('tipo_plano_sgl')->asArray()->all();


        foreach ($planos as $valor) {

            foreach ($valor as $key => $value) {
                if ($key == 'tipo_plano_sgl')
                    continue;
                switch ($key) {
                    case 'valor_menos_1m': $item = 'a';
                        break;
                    case 'valor_menos_1m_ded': $item = 'b';
                        break;
                    case 'valor_maior_1m': $item = 'c';
                        break;
                    case 'valor_maior_1m_ded': $item = 'd';
                        break;
                }

                $dados[$valor['tipo_plano_sgl']][$item] = $value;
            }
        }

        return $dados;
    }

    public function setIEM10($dom, $tipo_plano_sgl) {

        foreach ($dom->getElementsByTagName('Pessoa') as $pessoa) {

            if ($pessoa->getAttribute('item') == $tipo_plano_sgl) {
                $this->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', $tipo_plano_sgl);
                foreach ($pessoa->getElementsByTagName('Conteudo') as $conteudo) {
                    $key = $conteudo->getAttribute('item');
                    switch ($key) {
                        case 'a': $this->valor_menos_1m = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                            break;
                        case 'b': $this->valor_menos_1m_ded = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                            break;
                        case 'c': $this->valor_maior_1m = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                            break;
                        case 'd': $this->valor_maior_1m_ded = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                            break;
                    }
                }
            }
        }
    }



}
