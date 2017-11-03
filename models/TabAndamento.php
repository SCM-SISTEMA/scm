<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_andamento".
 *
 * @property integer $cod_andamento
 * @property string $dt_inclusao
 * @property string $dt_exclusao
 * @property string $txt_notificacao
 * @property string $dt_retorno
 * @property integer $cod_usuario_inclusao_fk
 * @property integer $cod_setor_fk
 *
 * @property TabUsuarios $tabUsuarios
 * @property TabSetores $tabSetores
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
            [['dt_inclusao', 'dt_exclusao', 'dt_retorno'], 'safe'],
            [['txt_notificacao'], 'string'],
            [['cod_usuario_inclusao_fk', 'cod_setor_fk'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_andamento' => 'Cod Andamento',
            'dt_inclusao' => 'Dt Inclusao',
            'dt_exclusao' => 'Dt Exclusao',
            'txt_notificacao' => 'Txt Notificacao',
            'dt_retorno' => 'Dt Retorno',
            'cod_usuario_inclusao_fk' => 'Cod Usuario Inclusao Fk',
            'cod_setor_fk' => 'Cod Setor Fk',
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
    public function getTabSetores()
    {
        return $this->hasOne(TabSetores::className(), ['cod_setor' => 'cod_setor_fk']);
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
