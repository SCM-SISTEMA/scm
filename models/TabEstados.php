<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_estados".
 *
 * @property string $sgl_estado
 * @property string $cod_estado
 * @property string $txt_nome
 * @property string $cod_cpt_est
 * @property integer $qtd_mun_est
 * @property string $vlr_taxa_hab_dom
 * @property integer $cod_regiao_geografica
 *
 * @property TabRegioesGeograficas $tabRegioesGeograficas
 * @property TabMunicipios[] $tabMunicipios
 */
class TabEstados extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_estados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sgl_estado', 'cod_estado', 'txt_nome', 'cod_cpt_est'], 'required'],
            [['qtd_mun_est', 'cod_regiao_geografica'], 'integer'],
            [['vlr_taxa_hab_dom'], 'number'],
            [['sgl_estado', 'cod_estado'], 'string', 'max' => 2],
            [['txt_nome'], 'string', 'max' => 20],
            [['cod_cpt_est'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sgl_estado' => 'SIgla do Estado',
            'cod_estado' => 'COD_EST',
            'txt_nome' => 'Nome do estado',
            'cod_cpt_est' => 'COD_CPT_EST',
            'qtd_mun_est' => 'QTD_MUN_EST',
            'vlr_taxa_hab_dom' => 'TX_HAB_DOM',
            'cod_regiao_geografica' => 'Código da Região Geográfica',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabRegioesGeograficas()
    {
        return $this->hasOne(TabRegioesGeograficas::className(), ['cod_regiao_geografica' => 'cod_regiao_geografica']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabMunicipios()
    {
        return $this->hasMany(TabMunicipios::className(), ['sgl_estado_fk' => 'sgl_estado']);
    }

    /**
     * @inheritdoc
     * @return TabEstadosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabEstadosQuery(get_called_class());
    }
}
