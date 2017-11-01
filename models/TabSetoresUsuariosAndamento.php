<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_setores_usuarios_andamento".
 *
 * @property integer $cod_setor_usuario_antamento
 * @property integer $cod_andamento_fk
 * @property integer $cod_setor_fk
 * @property string $dt_inclusao
 * @property string $dt_exclusao
 * @property integer $cod_usuario_inclusao_fk
 *
 * @property TabUsuarios $tabUsuarios
 * @property TabAndamento $tabAndamento
 * @property TabSetores $tabSetores
 */
class TabSetoresUsuariosAndamento extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_setores_usuarios_andamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_andamento_fk', 'cod_setor_fk', 'cod_usuario_inclusao_fk'], 'integer'],
            [['dt_inclusao', 'dt_exclusao'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_setor_usuario_antamento' => 'Cod Setor Usuario Antamento',
            'cod_andamento_fk' => 'Cod Andamento Fk',
            'cod_setor_fk' => 'Cod Setor Fk',
            'dt_inclusao' => 'Dt Inclusao',
            'dt_exclusao' => 'Dt Exclusao',
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
    public function getTabAndamento()
    {
        return $this->hasOne(TabAndamento::className(), ['cod_andamento' => 'cod_andamento_fk']);
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
     * @return TabSetoresUsuariosAndamentoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabSetoresUsuariosAndamentoQuery(get_called_class());
    }
}
