<?php

namespace app\modules\comercial\models;

use Yii;

/**
 * This is the model class for table "comercial.tab_tipo_contrato_responsavel".
 *
 * @property integer $cod_responsavel_tipo_contrato
 * @property integer $cod_usuario_fk
 * @property integer $cod_tipo_contrato_fk
 * @property string $dt_inclusao
 * @property string $dt_exclusao
 *
 * @property TabUsuarios $tabUsuarios
 * @property TabTipoContrato $tabTipoContrato
 */
class TabTipoContratoResponsavel extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercial.tab_tipo_contrato_responsavel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_usuario_fk', 'cod_tipo_contrato_fk'], 'integer'],
            [['dt_inclusao', 'dt_exclusao'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_responsavel_tipo_contrato' => 'Cod Responsavel Tipo Contrato',
            'cod_usuario_fk' => 'Cod Usuario Fk',
            'cod_tipo_contrato_fk' => 'Cod Tipo Contrato Fk',
            'dt_inclusao' => 'Dt Inclusao',
            'dt_exclusao' => 'Dt Exclusao',
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
    public function getTabTipoContrato()
    {
        return $this->hasOne(TabTipoContrato::className(), ['cod_tipo_contrato' => 'cod_tipo_contrato_fk']);
    }

    /**
     * @inheritdoc
     * @return TabTipoContratoResponsavelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabTipoContratoResponsavelQuery(get_called_class());
    }
}
