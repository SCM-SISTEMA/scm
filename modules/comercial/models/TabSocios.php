<?php

namespace app\modules\comercial\models;

use Yii;

/**
 * This is the model class for table "comercial.tab_socios".
 *
 * @property integer $cod_socio
 * @property string $nome
 * @property string $nacionalidade
 * @property integer $estado_civil_fk
 * @property string $profissao
 * @property string $rg
 * @property string $orgao_uf
 * @property string $cpf
 * @property integer $cod_cliente_fk
 * @property string $qual
 * @property string $txt_login_inclusao
 * @property string $txt_login_alteracao
 * @property string $dt_inclusao
 * @property string $dt_alteracao
 *
 * @property TabCliente $tabCliente
 */
class TabSocios extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercial.tab_socios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado_civil_fk', 'cod_cliente_fk'], 'integer'],
            [['dt_inclusao', 'dt_alteracao'], 'safe'],
            [['nome'], 'string', 'max' => 200],
            [['nacionalidade'], 'string', 'max' => 50],
            [['profissao'], 'string', 'max' => 100],
            [['rg'], 'string', 'max' => 30],
            [['orgao_uf'], 'string', 'max' => 10],
            [['cpf'], 'string', 'max' => 14],
            [['qual'], 'string', 'max' => 159],
            [['txt_login_inclusao', 'txt_login_alteracao'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_socio' => 'Cod Socio',
            'nome' => 'Nome',
            'nacionalidade' => 'Nacionalidade',
            'estado_civil_fk' => 'atributo valor - >  estado-civil',
            'profissao' => 'Profissao',
            'rg' => 'Rg',
            'orgao_uf' => 'Orgao Uf',
            'cpf' => 'Cpf',
            'cod_cliente_fk' => 'Cod Cliente Fk',
            'qual' => 'Qual',
            'txt_login_inclusao' => 'Usuário da Inclusão',
            'txt_login_alteracao' => 'Usuário da Alteração',
            'dt_inclusao' => 'Dt Inclusao',
            'dt_alteracao' => 'Dt Alteracao',
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
     * @return \app\modules\posoutorga\models\TabSociosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\posoutorga\models\TabSociosQuery(get_called_class());
    }
}
