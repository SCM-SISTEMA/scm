<?php

namespace app\modules\comercial\models;

use Yii;

/**
 * This is the model class for table "comercial.tab_contrato".
 *
 * @property integer $cod_contrato
 * @property integer $tipo_contrato_fk
 * @property string $valor_contrato
 * @property integer $dia_vencimento
 * @property integer $qnt_parcelas
 * @property string $dt_prazo
 * @property string $dt_inclusao
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
 * @property boolean $ativo
 * @property string $txt_login_inclusao
 * @property string $txt_login_alteracao
 * @property string $dt_alteracao
 *
 * @property TabUsuarios $tabUsuarios
 * @property TabCliente $tabCliente
 * @property TabContratoParcelas[] $tabContratoParcelas
 * @property TabTipoContrato[] $tabTipoContrato
 */
class TabContrato extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercial.tab_contrato';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo_contrato_fk', 'dia_vencimento', 'qnt_parcelas', 'responsavel_fk', 'qnt_clientes', 'cod_cliente_fk'], 'integer'],
            [['valor_contrato'], 'number'],
            [['dt_prazo', 'dt_inclusao', 'dt_vencimento', 'dt_alteracao'], 'safe'],
            [['operando', 'link', 'zero800', 'parceiria', 'consultoria_scm', 'engenheiro_tecnico', 'ativo'], 'boolean'],
            [['contador', 'txt_login_inclusao', 'txt_login_alteracao'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_contrato' => 'Cod Contrato',
            'tipo_contrato_fk' => 'atributos - tipo-contrato',
            'valor_contrato' => 'Valor Contrato',
            'dia_vencimento' => 'Dia Vencimento',
            'qnt_parcelas' => 'Qnt Parcelas',
            'dt_prazo' => 'Dt Prazo',
            'dt_inclusao' => 'Dt Inclusao',
            'dt_vencimento' => 'Dt Vencimento',
            'contador' => 'Contador',
            'responsavel_fk' => 'Responsavel Fk',
            'operando' => 'Já está operando?',
            'qnt_clientes' => 'Qnt Clientes',
            'link' => 'Possui link dedicado?',
            'zero800' => 'Possui 0800?',
            'parceiria' => 'Tem parceiria?',
            'consultoria_scm' => 'Paga consutoria SCM mensal?',
            'engenheiro_tecnico' => 'Possui engenheiro ou técnico responsável?',
            'cod_cliente_fk' => 'Cod Cliente Fk',
            'ativo' => 'Ativo',
            'txt_login_inclusao' => 'Usuário da Inclusão',
            'txt_login_alteracao' => 'Usuário da Alteração',
            'dt_alteracao' => 'Dt Alteracao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabUsuarios()
    {
        return $this->hasOne(TabUsuarios::className(), ['cod_usuario' => 'responsavel_fk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabCliente()
    {
        return $this->hasOne(TabCliente::className(), ['cod_cliente' => 'cod_cliente_fk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabContratoParcelas()
    {
        return $this->hasMany(TabContratoParcelas::className(), ['cod_contrato_fk' => 'cod_contrato']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabTipoContrato()
    {
        return $this->hasMany(TabTipoContrato::className(), ['cod_contrato_fk' => 'cod_contrato']);
    }

    /**
     * @inheritdoc
     * @return \app\modules\posoutorga\models\TabContratoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\posoutorga\models\TabContratoQuery(get_called_class());
    }
}
