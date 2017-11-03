<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_setores".
 *
 * @property integer $cod_setor
 * @property integer $cod_tipo_contrato_fk
 * @property integer $cod_usuario_responsavel_fk
 * @property integer $cod_tipo_setor_fk
 * @property string $dt_inclusao
 * @property string $dt_exclusao
 *
 * @property TabAndamento[] $tabAndamento
 * @property TabUsuarios $tabUsuarios
 * @property TabTipoContrato $tabTipoContrato
 */
class TabSetores extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_setores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_tipo_contrato_fk', 'cod_usuario_responsavel_fk', 'cod_tipo_setor_fk'], 'integer'],
            [['dt_inclusao', 'dt_exclusao'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_setor' => 'Cod Setor',
            'cod_tipo_contrato_fk' => 'Cod Tipo Contrato Fk',
            'cod_usuario_responsavel_fk' => 'Cod Usuario Responsavel Fk',
            'cod_tipo_setor_fk' => 'Cod Tipo Setor Fk',
            'dt_inclusao' => 'Dt Inclusao',
            'dt_exclusao' => 'Dt Exclusao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabAndamento()
    {
        return $this->hasMany(TabAndamento::className(), ['cod_setor_fk' => 'cod_setor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabUsuarios()
    {
        return $this->hasOne(TabUsuarios::className(), ['cod_usuario' => 'cod_usuario_responsavel_fk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabTipoContrato()
    {
        return $this->hasOne(TabTipoContrato::className(), ['cod_tipo_contrato' => 'cod_tipo_contrato_fk']);
    }

    /**
     * @inheritdoc
     * @return TabSetoresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabSetoresQuery(get_called_class());
    }
}
