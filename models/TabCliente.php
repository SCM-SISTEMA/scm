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
 * @property string $fistel
 * @property string $obs
 * @property string $responsavel
 *
 * @property TabContrato[] $tabContrato
 * @property TabSocios[] $tabSocios
 * @property TabAtividade[] $tabAtividade
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
            [['situacao'], 'boolean'],
            [['obs'], 'string'],
            [['cnpj'], 'string', 'max' => 18],
            [['fantasia', 'razao_social'], 'string', 'max' => 200],
            [['fistel'], 'string', 'max' => 15],
            [['responsavel'], 'string', 'max' => 150]
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
            'fistel' => 'Fistel',
            'obs' => 'Observação',
            'responsavel' => 'Responsavel',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabContrato()
    {
        return $this->hasMany(TabContrato::className(), ['cod_cliente_fk' => 'cod_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabSocios()
    {
        return $this->hasMany(TabSocios::className(), ['cod_cliente_fk' => 'cod_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabAtividade()
    {
        return $this->hasMany(TabAtividade::className(), ['cod_cliente_fk' => 'cod_cliente']);
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
