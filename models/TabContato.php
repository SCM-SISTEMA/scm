<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_contato".
 *
 * @property integer $cod_contato
 * @property string $contato
 * @property string $ramal
 * @property boolean $ativo
 * @property string $dt_inclusao
 * @property integer $tipo
 * @property integer $chave_fk
 *
 * @property TabAtributosValores $tabAtributosValores
 */
class TabContato extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_contato';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ativo'], 'boolean'],
            [['dt_inclusao'], 'safe'],
            [['tipo', 'chave_fk'], 'integer'],
            [['contato'], 'string', 'max' => 200],
            [['ramal'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_contato' => 'Cod Contato',
            'contato' => 'Contato',
            'ramal' => 'Ramal',
            'ativo' => 'Ativo',
            'dt_inclusao' => 'Dt Inclusao',
            'tipo' => 'atributo valor -> tipo-contato',
            'chave_fk' => 'Chave Fk',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabAtributosValores()
    {
        return $this->hasOne(TabAtributosValores::className(), ['cod_atributos_valores' => 'tipo']);
    }

    /**
     * @inheritdoc
     * @return TabContatoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabContatoQuery(get_called_class());
    }
}
