<?php

namespace app\modules\posoutorga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\posoutorga\models\TabSici;

/**
 * TabSiciSearch represents the model behind the search form about `app\modules\posoutorga\models\TabSici`.
 * @property TabTipoContrato $tabTipoContrato
 */
class TabSiciSearch extends TabSici {

    /**
     * @inheritdoc
     */
    public $total_aliquota;
    public $total_icms;
    public $total_pis;
    public $total_confins;
    public $total_despesa;
    public $total_planta;
    public $file;
    public $ano;
    public $mes;
    public $qntAcesso;

    public function rules() {

        $rules = [
            [['file', 'cod_sici', 'cod_tipo_contrato_fk', 'qtd_funcionarios_fichados', 'qtd_funcionarios_terceirizados', 'num_central_atendimento', 'total_fibra_prestadora', 'total_fibra_terceiros', 'total_crescimento_prestadora', 'total_crescimento_terceiros', 'total_fibra_implantada_prestadora', 'total_fibra_implantada_terceiros', 'total_fibra_crescimento_prop_prestadora', 'total_fibra_crescimento_prop_terceiros',
            'receita_bruta', 'qntAcesso', 'tipo_entrada_fk', 'tipo_sici_fk', 'despesa_operacao_manutencao', 'mes_ano_referencia', 'legenda', 'responsavel', 'despesa_publicidade', 'despesa_vendas', 'despesa_link', 'aliquota_nacional', 'receita_icms', 'receita_pis', 'receita_confins', 'receita_liquida', 'valor_consolidado', 'aplicacao_equipamento', 'total_marketing_propaganda', 'aplicacao_software', 'total_pesquisa_desenvolvimento', 'aplicacao_servico', 'aplicacao_callcenter', 'faturamento_de', 'faturamento_industrial', 'faturamento_adicionado'
            , 'tipo_sici_fk', 'inclusao_usuario_fk', 'tipo_entrada_fk', 'situacao_fk', 'receita_bruta_check',
            'despesa_operacao_manutencao_check', 'despesa_publicidade_check', 'despesa_vendas_check', 'despesa_link_check', 'aliquota_nacional_check',
            'receita_icms_check', 'receita_pis_check', 'receita_confins_check', 'receita_liquida_check', 'valor_consolidado_check', 'qtd_funcionarios_fichados_check',
            'qtd_funcionarios_terceirizados_check', 'num_central_atendimento_check', 'total_fibra_prestadora_check', 'total_fibra_terceiros_check', 'total_crescimento_prestadora_check',
            'total_crescimento_terceiros_check', 'total_fibra_implantada_prestadora_check', 'total_fibra_implantada_terceiros_check', 'total_fibra_crescimento_prop_prestadora_check',
            'total_fibra_crescimento_prop_terceiros_check', 'aplicacao_equipamento_check', 'total_marketing_propaganda_check', 'aplicacao_software_check', 'total_pesquisa_desenvolvimento_check',
            'aplicacao_servico_check', 'aplicacao_callcenter_check', 'faturamento_de_check', 'faturamento_industrial_check', 'faturamento_adicionado_check'], 'safe'],
            [['obs_receita', 'obs_despesa'], 'string'],
            [['mes_ano_referencia'], 'required'],
            [['receita_bruta', 'despesa_operacao_manutencao', 'despesa_publicidade', 'despesa_vendas', 'despesa_link', 'aliquota_nacional', 'receita_icms', 'receita_pis', 'receita_confins', 'valor_consolidado', 'aplicacao_equipamento', 'total_marketing_propaganda', 'aplicacao_software', 'total_pesquisa_desenvolvimento', 'aplicacao_servico', 'aplicacao_callcenter', 'faturamento_de', 'faturamento_industrial', 'faturamento_adicionado'], 'number'],
            [['file'], 'required', 'on' => 'importar'],
            [['mes_ano_referencia', 'cod_tipo_contrato_fk'], 'unique', 'targetAttribute' => ['mes_ano_referencia', 'cod_tipo_contrato_fk'], 'message' => 'Já existe Mês de referência para esse cliente'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xls, xlsx, xml'],
        ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        $labels = [
            'file' => 'Selecione a planilha ou XML',
            'tipo_sici_fk' => 'Tipo SICI',
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
        $query = TabSiciSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_sici' => $this->cod_sici,
            $this->tableName() . '.cod_tipo_contrato_fk' => $this->cod_tipo_contrato_fk,
            $this->tableName() . '.receita_bruta' => $this->receita_bruta,
            $this->tableName() . '.despesa_operacao_manutencao' => $this->despesa_operacao_manutencao,
            $this->tableName() . '.despesa_publicidade' => $this->despesa_publicidade,
            $this->tableName() . '.despesa_vendas' => $this->despesa_vendas,
            $this->tableName() . '.despesa_link' => $this->despesa_link,
            $this->tableName() . '.aliquota_nacional' => $this->aliquota_nacional,
            $this->tableName() . '.receita_icms' => $this->receita_icms,
            $this->tableName() . '.receita_pis' => $this->receita_pis,
            $this->tableName() . '.receita_confins' => $this->receita_confins,
            $this->tableName() . '.receita_liquida' => $this->receita_liquida,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.mes_ano_referencia', $this->mes_ano_referencia])
                ->andFilterWhere(['ilike', $this->tableName() . '.leganda', $this->legenda])
                ->andFilterWhere(['ilike', $this->tableName() . '.obs_receita', $this->obs_receita])
                ->andFilterWhere(['ilike', $this->tableName() . '.obs_despesa', $this->obs_despesa]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    public function beforeSave($insert) {

        $this->receita_liquida = \projeto\Util::decimalFormatForBank($this->receita_liquida);

        return parent::beforeSave($insert);
    }

    public function afterFind() {
        parent::afterFind();
        $this->receita_liquida = \projeto\Util::decimalFormatToBank($this->receita_liquida);

        return true;
    }

    public function getTabTipoContrato() {
        return $this->hasOne(\app\modules\comercial\models\TabTipoContrato::className(), ['cod_tipo_contrato' => 'cod_tipo_contrato_fk']);
    }

    public function getIEM1() {
        $dados['a'] = $this->total_marketing_propaganda + $this->aplicacao_equipamento + $this->aplicacao_software + $this->total_pesquisa_desenvolvimento + $this->aplicacao_servico + $this->aplicacao_callcenter;
        $dados['b'] = $this->total_marketing_propaganda;
        $dados['c'] = $this->aplicacao_equipamento;
        $dados['d'] = $this->aplicacao_software;
        $dados['e'] = $this->total_pesquisa_desenvolvimento;
        $dados['f'] = $this->aplicacao_servico;
        $dados['g'] = $this->aplicacao_callcenter;

        return $dados;
    }

    public function setIEM1($dom) {


        foreach ($dom->getElementsByTagName('Conteudo') as $conteudo) {
            $key = strtoupper($conteudo->getAttribute('item'));
            switch ($key) {
                case 'A': $this->total_planta = \projeto\Util::decimalFormatForBank(($conteudo->getAttribute('valor')));
                    break;
                case 'B': $this->total_marketing_propaganda = \projeto\Util::decimalFormatForBank(($conteudo->getAttribute('valor')));
                    break;
                case 'C': $this->aplicacao_equipamento = \projeto\Util::decimalFormatForBank(($conteudo->getAttribute('valor')));
                    break;
                case 'D': $this->aplicacao_software = \projeto\Util::decimalFormatForBank(($conteudo->getAttribute('valor')));
                    break;
                case 'E': $this->total_pesquisa_desenvolvimento = (\projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor')));
                    break;
                case 'F': $this->aplicacao_servico = \projeto\Util::decimalFormatForBank(($conteudo->getAttribute('valor')));
                    break;
                case 'G': $this->aplicacao_callcenter = \projeto\Util::decimalFormatForBank(($conteudo->getAttribute('valor')));
                    break;
            }
        }
    }

    public function getIEM2() {
        $dados['a'] = $this->faturamento_de;
        $dados['b'] = $this->faturamento_industrial;
        $dados['c'] = $this->faturamento_adicionado;


        return $dados;
    }

    public function setIEM2($dom) {


        foreach ($dom->getElementsByTagName('Conteudo') as $conteudo) {
            $key = strtoupper($conteudo->getAttribute('item'));
            switch ($key) {
                case 'A': $this->faturamento_de = \projeto\Util::decimalFormatForBank(($conteudo->getAttribute('valor')));
                    break;
                case 'B': $this->faturamento_industrial = \projeto\Util::decimalFormatForBank(($conteudo->getAttribute('valor')));
                    break;
                case 'C': $this->faturamento_adicionado = \projeto\Util::decimalFormatForBank(($conteudo->getAttribute('valor')));
                    break;
            }
        }
    }

    public function getIEM8() {
        $dados['a'] = $this->despesa_operacao_manutencao + $this->despesa_publicidade + $this->despesa_vendas + $this->despesa_link;
        $dados['b'] = $this->despesa_operacao_manutencao;
        $dados['c'] = $this->despesa_publicidade;
        $dados['d'] = $this->despesa_vendas;
        $dados['e'] = $this->despesa_link;

        return $dados;
    }

    public function setIEM8($dom) {


        foreach ($dom->getElementsByTagName('Conteudo') as $conteudo) {
            $key = strtoupper($conteudo->getAttribute('item'));
            switch ($key) {
                case 'A': $this->total_despesa = \projeto\Util::decimalFormatToBank($conteudo->getAttribute('valor'));
                    break;
                case 'B': $this->despesa_operacao_manutencao = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                    break;
                case 'C': $this->despesa_publicidade = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                    break;
                case 'D': $this->despesa_vendas = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                    break;
                case 'E': $this->despesa_link = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                    break;
            }
        }
    }

    public function getIPL1() {
        $dados['A'] = $this->total_fibra_prestadora;
        $dados['B'] = $this->total_fibra_terceiros;
        $dados['C'] = $this->total_fibra_crescimento_prop_prestadora;
        $dados['D'] = $this->total_fibra_crescimento_prop_terceiros;


        return $dados;
    }

    public function setIPL1($dom) {


        foreach ($dom->getElementsByTagName('Conteudo') as $conteudo) {
            $key = strtoupper($conteudo->getAttribute('item'));
            switch ($key) {
                case 'A': $this->total_fibra_prestadora = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                    break;
                case 'B': $this->total_fibra_terceiros = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                    break;
                case 'C': $this->total_fibra_crescimento_prop_prestadora = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                    break;
                case 'D': $this->total_fibra_crescimento_prop_terceiros = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                    break;
            }
        }
    }

    public function getIPL2() {
        $dados['A'] = $this->total_fibra_implantada_prestadora;
        $dados['B'] = $this->total_fibra_implantada_terceiros;
        $dados['C'] = $this->total_crescimento_prestadora;
        $dados['D'] = $this->total_crescimento_terceiros;


        return $dados;
    }

    public function setIPL2($dom) {


        foreach ($dom->getElementsByTagName('Conteudo') as $conteudo) {
            $key = strtoupper($conteudo->getAttribute('item'));
            switch ($key) {
                case 'A': $this->total_fibra_implantada_prestadora = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                    break;
                case 'B': $this->total_fibra_implantada_terceiros = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                    break;
                case 'C': $this->total_crescimento_prestadora = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                    break;
                case 'D': $this->total_crescimento_terceiros = \projeto\Util::decimalFormatForBank($conteudo->getAttribute('valor'));
                    break;
            }
        }
    }

    public function calculaTotais() {
        $this->total_aliquota = \projeto\Util::decimalFormatToBank(($this->receita_bruta * $this->aliquota_nacional) / 100);
        $this->total_icms = \projeto\Util::decimalFormatToBank((($this->receita_bruta * $this->receita_icms) / 100) / 100);
        $this->total_pis = \projeto\Util::decimalFormatToBank((($this->receita_bruta * $this->receita_pis) / 100) / 100);
        $this->total_confins = \projeto\Util::decimalFormatToBank((($this->receita_bruta * $this->receita_pis) / 100) / 100);
        $this->total_despesa = \projeto\Util::decimalFormatToBank($this->despesa_link + $this->despesa_operacao_manutencao + $this->despesa_publicidade + $this->despesa_vendas);
        $this->total_planta = \projeto\Util::decimalFormatToBank($this->aplicacao_callcenter + $this->aplicacao_equipamento + $this->aplicacao_servico + $this->aplicacao_software +
                        $this->total_marketing_propaganda + $this->total_marketing_propaganda);
    }

    public function afterSave($insert, $changedAttributes) {
        $this->verificarChecks();
        parent::afterSave($insert, $changedAttributes);
    }

    public function verificarChecks() {
        $mensal = ['receita_bruta_check', 'despesa_operacao_manutencao_check', 'despesa_publicidade_check', 'despesa_vendas_check', 'despesa_link_check', 'aliquota_nacional_check',
            'receita_icms_check', 'receita_pis_check', 'receita_confins_check', 'receita_liquida_check', 'valor_consolidado_check'];

        $semestral = ['qtd_funcionarios_fichados_check',
            'qtd_funcionarios_terceirizados_check', 'num_central_atendimento_check'];

        $anual = ['total_fibra_prestadora_check', 'total_fibra_terceiros_check', 'total_crescimento_prestadora_check',
            'total_crescimento_terceiros_check', 'total_fibra_implantada_prestadora_check', 'total_fibra_implantada_terceiros_check', 'total_fibra_crescimento_prop_prestadora_check',
            'total_fibra_crescimento_prop_terceiros_check', 'aplicacao_equipamento_check', 'total_marketing_propaganda_check', 'aplicacao_software_check', 'total_pesquisa_desenvolvimento_check',
            'aplicacao_servico_check', 'aplicacao_callcenter_check', 'faturamento_de_check', 'faturamento_industrial_check', 'faturamento_adicionado_check'];

        $tipo_sici_fk = \app\models\TabAtributosValoresSearch::findOne(['cod_atributos_valores' => $this->tipo_sici_fk]);


        $checar = function ($vals) {
            foreach ($vals as $val) {
                if ($this->$val == false) {
                    $this->situacao_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('situacao-sici', 'S');
                    return false;
                }
            }
            $this->situacao_fk =\app\models\TabAtributosValoresSearch::getAtributoValorAtributo('situacao-sici', 'C');
            return true;
        };

        switch ($tipo_sici_fk['sgl_valor']) {
            case 'A':
                $ver = array_merge($mensal, $semestral, $anual);
                break;
            case 'S':
                $ver = array_merge($mensal, $semestral);
                break;
             default:
                $ver = $mensal;
                break;
        }

        return $checar($ver);
    }

}
