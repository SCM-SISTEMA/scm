<?php

namespace app\modules\posoutorga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\posoutorga\models\TabEmpresaMunicipio;

/**
 * @property TabMunicipios $tabMunicipios
 * TabEmpresaMunicipioSearch represents the model behind the search form about `app\modules\posoutorga\models\TabEmpresaMunicipio`.
 */
class TabEmpresaMunicipioSearch extends TabEmpresaMunicipio {

    public $total_fisica;
    public $total_juridica;
    public $total_512;
    public $total_512k_2m;
    public $total_2m_12m;
    public $total_12m_34m;
    public $total_34m;
    public $total;
    public $tipo_pessoa;
    public $gridMunicipios;

    /**
     * @inheritdoc
     */
    public function rules() {

        $rules = [
                //exemplo [['txt_nome', 'cod_modulo_fk'], 'required'],
        ];

        return array_merge($rules, parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $labels = parent::attributeLabels();

        $labels['cod_municipio_fk'] = 'Município';
        $labels['uf'] = 'UF';
        $labels['tecnologia_fk'] = 'Tecnologia';

        return $labels;
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

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabMunicipios() {
        return $this->hasOne(\app\models\TabMunicipios::className(), ['cod_municipio' => 'cod_municipio_fk']);
    }

    public static function buscaPlanoEmpresasTecnologia($cod_sici) {
        $empresa_municipio = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()
                        ->where(['cod_sici_fk' => $cod_sici])->all();

        foreach ($empresa_municipio as $key => $value) {

            $planom = \app\modules\posoutorga\models\TabPlanosSearch::find()
                    ->select('
                    valor_512, valor_512k_2m, valor_2m_12m,valor_12m_34m,valor_34m, 
                    (valor_512+valor_512k_2m+ valor_2m_12m+valor_12m_34m+valor_34m) as total, 
                    (SELECT sgl_valor FROM public.tab_atributos_valores where cod_atributos_valores=tipo_plano_fk) as tipo_plano_sgl')
                    ->where(['cod_chave' => $value->cod_empresa_municipio, 'tipo_tabela_fk' => $value->tableName()])
                    ->orderBy('tipo_plano_sgl')
                    ->asArray()
                    ->all();

            foreach ($planom as $pla) {
                $planoEmpresa[$value->tabMunicipios->cod_ibge][$value->tecnologia_fk][$pla['tipo_plano_sgl']] = $pla;
            }
        }
        return $planoEmpresa;
    }

    public static function getIPL6IM($cod_sici) {
        $empresa_municipio = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()
                        ->where(['cod_sici_fk' => $cod_sici])->all();

        foreach ($empresa_municipio as $munK => $municipio) {
            $planoEmpresa[$municipio->tabMunicipios->cod_ibge]['capacidade_municipio'] += $municipio->capacidade_municipio;
            $planoEmpresa[$municipio->tabMunicipios->cod_ibge]['capacidade_servico'] += $municipio->capacidade_servico;
        }

        return $planoEmpresa;
    }

    public static function getQAIPL4SM($cod_sici) {
        $dados = TabEmpresaMunicipioSearch::buscaPlanoEmpresasTecnologia($cod_sici);

        foreach ($dados as $munK => $municipio) {
            foreach ($municipio as $tK => $tecnologia) {
                foreach ($tecnologia as $pk => $pessoa) {
                    $planos[$munK][$tK]['15'] += $pessoa['valor_512'];
                    $planos[$munK][$tK]['16'] += $pessoa['valor_512k_2m'];
                    $planos[$munK][$tK]['17'] += $pessoa['valor_2m_12m'];
                    $planos[$munK][$tK]['18'] += $pessoa['valor_12m_34m'];
                    $planos[$munK][$tK]['19'] += $pessoa['valor_34m'];
                    $planos[$munK][$tK]['total'] += $pessoa['total'];
                }
            }
        }

        return $planos;
    }

    public static function getIPL3($cod_sici) {

        $dados = TabEmpresaMunicipioSearch::buscaPlanoEmpresasTecnologia($cod_sici);

        foreach ($dados as $munK => $municipio) {
            foreach ($municipio as $tK => $tecnologia) {
                foreach ($tecnologia as $pk => $pessoa) {
                    $planos[$munK][$pk]['valor_512'] += $pessoa['valor_512'];
                    $planos[$munK][$pk]['valor_512k_2m'] += $pessoa['valor_512k_2m'];
                    $planos[$munK][$pk]['valor_2m_12m'] += $pessoa['valor_2m_12m'];
                    $planos[$munK][$pk]['valor_12m_34m'] += $pessoa['valor_12m_34m'];
                    $planos[$munK][$pk]['valor_34m'] += $pessoa['valor_34m'];
                    $planos[$munK][$pk]['total'] += $pessoa['total'];
                }
            }
        }

        return $planos;
    }

    public function calculaTotais($planof_municipio = null, $planoj_municipio = null) {


        $this->total_512 = \projeto\Util::decimalFormatForBank($planof_municipio->valor_512) +
                \projeto\Util::decimalFormatForBank($planoj_municipio->valor_512)
        ;
        
        $this->total_512k_2m = \projeto\Util::decimalFormatForBank($planof_municipio->valor_512k_2m) +
                \projeto\Util::decimalFormatForBank($planoj_municipio->valor_512k_2m)
        ;
        $this->total_2m_12m = \projeto\Util::decimalFormatForBank($planof_municipio->valor_2m_12m) +
                \projeto\Util::decimalFormatForBank($planoj_municipio->valor_2m_12m)
        ;

        $this->total_12m_34m = \projeto\Util::decimalFormatForBank($planof_municipio->valor_12m_34m) +
                \projeto\Util::decimalFormatForBank($planoj_municipio->valor_12m_34m)
        ;
        $this->total_34m = \projeto\Util::decimalFormatForBank($planof_municipio->valor_34m) +
                \projeto\Util::decimalFormatForBank($planoj_municipio->valor_34m)
        ;

        $this->total_fisica = \projeto\Util::decimalFormatForBank($planof_municipio->valor_512) +
                \projeto\Util::decimalFormatForBank($planof_municipio->valor_512k_2m) +
                \projeto\Util::decimalFormatForBank($planof_municipio->valor_2m_12m) +
                \projeto\Util::decimalFormatForBank($planof_municipio->valor_12m_34m) +
                \projeto\Util::decimalFormatForBank($planof_municipio->valor_34m)
        ;

        $this->total_juridica = \projeto\Util::decimalFormatForBank($planoj_municipio->valor_512) +
                \projeto\Util::decimalFormatForBank($planoj_municipio->valor_512k_2m) +
                \projeto\Util::decimalFormatForBank($planoj_municipio->valor_2m_12m) +
                \projeto\Util::decimalFormatForBank($planoj_municipio->valor_12m_34m) +
                \projeto\Util::decimalFormatForBank($planoj_municipio->valor_34m)
        ;

        $this->total = \projeto\Util::decimalFormatForBank($this->total_juridica) +
                \projeto\Util::decimalFormatForBank($this->total_fisica)
        ;
      

        return $totais = [
            'valor_512' => $this->total_512,
            'valor_512k_2m' => $this->total_512k_2m,
            'valor_2m_12m' => $this->total_2m_12m,
            'valor_12m_34m' => $this->total_12m_34m,
            'valor_34m' => $this->total_34m,
            'total' => $this->total,
            
        ];
    }

}
