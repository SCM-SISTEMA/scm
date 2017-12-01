<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "view_contato".
 *
 * @property integer $chave_fk
 * @property string $tipo_tabela_fk
 * @property string $contato
 */
class ViewContato extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_contato';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chave_fk'], 'integer'],
            [['contato'], 'string'],
            [['tipo_tabela_fk'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chave_fk' => 'Chave Fk',
            'tipo_tabela_fk' => 'Tipo Tabela Fk',
            'contato' => 'Contato',
        ];
    }

    /**
     * @inheritdoc
     * @return ViewContatoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ViewContatoQuery(get_called_class());
    }
}
