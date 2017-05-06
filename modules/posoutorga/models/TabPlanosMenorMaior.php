<?php

namespace app\modules\posoutorga\models;

use Yii;

/**
 * This is the model class for table "pos_outorga.tab_planos_menor_maior".
 *
 * @property integer $cod_plano_menor_maior
 * @property string $valor_menos_1m_ded
 * @property string $valor_menos_1m
 * @property string $valor_maior_1m_ded
 * @property string $valor_maior_1m
 * @property integer $cod_plano_fk
 *
 * @property TabPlanos $tabPlanos
 */
class TabPlanosMenorMaior extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pos_outorga.tab_planos_menor_maior';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor_menos_1m_ded', 'valor_menos_1m', 'valor_maior_1m_ded', 'valor_maior_1m'], 'number'],
            [['cod_plano_fk'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_plano_menor_maior' => 'Cod Plano Menor Maior',
            'valor_menos_1m_ded' => 'Menor preço por 1 Mbps (Dedicado)',
            'valor_menos_1m' => 'Menor preço por 1 Mbps (não dedicado)',
            'valor_maior_1m_ded' => 'Maior preço por 1 Mbps (dedicado)',
            'valor_maior_1m' => 'Maior preço por 1 Mbps (não dedicado)',
            'cod_plano_fk' => 'Cod Plano Fk',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabPlanos()
    {
        return $this->hasOne(TabPlanos::className(), ['cod_plano' => 'cod_plano_fk']);
    }

    /**
     * @inheritdoc
     * @return TabPlanosMenorMaiorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabPlanosMenorMaiorQuery(get_called_class());
    }
}
