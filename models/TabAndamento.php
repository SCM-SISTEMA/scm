<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_andamento".
 *
 * @property integer $cod_andamento
 * @property integer $cod_assunto_fk
 * @property string $dt_inclusao
 * @property string $dt_exclusao
 * @property integer $cod_tipo_contrato_fk
 * @property string $txt_notificacao
 * @property string $dt_retorno
 * @property integer $cod_modulo_fk
 * @property integer $cod_contrato_fk
 * @property integer $cod_usuario_inclusao_fk
 *
 * @property TabUsuarios $tabUsuarios
 * @property TabContratoTipoContrato $tabContratoTipoContrato
 */
class TabAndamento extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_andamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_assunto_fk', 'cod_tipo_contrato_fk', 'cod_modulo_fk', 'cod_contrato_fk', 'cod_usuario_inclusao_fk'], 'integer'],
            [['dt_inclusao', 'dt_exclusao', 'dt_retorno'], 'safe'],
            [['txt_notificacao'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_andamento' => 'Cod Andamento',
            'cod_assunto_fk' => 'attributo valor do assunto que é a notificação',
            'dt_inclusao' => 'Dt Inclusao',
            'dt_exclusao' => 'Dt Exclusao',
            'cod_tipo_contrato_fk' => 'Cod Tipo Contrato Fk',
            'txt_notificacao' => 'Txt Notificacao',
            'dt_retorno' => 'Dt Retorno',
            'cod_modulo_fk' => 'Cod Modulo Fk',
            'cod_contrato_fk' => 'Cod Contrato Fk',
            'cod_usuario_inclusao_fk' => 'Cod Usuario Inclusao Fk',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabUsuarios()
    {
        return $this->hasOne(TabUsuarios::className(), ['cod_usuario' => 'cod_usuario_inclusao_fk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabContratoTipoContrato()
    {
        return $this->hasOne(TabContratoTipoContrato::className(), ['cod_contrato_tipo_contrato' => 'cod_tipo_contrato_fk']);
    }

    /**
     * @inheritdoc
     * @return TabAndamentoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabAndamentoQuery(get_called_class());
    }
}
