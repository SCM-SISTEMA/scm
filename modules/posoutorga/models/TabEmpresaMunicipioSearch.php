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

    public $total;
    public $tipo_pessoa;
    public $gridMunicipios;

    /**
     * @inheritdoc
     */
    public function rules() {

        $rules = [
            [['total_512', 'total_512k_2m', 'total_2m_12m', 'total_12m_34m', 'total_34m',
            'total_fisica', 'total_juridica', 'txt_nome', 'cod_modulo_fk', 'cod_municipio_fk_check', 'capacidade_municipio_check', 'capacidade_servico_check',
            'tecnologia_fk_check', 'total_check', 'total_fisica_check', 'total_juridica_check',
            'uf_check'], 'safe'],
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
                    ->select("
                    valor_512, valor_512k_2m, valor_2m_12m,valor_12m_34m,valor_34m,
                    (SELECT sgl_valor FROM public.tab_atributos_valores where cod_atributos_valores=tipo_plano_fk) as tipo_plano_sgl")
                    ->where(['cod_chave' => $value->cod_empresa_municipio, 'tipo_tabela_fk' => $value->tableName()])
                    ->orderBy('tipo_plano_sgl')
                    ->asArray()
                    ->all();

            foreach ($planom as $key => $pla) {
                $pla['total'] = (int) $pla['valor_512'] + (int) $pla['valor_512k_2m'] + (int) $pla['valor_2m_12m'] + (int) $pla['valor_12m_34m'] + (int) $pla['valor_34m'];


                $planoEmpresa[$value->tabMunicipios->cod_ibge]['tecnologia'][$value->tecnologia_fk][$pla['tipo_plano_sgl']] = $pla;
            }
            $planoEmpresa[$value->tabMunicipios->cod_ibge]['capacidade_servico'] = $value->capacidade_servico;
            
            $totais[$value->tabMunicipios->cod_ibge]['total_512'] += (int) $value->total_512;
            $totais[$value->tabMunicipios->cod_ibge]['total_512k_2m'] += (int) $value->total_512k_2m;
            $totais[$value->tabMunicipios->cod_ibge]['total_2m_12m'] += (int) $value->total_2m_12m;
            $totais[$value->tabMunicipios->cod_ibge]['total_12m_34m'] += (int) $value->total_12m_34m;
            $totais[$value->tabMunicipios->cod_ibge]['total_34m'] += (int) $value->total_34m;
            $totais[$value->tabMunicipios->cod_ibge]['total_fisica'] += (int) $value->total_fisica;
            $totais[$value->tabMunicipios->cod_ibge]['total_juridica'] += (int) $value->total_juridica;
            $totais[$value->tabMunicipios->cod_ibge]['total'] += (int) $value->total = (int) $value->total_512 +
                    (int) $value->total_34m +
                    (int) $value->total_512k_2m +
                    (int) $value->total_2m_12m +
                    (int) $value->total_12m_34m;
            
            $planoEmpresa[$value->tabMunicipios->cod_ibge]['totais'] = $totais[$value->tabMunicipios->cod_ibge];

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

    public function setQAIPL4SM($dom) {

        foreach ($dom->getElementsByTagName('Conteudo') as $conteudo) {
            $key = $conteudo->getAttribute('faixa');

            switch ($key) {
                case '15': $this->total_512 = ($conteudo->getAttribute('valor'));
                    break;
                case '16': $this->total_512k_2m = ($conteudo->getAttribute('valor'));
                    break;
                case '17': $this->total_2m_12m = ($conteudo->getAttribute('valor'));
                    break;
                case '18': $this->total_12m_34m = ($conteudo->getAttribute('valor'));
                    break;
                case '19': $this->total_34m = ($conteudo->getAttribute('valor'));
            }

            if ($conteudo->getAttribute('nome') == 'total') {
                $this->total = ($conteudo->getAttribute('valor'));
            }

            if (strtoupper($conteudo->getAttribute('nome')) == 'QAIPL5SM') {
                $this->capacidade_servico = ($conteudo->getAttribute('valor'));
            }
        }
    }

    public static function getQAIPL4SM($cod_sici) {
        $dados = TabEmpresaMunicipioSearch::buscaPlanoEmpresasTecnologia($cod_sici);
        $tec = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tecnologia');

        $planos = [];

        if ($dados) {
            foreach ($dados as $munK => $municipio) {
                foreach ($municipio['tecnologia'] as $tK => $tecnologia) {
                    foreach ($tec as $k => $t) {

                        if ($tK == $t['cod_atributos_valores']) {
                            $planos[$munK][$tK]['QAIPL5SM'] = $municipio['capacidade_servico'];

                            $pessoa = $municipio['totais'];
                            $planos[$munK][$t['cod_atributos_valores']]['total'] = $tecnologia['F']['total'] + $tecnologia['J']['total'];
                            $planos[$munK][$t['cod_atributos_valores']]['15'] = $tecnologia['F']['valor_512'] + $tecnologia['J']['valor_512'];
                            $planos[$munK][$t['cod_atributos_valores']]['16'] = $tecnologia['F']['valor_512k_2m'] + $tecnologia['J']['valor_512k_2m'];
                            $planos[$munK][$t['cod_atributos_valores']]['17'] = $tecnologia['F']['valor_2m_12m'] + $tecnologia['J']['valor_2m_12m'];
                            $planos[$munK][$t['cod_atributos_valores']]['18'] = $tecnologia['F']['valor_12m_34m'] + $tecnologia['J']['valor_12m_34m'];
                            $planos[$munK][$t['cod_atributos_valores']]['19'] = $tecnologia['F']['valor_34m'] + $tecnologia['J']['valor_34m'];
                        } else {
                            if (!$planos[$munK][$t['cod_atributos_valores']]['total']) {
                                $planos[$munK][$t['cod_atributos_valores']]['QAIPL5SM'] = 0;
                                $planos[$munK][$t['cod_atributos_valores']]['total'] = 0;
                                $planos[$munK][$t['cod_atributos_valores']]['15'] = 0;
                                $planos[$munK][$t['cod_atributos_valores']]['16'] = 0;
                                $planos[$munK][$t['cod_atributos_valores']]['17'] = 0;
                                $planos[$munK][$t['cod_atributos_valores']]['18'] = 0;
                                $planos[$munK][$t['cod_atributos_valores']]['19'] = 0;
                            }
                        }
                    }
                }
            }
        }
        return $planos;
    }

    public static function getIPL3($cod_sici) {

        $dados = TabEmpresaMunicipioSearch::buscaPlanoEmpresasTecnologia($cod_sici);

        $planos = [];
        if ($dados) {
          
            foreach ($dados as $munK => $municipio) {
                $planos[$munK]['F']['total'] = $municipio['totais']['total_fisica'];
                $planos[$munK]['J']['total'] = $municipio['totais']['total_juridica'];
                /* foreach ($municipio as $tK => $tecnologia) {
                  print_r($tecnologia); exit;

                  foreach ($tecnologia as $pk => $pessoa) {
                  if ($pk == 'capacidade_servico')
                  continue;
                  $planos[$munK][$pk]['valor_512'] += $pessoa['valor_512'];
                  $planos[$munK][$pk]['valor_512k_2m'] += $pessoa['valor_512k_2m'];
                  $planos[$munK][$pk]['valor_2m_12m'] += $pessoa['valor_2m_12m'];
                  $planos[$munK][$pk]['valor_12m_34m'] += $pessoa['valor_12m_34m'];
                  $planos[$munK][$pk]['valor_34m'] += $pessoa['valor_34m'];
                  $planos[$munK][$pk]['total'] += $pessoa['total'];
                  }
                  } */
            }
        }
        return $planos;
    }

    public function calculaTotais($planof_municipio = null, $planoj_municipio = null, $excel = true) {

        if ($excel) {
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
        } else {

            $this->total = \projeto\Util::decimalFormatForBank($this->total_juridica) +
                    \projeto\Util::decimalFormatForBank($this->total_fisica)
            ;
            $this->total_juridica = (int) $this->total_juridica;
            $this->total_fisica = (int) $this->total_fisica;
            $this->total_512 = (int) $this->total_512;
            $this->total_512k_2m = (int) $this->total_512k_2m;
            $this->total_2m_12m = (int) $this->total_2m_12m;
            $this->total_12m_34m = (int) $this->total_12m_34m;
            $this->total_34m = (int) $this->total_34m;
            $this->total = (int) $this->total;
        }

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
