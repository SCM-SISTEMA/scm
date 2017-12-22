<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_regiao".
 *
 * @property integer $cod_regiao
 * @property string $uf_fk
 * @property integer $cod_atributo_regiao
 *
 * @property TabAtributosValores $tabAtributosValores
 * @property TabEstados $tabEstados
 */
class TabRegiao extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_regiao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_regiao'], 'required'],
            [['cod_regiao', 'cod_atributo_regiao'], 'integer'],
            [['uf_fk'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_regiao' => 'Cod Regiao',
            'uf_fk' => 'Uf Fk',
            'cod_atributo_regiao' => 'Cod Atributo Regiao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabAtributosValores()
    {
        return $this->hasOne(TabAtributosValores::className(), ['cod_atributos_valores' => 'cod_atributo_regiao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabEstados()
    {
        return $this->hasOne(TabEstados::className(), ['sgl_estado' => 'uf_fk']);
    }

    /**
     * @inheritdoc
     * @return TabRegiaoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabRegiaoQuery(get_called_class());
    }
}
