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

    public function rules() {

        $rules = [
            [['file', 'cod_tipo_contrato_fk', 'qtd_funcionarios_fichados', 'qtd_funcionarios_terceirizados', 'num_central_atendimento', 'total_fibra_prestadora', 'total_fibra_terceiros', 'total_crescimento_prestadora', 'total_crescimento_terceiros', 'total_fibra_implantada_prestadora', 'total_fibra_implantada_terceiros', 'total_fibra_crescimento_prop_prestadora', 'total_fibra_crescimento_prop_terceiros',
            'receita_bruta', 'despesa_operacao_manutencao', 'mes_ano_referencia', 'fust', 'responsavel', 'despesa_publicidade', 'despesa_vendas', 'despesa_link', 'aliquota_nacional', 'receita_icms', 'receita_pis', 'receita_confins', 'receita_liquida', 'valor_consolidado', 'aplicacao_equipamento', 'total_marketing_propaganda', 'aplicacao_software', 'total_pesquisa_desenvolvimento', 'aplicacao_servico', 'aplicacao_callcenter', 'faturamento_de', 'faturamento_industrial', 'faturamento_adicionado'], 'safe'],
            [['obs_receita', 'obs_despesa'], 'string'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xls, xlsx'],
        ];

        return $rules;
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
                ->andFilterWhere(['ilike', $this->tableName() . '.fust', $this->fust])
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

        $this->ano = substr($this->mes_ano_referencia, 3, 4);

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

    public function getIEM2() {
        $dados['a'] = $this->faturamento_de;
        $dados['b'] = $this->faturamento_industrial;
        $dados['c'] = $this->faturamento_adicionado;


        return $dados;
    }

    public function getIEM8() {
        $dados['a'] = $this->despesa_operacao_manutencao + $this->despesa_publicidade + $this->despesa_vendas + $this->despesa_link;
        $dados['b'] = $this->despesa_operacao_manutencao;
        $dados['c'] = $this->despesa_publicidade;
        $dados['d'] = $this->despesa_vendas;
        $dados['e'] = $this->despesa_link;

        return $dados;
    }

    public function getIPL1() {
        $dados['A'] = $this->total_fibra_prestadora;
        $dados['B'] = $this->total_fibra_terceiros;
        $dados['C'] = $this->total_fibra_crescimento_prop_prestadora;
        $dados['D'] = $this->total_fibra_crescimento_prop_terceiros;


        return $dados;
    }

    public function getIPL2() {
        $dados['A'] = $this->total_fibra_implantada_prestadora;
        $dados['B'] = $this->total_fibra_implantada_terceiros;
        $dados['C'] = $this->total_crescimento_prestadora;
        $dados['D'] = $this->total_crescimento_terceiros;


        return $dados;
    }

}
