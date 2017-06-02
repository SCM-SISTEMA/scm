<?php

namespace app\modules\posoutorga\models;

use Yii;

/**
 * This is the model class for table "pos_outorga.vis_sici_cliente".
 *
 * @property integer $cod_tipo_contrato
 * @property integer $cod_usuario_fk
 * @property integer $cod_contrato_fk
 * @property string $cnpj
 * @property integer $ie
 * @property string $fantasia
 * @property string $razao_social
 * @property integer $cod_cliente
 * @property boolean $situacao
 * @property string $fistel
 * @property integer $cod_contrato
 * @property integer $tipo_contrato_fk
 * @property string $valor_contrato
 * @property integer $dia_vencimento
 * @property integer $qnt_parcelas
 * @property string $dt_prazo
 * @property string $dt_vencimento
 * @property string $contador
 * @property integer $responsavel_fk
 * @property boolean $operando
 * @property integer $qnt_clientes
 * @property boolean $link
 * @property boolean $zero800
 * @property boolean $parceiria
 * @property boolean $consultoria_scm
 * @property boolean $engenheiro_tecnico
 * @property integer $cod_sici
 * @property integer $cod_tipo_contrato_fk
 * @property string $mes_ano_referencia
 * @property string $fust
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
 */
class VisSiciCliente extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pos_outorga.vis_sici_cliente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_tipo_contrato', 'cod_usuario_fk', 'cod_contrato_fk', 'ie', 'cod_cliente', 'cod_contrato', 'tipo_contrato_fk', 'dia_vencimento', 'qnt_parcelas', 'responsavel_fk', 'qnt_clientes', 'cod_sici', 'cod_tipo_contrato_fk', 'qtd_funcionarios_fichados', 'qtd_funcionarios_terceirizados', 'num_central_atendimento', 'total_fibra_prestadora', 'total_fibra_terceiros', 'total_crescimento_prestadora', 'total_crescimento_terceiros', 'total_fibra_implantada_prestadora', 'total_fibra_implantada_terceiros', 'total_fibra_crescimento_prop_prestadora', 'total_fibra_crescimento_prop_terceiros'], 'integer'],
            [['situacao', 'operando', 'link', 'zero800', 'parceiria', 'consultoria_scm', 'engenheiro_tecnico'], 'boolean'],
            [['valor_contrato', 'receita_bruta', 'despesa_operacao_manutencao', 'despesa_publicidade', 'despesa_vendas', 'despesa_link', 'aliquota_nacional', 'receita_icms', 'receita_pis', 'receita_confins', 'receita_liquida', 'valor_consolidado', 'aplicacao_equipamento', 'total_marketing_propaganda', 'aplicacao_software', 'total_pesquisa_desenvolvimento', 'aplicacao_servico', 'aplicacao_callcenter', 'faturamento_de', 'faturamento_industrial', 'faturamento_adicionado'], 'number'],
            [['dt_prazo', 'dt_vencimento', 'usuario_inclusao_sici'], 'safe'],
            [['obs_receita', 'obs_despesa', 'usuario_inclusao_sici'], 'string'],
            [['cnpj'], 'string', 'max' => 18],
            [['fantasia', 'razao_social'], 'string', 'max' => 200],
            [['fistel'], 'string', 'max' => 15],
            [['contador', 'responsavel'], 'string', 'max' => 150],
            [['mes_ano_referencia'], 'string', 'max' => 7],
            [['fust'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_tipo_contrato' => 'Cod Tipo Contrato',
            'cod_usuario_fk' => 'Cod Usuario Fk',
            'cod_contrato_fk' => 'Cod Contrato Fk',
            'cnpj' => 'Cnpj',
            'ie' => 'Ie',
            'fantasia' => 'Fantasia',
            'razao_social' => 'Razao Social',
            'cod_cliente' => 'Cod Cliente',
            'situacao' => 'Situacao',
            'fistel' => 'Fistel',
            'cod_contrato' => 'Cod Contrato',
            'tipo_contrato_fk' => 'Tipo Contrato Fk',
            'valor_contrato' => 'Valor Contrato',
            'dia_vencimento' => 'Dia Vencimento',
            'qnt_parcelas' => 'Qnt Parcelas',
            'dt_prazo' => 'Dt Prazo',
            'dt_vencimento' => 'Dt Vencimento',
            'contador' => 'Contador',
            'responsavel_fk' => 'Responsavel Fk',
            'operando' => 'Operando',
            'qnt_clientes' => 'Qnt Clientes',
            'link' => 'Link',
            'zero800' => 'Zero800',
            'parceiria' => 'Parceiria',
            'consultoria_scm' => 'Consultoria Scm',
            'engenheiro_tecnico' => 'Engenheiro Tecnico',
            'cod_sici' => 'Cod Sici',
            'cod_tipo_contrato_fk' => 'Cod Tipo Contrato Fk',
            'mes_ano_referencia' => 'Mes Ano Referencia',
            'fust' => 'Fust',
            'receita_bruta' => 'Receita Bruta',
            'despesa_operacao_manutencao' => 'Despesa Operacao Manutencao',
            'despesa_publicidade' => 'Despesa Publicidade',
            'despesa_vendas' => 'Despesa Vendas',
            'despesa_link' => 'Despesa Link',
            'aliquota_nacional' => 'Aliquota Nacional',
            'receita_icms' => 'Receita Icms',
            'receita_pis' => 'Receita Pis',
            'receita_confins' => 'Receita Confins',
            'receita_liquida' => 'Receita Liquida',
            'obs_receita' => 'Obs Receita',
            'obs_despesa' => 'Obs Despesa',
            'responsavel' => 'Responsavel',
            'valor_consolidado' => 'Valor Consolidado',
            'qtd_funcionarios_fichados' => 'Qtd Funcionarios Fichados',
            'qtd_funcionarios_terceirizados' => 'Qtd Funcionarios Terceirizados',
            'num_central_atendimento' => 'Num Central Atendimento',
            'total_fibra_prestadora' => 'Total Fibra Prestadora',
            'total_fibra_terceiros' => 'Total Fibra Terceiros',
            'total_crescimento_prestadora' => 'Total Crescimento Prestadora',
            'total_crescimento_terceiros' => 'Total Crescimento Terceiros',
            'total_fibra_implantada_prestadora' => 'Total Fibra Implantada Prestadora',
            'total_fibra_implantada_terceiros' => 'Total Fibra Implantada Terceiros',
            'total_fibra_crescimento_prop_prestadora' => 'Total Fibra Crescimento Prop Prestadora',
            'total_fibra_crescimento_prop_terceiros' => 'Total Fibra Crescimento Prop Terceiros',
            'aplicacao_equipamento' => 'Aplicacao Equipamento',
            'total_marketing_propaganda' => 'Total Marketing Propaganda',
            'aplicacao_software' => 'Aplicacao Software',
            'total_pesquisa_desenvolvimento' => 'Total Pesquisa Desenvolvimento',
            'aplicacao_servico' => 'Aplicacao Servico',
            'aplicacao_callcenter' => 'Aplicacao Callcenter',
            'faturamento_de' => 'Faturamento De',
            'faturamento_industrial' => 'Faturamento Industrial',
            'faturamento_adicionado' => 'Faturamento Adicionado',
        ];
    }

    /**
     * @inheritdoc
     * @return VisSiciClienteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VisSiciClienteQuery(get_called_class());
    }
}
