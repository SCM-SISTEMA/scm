<?php

namespace app\modules\comercial\models;

use Yii;

/**
 * This is the model class for table "comercial.view_cliente_contrato".
 *
 * @property integer $cod_cliente
 * @property string $cnpj
 * @property string $contato
 * @property string $razao_social
 * @property string $responsavel
 * @property string $txt_notificacao
 * @property string $dt_retorno
 * @property integer $status_andamento_retorno
 * @property string $txt_notificacao_res
 * @property string $dt_inclusao_andamento
 * @property string $txt_login
 * @property string $txt_login_andamento
 * @property string $dsc_tipo_produto
 * @property integer $atributos_tipo_produto
 * @property string $dsc_tipo_contrato
 * @property integer $atributos_tipo_contrato
 * @property string $dsc_status
 * @property integer $atributos_status
 * @property string $sgl_status
 * @property string $dsc_setor
 * @property integer $atributos_setor
 * @property integer $cod_contrato
 * @property integer $tipo_contrato_fk
 * @property string $valor_contrato
 * @property integer $qnt_parcelas
 * @property string $dt_prazo
 * @property string $dt_inclusao_contrato
 * @property integer $cod_cliente_fk
 * @property boolean $ativo_contrato
 * @property integer $cod_setor
 * @property integer $cod_usuario_responsavel_fk
 * @property string $dt_vencimento
 * @property integer $cod_tipo_setor_fk
 * @property integer $cod_tipo_contrato
 * @property string $contrato_html
 */
class ViewClienteContrato extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercial.view_cliente_contrato';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_cliente', 'status_andamento_retorno', 'atributos_tipo_produto', 'atributos_tipo_contrato', 'atributos_status', 'atributos_setor', 'cod_contrato', 'tipo_contrato_fk', 'qnt_parcelas', 'cod_cliente_fk', 'cod_setor', 'cod_usuario_responsavel_fk', 'cod_tipo_setor_fk', 'cod_tipo_contrato'], 'integer'],
            [['contato', 'txt_notificacao', 'dt_retorno', 'txt_notificacao_res', 'dt_inclusao_andamento', 'sgl_status', 'dt_prazo', 'dt_inclusao_contrato', 'dt_vencimento', 'contrato_html'], 'string'],
            [['valor_contrato'], 'number'],
            [['ativo_contrato'], 'boolean'],
            [['cnpj'], 'string', 'max' => 18],
            [['razao_social', 'dsc_tipo_produto', 'dsc_tipo_contrato', 'dsc_status', 'dsc_setor'], 'string', 'max' => 200],
            [['responsavel'], 'string', 'max' => 300],
            [['txt_login', 'txt_login_andamento'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_cliente' => 'Cod Cliente',
            'cnpj' => 'Cnpj',
            'contato' => 'Contato',
            'razao_social' => 'Razao Social',
            'responsavel' => 'Responsavel',
            'txt_notificacao' => 'Txt Notificacao',
            'dt_retorno' => 'Dt Retorno',
            'status_andamento_retorno' => 'Status Andamento Retorno',
            'txt_notificacao_res' => 'Txt Notificacao Res',
            'dt_inclusao_andamento' => 'Dt Inclusao Andamento',
            'txt_login' => 'Txt Login',
            'txt_login_andamento' => 'Txt Login Andamento',
            'dsc_tipo_produto' => 'Dsc Tipo Produto',
            'atributos_tipo_produto' => 'Atributos Tipo Produto',
            'dsc_tipo_contrato' => 'Dsc Tipo Contrato',
            'atributos_tipo_contrato' => 'Atributos Tipo Contrato',
            'dsc_status' => 'Dsc Status',
            'atributos_status' => 'Atributos Status',
            'sgl_status' => 'Sgl Status',
            'dsc_setor' => 'Dsc Setor',
            'atributos_setor' => 'Atributos Setor',
            'cod_contrato' => 'Cod Contrato',
            'tipo_contrato_fk' => 'Tipo Contrato Fk',
            'valor_contrato' => 'Valor Contrato',
            'qnt_parcelas' => 'Qnt Parcelas',
            'dt_prazo' => 'Dt Prazo',
            'dt_inclusao_contrato' => 'Dt Inclusao Contrato',
            'cod_cliente_fk' => 'Cod Cliente Fk',
            'ativo_contrato' => 'Ativo Contrato',
            'cod_setor' => 'Cod Setor',
            'cod_usuario_responsavel_fk' => 'Cod Usuario Responsavel Fk',
            'dt_vencimento' => 'Dt Vencimento',
            'cod_tipo_setor_fk' => 'Cod Tipo Setor Fk',
            'cod_tipo_contrato' => 'Cod Tipo Contrato',
            'contrato_html' => 'Contrato Html',
        ];
    }

    /**
     * @inheritdoc
     * @return ViewClienteContratoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ViewClienteContratoQuery(get_called_class());
    }
}
