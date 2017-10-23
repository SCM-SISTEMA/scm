<?php

namespace app\modules\comercial\models;

use Yii;

/**
 * This is the model class for table "comercial.tab_contrato_tipo_contrato".
 *
 * @property integer $cod_contrato_tipo_contrato
 * @property integer $cod_contrato_fk
 * @property integer $cod_tipo_contrato_fk
 * @property string $txt_login_inclusao
 * @property string $txt_login_alteracao
 * @property string $dt_inclusao
 * @property string $dt_alteracao
 *
 * @property TabAtributosValores $tabAtributosValores
 * @property TabAtributosValores $tabAtributosValores0
 */
class TabContratoTipoContrato extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercial.tab_contrato_tipo_contrato';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_contrato_fk', 'cod_tipo_contrato_fk'], 'integer'],
            [['dt_inclusao', 'dt_alteracao'], 'safe'],
            [['txt_login_inclusao', 'txt_login_alteracao'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_contrato_tipo_contrato' => 'Cod Contrato Tipo Contrato',
            'cod_contrato_fk' => 'Cod Contrato Fk',
            'cod_tipo_contrato_fk' => 'Cod Tipo Contrato Fk',
            'txt_login_inclusao' => 'Usuário da Inclusão',
            'txt_login_alteracao' => 'Usuário da Alteração',
            'dt_inclusao' => 'Dt Inclusao',
            'dt_alteracao' => 'Dt Alteracao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabAtributosValores()
    {
        return $this->hasOne(TabAtributosValores::className(), ['cod_atributos_valores' => 'cod_contrato_fk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabAtributosValores0()
    {
        return $this->hasOne(TabAtributosValores::className(), ['cod_atributos_valores' => 'cod_tipo_contrato_fk']);
    }

    /**
     * @inheritdoc
     * @return TabContratoTipoContratoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabContratoTipoContratoQuery(get_called_class());
    }
}
