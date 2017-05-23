<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_cliente".
 *
 * @property string $cnpj
 * @property integer $ie
 * @property string $fantasia
 * @property string $razao_social
 * @property string $dt_inclusao
 * @property string $dt_exclusao
 * @property integer $cod_cliente
 * @property boolean $situacao
 */
class TabCliente extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tab_cliente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ie'], 'integer'],
            [['dt_inclusao', 'dt_exclusao'], 'safe'],
             [['cnpj', 'fistel', 'razao_social'], 'required'],
            [['situacao'], 'boolean'],
            [['cnpj'], 'string', 'max' => 18],
            [['fantasia', 'razao_social'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cnpj' => 'Cnpj',
            'ie' => 'Ie',
            'fantasia' => 'Fantasia',
            'razao_social' => 'Razao Social',
            'dt_inclusao' => 'Dt Inclusao',
            'dt_exclusao' => 'Dt Exclusao',
            'cod_cliente' => 'Cod Cliente',
            'situacao' => 'true - ativo
false - inativo',
        ];
    }

    /**
     * @inheritdoc
     * @return TabClienteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabClienteQuery(get_called_class());
    }
}
