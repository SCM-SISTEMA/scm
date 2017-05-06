<?php

namespace app\modules\comercial\models;

use Yii;

/**
 * This is the model class for table "comercial.tab_contrato".
 *
 * @property integer $cod_contrato
 * @property integer $tipo_contrato_fk
 * @property string $valor_contrato
 * @property integer $dia_vencimento
 * @property integer $qnt_parcelas
 * @property string $dt_prazo
 *
 * @property TabTipoContrato[] $tabTipoContrato
 */
class TabContrato extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercial.tab_contrato';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo_contrato_fk', 'dia_vencimento', 'qnt_parcelas'], 'integer'],
            [['valor_contrato'], 'number'],
            [['dt_prazo'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_contrato' => 'Cod Contrato',
            'tipo_contrato_fk' => 'atributos - tipo-contrato',
            'valor_contrato' => 'Valor Contrato',
            'dia_vencimento' => 'Dia Vencimento',
            'qnt_parcelas' => 'Qnt Parcelas',
            'dt_prazo' => 'Dt Prazo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabTipoContrato()
    {
        return $this->hasMany(TabTipoContrato::className(), ['cod_contrato_fk' => 'cod_contrato']);
    }

    /**
     * @inheritdoc
     * @return TabContratoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabContratoQuery(get_called_class());
    }
}
