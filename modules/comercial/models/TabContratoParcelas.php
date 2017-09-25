<?php

namespace app\modules\comercial\models;

use Yii;

/**
 * This is the model class for table "comercial.tab_contrato_parcelas".
 *
 * @property integer $cod_contrato_parcelas
 * @property integer $cod_contrato_fk
 * @property integer $numero
 * @property string $valor
 * @property string $dt_inclusao
 * @property string $dt_vencimento
 * @property string $txt_login_inclusao
 * @property string $txt_login_alteracao
 * @property string $dt_alteracao
 *
 * @property TabContrato $tabContrato
 */
class TabContratoParcelas extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercial.tab_contrato_parcelas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_contrato_fk', 'numero'], 'integer'],
            [['valor'], 'number'],
            [['dt_inclusao', 'dt_vencimento', 'dt_alteracao'], 'safe'],
            [['txt_login_inclusao', 'txt_login_alteracao'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_contrato_parcelas' => 'Cod Contrato Parcelas',
            'cod_contrato_fk' => 'Cod Contrato Fk',
            'numero' => 'Numero',
            'valor' => 'Valor',
            'dt_inclusao' => 'Dt Inclusao',
            'dt_vencimento' => 'Dt Vencimento',
            'txt_login_inclusao' => 'Usuário da Inclusão',
            'txt_login_alteracao' => 'Usuário da Alteração',
            'dt_alteracao' => 'Dt Alteracao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabContrato()
    {
        return $this->hasOne(TabContrato::className(), ['cod_contrato' => 'cod_contrato_fk']);
    }

    /**
     * @inheritdoc
     * @return TabContratoParcelasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabContratoParcelasQuery(get_called_class());
    }
}
