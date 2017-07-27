<?php

namespace app\modules\comercial\models;

use Yii;

/**
 * This is the model class for table "comercial.vis_cliente_contrato_responsavel".
 *
 * @property string $cnpj
 * @property integer $ie
 * @property string $fantasia
 * @property string $razao_social
 * @property string $dt_inclusao_cliente
 * @property integer $cod_cliente
 * @property boolean $situacao
 * @property string $fistel
 * @property string $obs
 * @property string $responsavel
 * @property string $natureza_juridica
 * @property integer $cod_contrato
 * @property integer $tipo_contrato_fk
 * @property string $valor_contrato
 * @property integer $dia_vencimento
 * @property integer $qnt_parcelas
 * @property string $dt_prazo
 * @property string $dt_inclusao_contrato
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
 * @property integer $cod_cliente_fk
 * @property boolean $ativo_contrato
 * @property integer $cod_responsavel_tipo_contrato
 * @property integer $cod_usuario_perfil_fk
 * @property integer $cod_tipo_contrato_fk
 * @property integer $cod_tipo_contrato
 * @property integer $cod_usuario_tipo_contrato_fk
 * @property integer $cod_contrato_fk
 * @property integer $tipo_produto_fk
 * @property boolean $ativo_tipo_contrato
 * @property integer $cod_usuario_fk
 * @property integer $cod_modulo_fk
 * @property string $id_modulo
 * @property string $txt_nome
 * @property string $txt_ativo
 * @property string $txt_login
 */
class VisClienteContratoResponsavel extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercial.vis_cliente_contrato_responsavel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ie', 'cod_cliente', 'cod_contrato', 'tipo_contrato_fk', 'dia_vencimento', 'qnt_parcelas', 'responsavel_fk', 'qnt_clientes', 'cod_cliente_fk', 'cod_responsavel_tipo_contrato', 'cod_usuario_perfil_fk', 'cod_tipo_contrato_fk', 'cod_tipo_contrato', 'cod_usuario_tipo_contrato_fk', 'cod_contrato_fk', 'tipo_produto_fk', 'cod_usuario_fk', 'cod_modulo_fk'], 'integer'],
            [['dt_inclusao_cliente', 'dt_prazo', 'dt_inclusao_contrato', 'dt_vencimento'], 'safe'],
            [['situacao', 'operando', 'link', 'zero800', 'parceiria', 'consultoria_scm', 'engenheiro_tecnico', 'ativo_contrato', 'ativo_tipo_contrato'], 'boolean'],
            [['obs'], 'string'],
            [['valor_contrato'], 'number'],
            [['cnpj'], 'string', 'max' => 18],
            [['fantasia', 'razao_social'], 'string', 'max' => 200],
            [['fistel'], 'string', 'max' => 15],
            [['responsavel', 'natureza_juridica'], 'string', 'max' => 300],
            [['contador'], 'string', 'max' => 150],
            [['id_modulo'], 'string', 'max' => 40],
            [['txt_nome'], 'string', 'max' => 70],
            [['txt_ativo'], 'string', 'max' => 1],
            [['txt_login'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cnpj' => 'Cnpj',
            'ie' => 'Ie',
            'fantasia' => 'Fantasia',
            'razao_social' => 'Razao Social',
            'dt_inclusao_cliente' => 'Dt Inclusao Cliente',
            'cod_cliente' => 'Cod Cliente',
            'situacao' => 'Situacao',
            'fistel' => 'Fistel',
            'obs' => 'Obs',
            'responsavel' => 'Responsavel',
            'natureza_juridica' => 'Natureza Juridica',
            'cod_contrato' => 'Cod Contrato',
            'tipo_contrato_fk' => 'Tipo Contrato Fk',
            'valor_contrato' => 'Valor Contrato',
            'dia_vencimento' => 'Dia Vencimento',
            'qnt_parcelas' => 'Qnt Parcelas',
            'dt_prazo' => 'Dt Prazo',
            'dt_inclusao_contrato' => 'Dt Inclusao Contrato',
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
            'cod_cliente_fk' => 'Cod Cliente Fk',
            'ativo_contrato' => 'Ativo Contrato',
            'cod_responsavel_tipo_contrato' => 'Cod Responsavel Tipo Contrato',
            'cod_usuario_perfil_fk' => 'Cod Usuario Perfil Fk',
            'cod_tipo_contrato_fk' => 'Cod Tipo Contrato Fk',
            'cod_tipo_contrato' => 'Cod Tipo Contrato',
            'cod_usuario_tipo_contrato_fk' => 'Cod Usuario Tipo Contrato Fk',
            'cod_contrato_fk' => 'Cod Contrato Fk',
            'tipo_produto_fk' => 'Tipo Produto Fk',
            'ativo_tipo_contrato' => 'Ativo Tipo Contrato',
            'cod_usuario_fk' => 'Cod Usuario Fk',
            'cod_modulo_fk' => 'Cod Modulo Fk',
            'id_modulo' => 'Id Modulo',
            'txt_nome' => 'Txt Nome',
            'txt_ativo' => 'Txt Ativo',
            'txt_login' => 'Txt Login',
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\posoutorga\models\VisClienteContratoResponsavelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\posoutorga\models\VisClienteContratoResponsavelQuery(get_called_class());
    }
}
