<?php

namespace app\modules\comercial\models;

use Yii;

/**
 * This is the model class for table "comercial.tab_representante_comercial".
 *
 * @property integer $cod_representante_comercial
 * @property string $nome
 * @property string $nacionalidade
 * @property integer $estado_civil_fk
 * @property string $profissao
 * @property string $cpf
 * @property string $rg
 * @property string $secretaria
 * @property string $dt_nascimento
 * @property string $contador
 * @property integer $cod_cliente_fk
 *
 * @property TabCliente $tabCliente
 */
class TabRepresentanteComercial extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercial.tab_representante_comercial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado_civil_fk', 'cod_cliente_fk'], 'integer'],
            [['dt_nascimento'], 'safe'],
            [['nome'], 'string', 'max' => 100],
            [['nacionalidade'], 'string', 'max' => 50],
            [['profissao'], 'string', 'max' => 120],
            [['cpf'], 'string', 'max' => 12],
            [['rg'], 'string', 'max' => 15],
            [['secretaria'], 'string', 'max' => 2],
            [['contador'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_representante_comercial' => 'Cod Representante Comercial',
            'nome' => 'Nome',
            'nacionalidade' => 'Nacionalidade',
            'estado_civil_fk' => 'Estado Civil',
            'profissao' => 'Profissão',
            'cpf' => 'Cpf',
            'rg' => 'RG',
            'secretaria' => 'SSP',
            'dt_nascimento' => 'Nascimento',
            'contador' => 'Contator',
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
     * @return TabRepresentanteComercialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabRepresentanteComercialQuery(get_called_class());
    }
}
