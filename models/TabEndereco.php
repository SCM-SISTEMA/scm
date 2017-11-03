<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_endereco".
 *
 * @property integer $cod_endereco
 * @property string $logradouro
 * @property string $numero
 * @property string $complemento
 * @property string $cep
 * @property boolean $correspondencia
 * @property string $cod_municipio_fk
 * @property integer $chave_fk
 * @property integer $tipo_usuario
 * @property string $dt_inclusao
 * @property boolean $ativo
 *
 * @property TabMunicipios $tabMunicipios
 */
class TabEndereco extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_endereco';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['correspondencia', 'ativo'], 'boolean'],
            [['cod_municipio_fk'], 'required'],
            [['chave_fk', 'tipo_usuario'], 'integer'],
            [['dt_inclusao'], 'safe'],
            [['logradouro'], 'string', 'max' => 200],
            [['numero'], 'string', 'max' => 20],
            [['complemento'], 'string', 'max' => 100],
            [['cep'], 'string', 'max' => 10],
            [['cod_municipio_fk'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_endereco' => 'Cod Endereco',
            'logradouro' => 'Logradouro',
            'numero' => 'Numero',
            'complemento' => 'Complemento',
            'cep' => 'Cep',
            'correspondencia' => 'endereco para correspondencia??',
            'cod_municipio_fk' => 'Cod Municipio Fk',
            'chave_fk' => 'Chave Fk',
            'tipo_usuario' => '1 - cliente
2 - usuario',
            'dt_inclusao' => 'Dt Inclusao',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabMunicipios()
    {
        return $this->hasOne(TabMunicipios::className(), ['cod_municipio' => 'cod_municipio_fk']);
    }

    /**
     * @inheritdoc
     * @return TabEnderecoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabEnderecoQuery(get_called_class());
    }
}
