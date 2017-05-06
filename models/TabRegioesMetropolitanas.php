<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_regioes_metropolitanas".
 *
 * @property integer $cod_regiao_metropolitana
 * @property string $txt_nome
 *
 * @property TabMunicipios[] $tabMunicipios
 */
class TabRegioesMetropolitanas extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_regioes_metropolitanas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nome'], 'required'],
            [['txt_nome'], 'string', 'max' => 2000],
            [['txt_nome'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_regiao_metropolitana' => 'Código da região metropolitana',
            'txt_nome' => 'Nome da Região Metropolitana',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabMunicipios()
    {
        return $this->hasMany(TabMunicipios::className(), ['cod_regiao_metropolitana_fk' => 'cod_regiao_metropolitana']);
    }

    /**
     * @inheritdoc
     * @return TabRegioesMetropolitanasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabRegioesMetropolitanasQuery(get_called_class());
    }
}
