<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_mesorregioes".
 *
 * @property integer $cod_mesorregiao
 * @property integer $cod_estado_fk
 * @property string $txt_nome
 *
 * @property TabMicrorregioes[] $tabMicrorregioes
 */
class TabMesorregioes extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_mesorregioes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_mesorregiao', 'cod_estado_fk', 'txt_nome'], 'required'],
            [['cod_mesorregiao', 'cod_estado_fk'], 'integer'],
            [['txt_nome'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_mesorregiao' => 'Código Mesoregião',
            'cod_estado_fk' => 'Código do Estado',
            'txt_nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabMicrorregioes()
    {
        return $this->hasMany(TabMicrorregioes::className(), ['fk_mesorregiao' => 'cod_mesorregiao']);
    }

    /**
     * @inheritdoc
     * @return TabMesorregioesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabMesorregioesQuery(get_called_class());
    }
}
