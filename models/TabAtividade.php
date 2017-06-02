<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_atividade".
 *
 * @property integer $cod_atividade
 * @property string $descricao
 * @property string $codigo
 * @property boolean $primario
 * @property integer $cod_cliente_fk
 *
 * @property TabCliente $tabCliente
 */
class TabAtividade extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_atividade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['primario'], 'boolean'],
            [['cod_cliente_fk'], 'integer'],
            [['descricao'], 'string', 'max' => 300],
            [['codigo'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_atividade' => 'Cod Atividade',
            'descricao' => 'Descricao',
            'codigo' => 'Codigo',
            'primario' => 'true - principal
false -secundario',
            'cod_cliente_fk' => 'Cod Cliente Fk',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabCliente()
    {
        return $this->hasOne(TabCliente::className(), ['cod_cliente' => 'cod_cliente_fk']);
    }

    /**
     * @inheritdoc
     * @return TabAtividadeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabAtividadeQuery(get_called_class());
    }
}
