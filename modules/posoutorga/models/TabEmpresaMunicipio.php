<?php

namespace app\modules\posoutorga\models;

use Yii;

/**
 * This is the model class for table "pos_outorga.tab_empresa_municipio".
 *
 * @property integer $cod_empresa_municipio
 * @property string $tecnologia
 * @property string $cod_municipio_fk
 * @property string $municipio
 * @property string $uf
 * @property integer $capacidade_municipio
 * @property integer $capacidade_servico
 *
 * @property TabMunicipios $tabMunicipios
 */
class TabEmpresaMunicipio extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pos_outorga.tab_empresa_municipio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_empresa_municipio'], 'required'],
            [['cod_empresa_municipio', 'capacidade_municipio', 'capacidade_servico'], 'integer'],
            [['tecnologia'], 'string', 'max' => 200],
            [['cod_municipio_fk'], 'string', 'max' => 6],
            [['municipio'], 'string', 'max' => 45],
            [['uf'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_empresa_municipio' => 'Cod Empresa Municipio',
            'tecnologia' => 'Tecnologia',
            'cod_municipio_fk' => 'Cod Municipio Fk',
            'municipio' => 'Municipio',
            'uf' => 'Uf',
            'capacidade_municipio' => 'Capacidade total do sistema implantada em Mb por municipio onde tem pop',
            'capacidade_servico' => 'Capacidade total do sistema implantada e em serviço em Mbps',
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
     * @return TabEmpresaMunicipioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabEmpresaMunicipioQuery(get_called_class());
    }
}
