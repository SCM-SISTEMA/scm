<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_atributos".
 *
 * @property integer $cod_atributos
 * @property string $dsc_descricao
 * @property string $sgl_chave
 *
 * @property TabAtributosValores[] $tabAtributosValores
 */
class TabAtributos extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_atributos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dsc_descricao', 'sgl_chave'], 'string'],
            [['sgl_chave'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_atributos' => 'Cod Atributos',
            'dsc_descricao' => 'Dsc Descricao',
            'sgl_chave' => 'Sgl Chave',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabAtributosValores()
    {
        return $this->hasMany(TabAtributosValores::className(), ['fk_atributos_valores_atributos_id' => 'cod_atributos']);
    }

    /**
     * @inheritdoc
     * @return TabAtributosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabAtributosQuery(get_called_class());
    }
}
