<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_atributos_valores".
 *
 * @property integer $cod_atributos_valores
 * @property integer $fk_atributos_valores_atributos_id
 * @property string $sgl_valor
 * @property string $dsc_descricao
 * @property string $txt_login_inclusao
 * @property string $txt_login_alteracao
 * @property string $txt_login_exclusao
 * @property string $dt_alteracao
 *
 * @property TabContratoTipoContrato[] $tabContratoTipoContrato
 * @property TabContratoTipoContrato[] $tabContratoTipoContrato0
 * @property TabModeloContrato[] $tabModeloContrato
 * @property TabAtributos $tabAtributos
 * @property TabContato[] $tabContato
 * @property TabModeloDocs[] $tabModeloDocs
 * @property TabModeloDocs[] $tabModeloDocs0
 * @property TabModeloDocs[] $tabModeloDocs1
 * @property TabModeloDocs[] $tabModeloDocs2
 * @property TabMunicipios[] $tabMunicipios
 * @property TabRegiao[] $tabRegiao
 */
class TabAtributosValores extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_atributos_valores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_atributos_valores_atributos_id'], 'integer'],
            [['sgl_valor'], 'string'],
            [['dt_alteracao'], 'safe'],
            [['dsc_descricao'], 'string', 'max' => 200],
            [['txt_login_inclusao', 'txt_login_alteracao', 'txt_login_exclusao'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_atributos_valores' => 'Cod Atributos Valores',
            'fk_atributos_valores_atributos_id' => 'Fk Atributos Valores Atributos ID',
            'sgl_valor' => 'Sgl Valor',
            'dsc_descricao' => 'Dsc Descricao',
            'txt_login_inclusao' => 'Txt Login Inclusao',
            'txt_login_alteracao' => 'Txt Login Alteracao',
            'txt_login_exclusao' => 'Txt Login Exclusao',
            'dt_alteracao' => 'Dt Alteracao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabContratoTipoContrato()
    {
        return $this->hasMany(TabContratoTipoContrato::className(), ['cod_contrato_fk' => 'cod_atributos_valores']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabContratoTipoContrato0()
    {
        return $this->hasMany(TabContratoTipoContrato::className(), ['cod_tipo_contrato_fk' => 'cod_atributos_valores']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabModeloContrato()
    {
        return $this->hasMany(TabModeloContrato::className(), ['cod_contrato_tipo_contrato_fk' => 'cod_atributos_valores']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabAtributos()
    {
        return $this->hasOne(TabAtributos::className(), ['cod_atributos' => 'fk_atributos_valores_atributos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabContato()
    {
        return $this->hasMany(TabContato::className(), ['tipo' => 'cod_atributos_valores']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabModeloDocs()
    {
        return $this->hasMany(TabModeloDocs::className(), ['cabecalho_fk' => 'cod_atributos_valores']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabModeloDocs0()
    {
        return $this->hasMany(TabModeloDocs::className(), ['rodape_fk' => 'cod_atributos_valores']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabModeloDocs1()
    {
        return $this->hasMany(TabModeloDocs::className(), ['tipo_modelo_documento_fk' => 'cod_atributos_valores']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabModeloDocs2()
    {
        return $this->hasMany(TabModeloDocs::className(), ['finalidade_fk' => 'cod_atributos_valores']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabMunicipios()
    {
        return $this->hasMany(TabMunicipios::className(), ['regiao_hidrografica_fk' => 'cod_atributos_valores']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabRegiao()
    {
        return $this->hasMany(TabRegiao::className(), ['cod_atributo_regiao' => 'cod_atributos_valores']);
    }

    /**
     * @inheritdoc
     * @return TabAtributosValoresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabAtributosValoresQuery(get_called_class());
    }
}
