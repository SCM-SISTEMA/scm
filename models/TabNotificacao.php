<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_notificacao".
 *
 * @property integer $cod_notificacao
 * @property integer $cod_assunto_fk
 * @property string $dt_inclusao
 * @property string $dt_exclusao
 * @property integer $cod_tipo_contrato_responsavel_fk
 * @property string $txt_notificacao
 *
 * @property TabTipoContratoResponsavel $tabTipoContratoResponsavel
 */
class TabNotificacao extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_notificacao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_assunto_fk', 'cod_tipo_contrato_responsavel_fk'], 'integer'],
            [['dt_inclusao', 'dt_exclusao'], 'safe'],
            [['txt_notificacao'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_notificacao' => 'Cod Notificacao',
            'cod_assunto_fk' => 'attributo valor do assunto que é a notificação',
            'dt_inclusao' => 'Dt Inclusao',
            'dt_exclusao' => 'Dt Exclusao',
            'cod_tipo_contrato_responsavel_fk' => 'Cod Tipo Contrato Responsavel Fk',
            'txt_notificacao' => 'Txt Notificacao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabTipoContratoResponsavel()
    {
        return $this->hasOne(TabTipoContratoResponsavel::className(), ['cod_responsavel_tipo_contrato' => 'cod_tipo_contrato_responsavel_fk']);
    }

    /**
     * @inheritdoc
     * @return TabNotificacaoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabNotificacaoQuery(get_called_class());
    }
}
