<?php

namespace app\modules\posoutorga\models;

use Yii;

/**
 * This is the model class for table "pos_outorga.tab_sici".
 *
 * @property integer $cod_sici
 * @property integer $cod_tipo_contrato_fk
 * @property string $mes_ano_referencia
 * @property string $legenda
 * @property string $receita_bruta
 * @property string $despesa_operacao_manutencao
 * @property string $despesa_publicidade
 * @property string $despesa_vendas
 * @property string $despesa_link
 * @property string $aliquota_nacional
 * @property string $receita_icms
 * @property string $receita_pis
 * @property string $receita_confins
 * @property string $receita_liquida
 * @property string $obs_receita
 * @property string $obs_despesa
 * @property string $responsavel
 * @property string $valor_consolidado
 * @property integer $qtd_funcionarios_fichados
 * @property integer $qtd_funcionarios_terceirizados
 * @property integer $num_central_atendimento
 * @property integer $total_fibra_prestadora
 * @property integer $total_fibra_terceiros
 * @property integer $total_crescimento_prestadora
 * @property integer $total_crescimento_terceiros
 * @property integer $total_fibra_implantada_prestadora
 * @property integer $total_fibra_implantada_terceiros
 * @property integer $total_fibra_crescimento_prop_prestadora
 * @property integer $total_fibra_crescimento_prop_terceiros
 * @property string $aplicacao_equipamento
 * @property string $total_marketing_propaganda
 * @property string $aplicacao_software
 * @property string $total_pesquisa_desenvolvimento
 * @property string $aplicacao_servico
 * @property string $aplicacao_callcenter
 * @property string $faturamento_de
 * @property string $faturamento_industrial
 * @property string $faturamento_adicionado
 * @property string $dt_inclusao
 * @property string $dt_exclusao
 * @property integer $tipo_sici_fk
 * @property integer $tipo_entrada_fk
 * @property integer $situacao_fk
 * @property boolean $receita_bruta_check
 * @property boolean $despesa_operacao_manutencao_check
 * @property boolean $despesa_publicidade_check
 * @property boolean $despesa_vendas_check
 * @property boolean $despesa_link_check
 * @property boolean $aliquota_nacional_check
 * @property boolean $receita_icms_check
 * @property boolean $receita_pis_check
 * @property boolean $receita_confins_check
 * @property boolean $receita_liquida_check
 * @property boolean $valor_consolidado_check
 * @property boolean $qtd_funcionarios_fichados_check
 * @property boolean $qtd_funcionarios_terceirizados_check
 * @property boolean $num_central_atendimento_check
 * @property boolean $total_fibra_prestadora_check
 * @property boolean $total_fibra_terceiros_check
 * @property boolean $total_crescimento_prestadora_check
 * @property boolean $total_crescimento_terceiros_check
 * @property boolean $total_fibra_implantada_prestadora_check
 * @property boolean $total_fibra_implantada_terceiros_check
 * @property boolean $total_fibra_crescimento_prop_prestadora_check
 * @property boolean $total_fibra_crescimento_prop_terceiros_check
 * @property boolean $aplicacao_equipamento_check
 * @property boolean $total_marketing_propaganda_check
 * @property boolean $aplicacao_software_check
 * @property boolean $total_pesquisa_desenvolvimento_check
 * @property boolean $aplicacao_servico_check
 * @property boolean $aplicacao_callcenter_check
 * @property boolean $faturamento_de_check
 * @property boolean $faturamento_industrial_check
 * @property boolean $faturamento_adicionado_check
 * @property string $txt_login_inclusao
 * @property string $txt_login_alteracao
 * @property string $dt_alteracao
 *
 * @property TabEmpresaMunicipio[] $tabEmpresaMunicipio
 * @property TabPlanosMenorMaior[] $tabPlanosMenorMaior
 * @property TabTipoContrato $tabTipoContrato
 */
