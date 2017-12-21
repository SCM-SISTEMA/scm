<?php

namespace app\modules\comercial\models;

use Yii;

/**
 * This is the model class for table "comercial.tab_contrato_anexo".
 *
 * @property integer $cod_contrato_anexo
 * @property string $nome
 * @property string $url
 * @property integer $cod_contrato_fk
 *
 * @property TabContrato $tabContrato
 */
class TabContratoAnexo extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercial.tab_contrato_anexo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_contrato_fk'], 'integer'],
            [['nome'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 120]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_contrato_anexo' => 'Cod Contrato Anexo',
            'nome' => 'Nome',
            'url' => 'Url',
            'cod_contrato_fk' => 'Cod Contrato Fk',
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
     * @return TabContratoAnexoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabContratoAnexoQuery(get_called_class());
    }
}
