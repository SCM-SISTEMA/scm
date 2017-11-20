<?php

namespace app\modules\comercial\models;

use Yii;

/**
 * This is the model class for table "comercial.tab_modelo_contrato".
 *
 * @property integer $cod_modelo_contrato
 * @property integer $cod_contrato_tipo_contrato_fk
 * @property string $txt_modelo
 *
 * @property TabAtributosValores $tabAtributosValores
 */
class TabModeloContrato extends \projeto\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'comercial.tab_modelo_contrato';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cod_contrato_tipo_contrato_fk'], 'integer'],
            [['txt_modelo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'cod_modelo_contrato' => 'Cod Modelo Contrato',
            'cod_contrato_tipo_contrato_fk' => 'tabela atributo valor',
            'txt_modelo' => 'Txt Modelo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabAtributosValores() {
        return $this->hasOne(TabAtributosValores::className(), ['cod_atributos_valores' => 'cod_contrato_tipo_contrato_fk']);
    }

    /**
     * @inheritdoc
     * @return TabModeloContratoQuery the active query used by this AR class.
     */
    public static function find() {
        return new TabModeloContratoQuery(get_called_class());
    }


}