class TabSici extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pos_outorga.tab_sici';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_tipo_contrato_fk', 'qtd_funcionarios_fichados', 'qtd_funcionarios_terceirizados',  'total_fibra_prestadora', 'total_fibra_terceiros', 'total_crescimento_prestadora', 'total_crescimento_terceiros', 'total_fibra_implantada_prestadora', 'total_fibra_implantada_terceiros', 'total_fibra_crescimento_prop_prestadora', 'total_fibra_crescimento_prop_terceiros', 'tipo_sici_fk', 'tipo_entrada_fk', 'situacao_fk'], 'integer'],
            [['receita_bruta', 'despesa_operacao_manutencao', 'despesa_publicidade', 'despesa_vendas', 'despesa_link', 'aliquota_nacional', 'receita_icms', 'receita_pis', 'receita_confins', 'receita_liquida', 'valor_consolidado', 'aplicacao_equipamento', 'total_marketing_propaganda', 'aplicacao_software', 'total_pesquisa_desenvolvimento', 'aplicacao_servico', 'aplicacao_callcenter', 'faturamento_de', 'faturamento_industrial', 'faturamento_adicionado'], 'number'],
            [['obs_receita', 'obs_despesa', 'num_central_atendimento'], 'string'],
            [['dt_inclusao', 'dt_exclusao', 'dt_alteracao'], 'safe'],
            [['receita_bruta_check', 'despesa_operacao_manutencao_check', 'despesa_publicidade_check', 'despesa_vendas_check', 'despesa_link_check', 'aliquota_nacional_check', 'receita_icms_check', 'receita_pis_check', 'receita_confins_check', 'receita_liquida_check', 'valor_consolidado_check', 'qtd_funcionarios_fichados_check', 'qtd_funcionarios_terceirizados_check', 'num_central_atendimento_check', 'total_fibra_prestadora_check', 'total_fibra_terceiros_check', 'total_crescimento_prestadora_check', 'total_crescimento_terceiros_check', 'total_fibra_implantada_prestadora_check', 'total_fibra_implantada_terceiros_check', 'total_fibra_crescimento_prop_prestadora_check', 'total_fibra_crescimento_prop_terceiros_check', 'aplicacao_equipamento_check', 'total_marketing_propaganda_check', 'aplicacao_software_check', 'total_pesquisa_desenvolvimento_check', 'aplicacao_servico_check', 'aplicacao_callcenter_check', 'faturamento_de_check', 'faturamento_industrial_check', 'faturamento_adicionado_check'], 'boolean'],
            [['mes_ano_referencia'], 'string', 'max' => 7],
            [['legenda'], 'string', 'max' => 30],
            [['responsavel', 'txt_login_inclusao', 'txt_login_alteracao'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_sici' => 'Cod Sici',
            'cod_tipo_contrato_fk' => 'Cod Tipo Contrato Fk',
            'mes_ano_referencia' => 'Mês de referência',
            'legenda' => 'Legenda',
            'receita_bruta' => 'Receita operacional bruta com serviço de SCM:',
            'despesa_operacao_manutencao' => 'Despesas envolvendo operação e manutenção:',
            'despesa_publicidade' => 'Despesas envolvendo publicidade',
            'despesa_vendas' => 'Despesas envolvendo vendas',
            'despesa_link' => 'Despesas envolvendo interconexão (link)',
            'aliquota_nacional' => 'Alíquota do simples nacional',
            'receita_icms' => 'ICMS',
            'receita_pis' => 'PIS',
            'receita_confins' => 'CONFINS',
            'receita_liquida' => 'Receita operacional líquida',
            'obs_receita' => 'Observação Receita',
            'obs_despesa' => 'Observação Despesa',
            'responsavel' => 'Responsável',
            'valor_consolidado' => 'Dado semestral - valor consolidado do investimento realizado',
            'qtd_funcionarios_fichados' => 'Quantidade de empregados contratados diretamente na empresa (Fichados)',
            'qtd_funcionarios_terceirizados' => 'Quantidade de empregados de empresas terceirizadas (terceiros)',
            'num_central_atendimento' => 'Número do Centro de Atendimento Telefônico (0800 ou numero a cobrar)',
            'total_fibra_prestadora' => 'Total de cabo de fibra otica de propriedade da Prestadora em KM',
            'total_fibra_terceiros' => 'Total de cabo de fibra otica de propriedade de Terceiros em KM',
            'total_crescimento_prestadora' => 'Crescimento previsto do cabo de fibra otica de propriedade da Prestadora em KM',
            'total_crescimento_terceiros' => 'Crescimento previsto do cabo de fibra otica de propriedade de Terceiros em KM',
            'total_fibra_implantada_prestadora' => 'Total de fibra otica implantada pela Prestadora em KM',
            'total_fibra_implantada_terceiros' => 'Total de fibra otica implantada por Terceiros em KM',
            'total_fibra_crescimento_prop_prestadora' => 'Crescimento previsto de cabo de fibra otica da Prestadora em KM',
            'total_fibra_crescimento_prop_terceiros' => 'Crescimento previsto de cabo de fibra otica de Terceiros em KM',
            'aplicacao_equipamento' => 'Aplicação em Equipamento',
            'total_marketing_propaganda' => 'Valor total em reais de capital aplicado em Marketing/Propaganda',
            'aplicacao_software' => 'Aplicação em Software',
            'total_pesquisa_desenvolvimento' => 'Valor total em Reais de capital aplicado em P&D (Pesquisa e Desenvolvimento)',
            'aplicacao_servico' => 'Aplicação em Serviços',
            'aplicacao_callcenter' => 'Valor total em Reais de capital aplicado em Call-Center ou qualquer tipo de central de atendimento',
            'faturamento_de' => 'Faturamento com prestação do serviço DE telecomunicações da empresa',
            'faturamento_industrial' => 'Faturamento bruto decorrente do provimento de serviços de valor adicionado (não é parceria)',
            'faturamento_adicionado' => 'Faturamento bruto decorrente do provimento de serviços de valor adicionado (não é parceria)',
            'dt_inclusao' => 'Dt Inclusao',
            'dt_exclusao' => 'Dt Exclusao',
            'tipo_sici_fk' => 'Tipo Sici Fk',
            'tipo_entrada_fk' => 'tipo de entrada -> atributo tipo-entrada ',
            'situacao_fk' => 'Situação',
            'receita_bruta_check' => 'Check Receita operacional bruta com serviço de SCM:',
            'despesa_operacao_manutencao_check' => 'Check Despesas envolvendo operação e manutenção:',
            'despesa_publicidade_check' => 'Check Despesas envolvendo publicidade',
            'despesa_vendas_check' => 'Check Despesas envolvendo vendas',
            'despesa_link_check' => 'Check Despesas envolvendo interconexão (link)',
            'aliquota_nacional_check' => 'Check Alíquota do simples nacional',
            'receita_icms_check' => 'Check ICMS',
            'receita_pis_check' => 'Check PIS',
            'receita_confins_check' => 'Check CONFINS',
            'receita_liquida_check' => 'Check Receita operacional líquida',
            'valor_consolidado_check' => 'Check Dado semestral - valor consolidado do investimento realizado',
            'qtd_funcionarios_fichados_check' => 'Check Quantidade de empregados contratados diretamente na empresa (Fichados)',
            'qtd_funcionarios_terceirizados_check' => 'Check Quantidade de empregados de empresas terceirizadas (terceiros)',
            'num_central_atendimento_check' => 'Check Número do Centro de Atendimento Telefônico (0800 ou numero a cobrar)',
            'total_fibra_prestadora_check' => 'Check Total de cabo de fibra otica de propriedade da Prestadora em KM',
            'total_fibra_terceiros_check' => 'Check Total de cabo de fibra otica de propriedade de Terceiros em KM',
            'total_crescimento_prestadora_check' => 'Check Crescimento previsto do cabo de fibra otica de propriedade da Prestadora em KM',
            'total_crescimento_terceiros_check' => 'Check Crescimento previsto do cabo de fibra otica de propriedade de Terceiros em KM',
            'total_fibra_implantada_prestadora_check' => 'Check Total de fibra otica implantada pela Prestadora em KM',
            'total_fibra_implantada_terceiros_check' => 'Check Total de fibra otica implantada por Terceiros em KM',
            'total_fibra_crescimento_prop_prestadora_check' => 'Check Crescimento previsto de cabo de fibra otica da Prestadora em KM',
            'total_fibra_crescimento_prop_terceiros_check' => 'Check Crescimento previsto de cabo de fibra otica de Terceiros em KM',
            'aplicacao_equipamento_check' => 'Check Aplicação em Equipamento',
            'total_marketing_propaganda_check' => 'Check Valor total em reais de capital aplicado em Marketing/Propaganda',
            'aplicacao_software_check' => 'Check Aplicação em Software',
            'total_pesquisa_desenvolvimento_check' => 'Check Valor total em Reais de capital aplicado em P&D (Pesquisa e Desenvolvimento)',
            'aplicacao_servico_check' => 'Check Aplicação em Serviços',
            'aplicacao_callcenter_check' => 'Check Valor total em Reais de capital aplicado em Call-Center ou qualquer tipo de central de atendimento',
            'faturamento_de_check' => 'Check Faturamento com prestação do serviço DE telecomunicações da empresa',
            'faturamento_industrial_check' => 'Check Faturamento bruto decorrente do provimento de serviços de valor adicionado (não é parceria)',
            'faturamento_adicionado_check' => 'Check Faturamento bruto decorrente do provimento de serviços de valor adicionado (não é parceria)',
            'txt_login_inclusao' => 'Usuário da Inclusão',
            'txt_login_alteracao' => 'Usuário da Alteração',
            'dt_alteracao' => 'Dt Alteracao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabEmpresaMunicipio()
    {
        return $this->hasMany(TabEmpresaMunicipio::className(), ['cod_sici_fk' => 'cod_sici']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabPlanosMenorMaior()
    {
        return $this->hasMany(TabPlanosMenorMaior::className(), ['cod_sici_fk' => 'cod_sici']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabTipoContrato()
    {
        return $this->hasOne(TabTipoContrato::className(), ['cod_tipo_contrato' => 'cod_tipo_contrato_fk']);
    }

    /**
     * @inheritdoc
     * @return TabSiciQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabSiciQuery(get_called_class());
    }
}
