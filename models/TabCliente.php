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
 * @property string $natureza_juridica
 * @property boolean $operando
 * @property boolean $parceria
 * @property integer $qnt_clientes
 * @property boolean $link_dedicado
 * @property boolean $zero800
 * @property boolean $consultoria_mensal
 * @property boolean $engenheiro_tecnico
 *
 * @property TabContrato[] $tabContrato
 * @property TabRepresentanteComercial[] $tabRepresentanteComercial
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
            [['ie', 'qnt_clientes'], 'integer'],
            [['dt_inclusao', 'dt_exclusao'], 'safe'],
            [['situacao', 'operando', 'parceria', 'link_dedicado', 'zero800', 'consultoria_mensal', 'engenheiro_tecnico'], 'boolean'],
            [['obs'], 'string'],
            [['cnpj'], 'string', 'max' => 18],
            [['fantasia', 'razao_social'], 'string', 'max' => 200],
            [['fistel'], 'string', 'max' => 15],
            [['responsavel', 'natureza_juridica'], 'string', 'max' => 300]
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
            'natureza_juridica' => 'Natureza jurídica',
            'operando' => 'Já está operando?',
            'parceria' => 'Tem parceria?',
            'qnt_clientes' => 'Quantidade de clientes',
            'link_dedicado' => 'Possui link dedicado?',
            'zero800' => 'Possui 0800?',
            'consultoria_mensal' => 'Paga consultoria SCM mensal?',
            'engenheiro_tecnico' => 'Possui engenheiro ou técnico responsável?',
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
    public function getTabRepresentanteComercial()
    {
        return $this->hasMany(TabRepresentanteComercial::className(), ['cod_cliente_fk' => 'cod_cliente']);
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
