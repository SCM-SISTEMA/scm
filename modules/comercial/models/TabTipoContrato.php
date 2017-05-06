<?php

namespace app\modules\comercial\models;

use Yii;

/**
 * This is the model class for table "comercial.tab_tipo_contrato".
 *
 * @property integer $cod_tipo_contrato
 * @property integer $cod_usuario_fk
 * @property integer $cod_contrato_fk
 *
 * @property TabUsuarios $tabUsuarios
 * @property TabContrato $tabContrato
 * @property TabBoleto[] $tabBoleto
 */
class TabTipoContrato extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercial.tab_tipo_contrato';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_usuario_fk', 'cod_contrato_fk'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_tipo_contrato' => 'Cod Tipo Contrato',
            'cod_usuario_fk' => 'usuario responsavel
',
            'cod_contrato_fk' => 'Cod Contrato Fk',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabUsuarios()
    {
        return $this->hasOne(TabUsuarios::className(), ['cod_usuario' => 'cod_usuario_fk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabContrato()
    {
        return $this->hasOne(TabContrato::className(), ['cod_contrato' => 'cod_contrato_fk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabBoleto()
    {
        return $this->hasMany(TabBoleto::className(), ['cod_tipo_contrato_fk' => 'cod_tipo_contrato']);
    }

    /**
     * @inheritdoc
     * @return TabTipoContratoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabTipoContratoQuery(get_called_class());
    }
}
