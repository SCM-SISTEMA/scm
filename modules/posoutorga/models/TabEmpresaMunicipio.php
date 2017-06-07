<?php

namespace app\modules\posoutorga\models;

use Yii;

/**
 * This is the model class for table "pos_outorga.tab_empresa_municipio".
 *
 * @property integer $cod_empresa_municipio
 * @property string $cod_municipio_fk
 * @property string $municipio
 * @property string $uf
 * @property integer $capacidade_municipio
 * @property integer $capacidade_servico
 * @property integer $cod_sici_fk
 * @property integer $tecnologia_fk
 * @property string $total_512
 * @property string $total_512k_2m
 * @property string $total_2m_12m
 * @property string $total_12m_34m
 * @property string $total_34m
 * @property string $total_fisica
 * @property string $total_juridica
 * @property boolean $cod_municipio_fk_check
 * @property boolean $capacidade_municipio_check
 * @property boolean $capacidade_servico_check
 * @property boolean $tecnologia_fk_check
 * @property boolean $total_check
 * @property boolean $total_fisica_check
 * @property boolean $total_juridica_check
 *
 * @property TabSici $tabSici
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
            [['capacidade_municipio', 'capacidade_servico', 'cod_sici_fk', 'tecnologia_fk'], 'integer'],
            [['total_512', 'total_512k_2m', 'total_2m_12m', 'total_12m_34m', 'total_34m', 'total_fisica', 'total_juridica'], 'number'],
            [['cod_municipio_fk_check', 'capacidade_municipio_check', 'capacidade_servico_check', 'tecnologia_fk_check', 'total_check', 'total_fisica_check', 'total_juridica_check'], 'boolean'],
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
            'cod_municipio_fk' => 'Cod Municipio Fk',
            'municipio' => 'Municipio',
            'uf' => 'Uf',
            'capacidade_municipio' => 'Capacidade total do sistema implantada em Mb por municipio onde tem pop',
            'capacidade_servico' => 'Capacidade total do sistema implantada e em serviço em Mbps',
            'cod_sici_fk' => 'Cod Sici Fk',
            'tecnologia_fk' => 'tecnologia -> atributos',
            'total_512' => 'Total 512',
            'total_512k_2m' => 'Total 512k 2m',
            'total_2m_12m' => 'Total 2m 12m',
            'total_12m_34m' => 'Total 12m 34m',
            'total_34m' => 'Total 34m',
            'total_fisica' => 'Total Fisica',
            'total_juridica' => 'Total Juridica',
            'cod_municipio_fk_check' => 'Cod Municipio Fk Check',
            'capacidade_municipio_check' => 'Check Capacidade total do sistema implantada em Mb por municipio onde tem pop',
            'capacidade_servico_check' => 'Check Capacidade total do sistema implantada e em serviço em Mbps',
            'tecnologia_fk_check' => 'Check tecnologia -> atributos',
            'total_check' => 'Total Check',
            'total_fisica_check' => 'Total Fisica Check',
            'total_juridica_check' => 'Total Juridica Check',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabSici()
    {
        return $this->hasOne(TabSici::className(), ['cod_sici' => 'cod_sici_fk']);
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
