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
 * @property string $nome_contador
 * @property string $telefone_contador
 * @property string $num0800
 * @property string $velocidade
 * @property string $nome_engenheiro_tecnico
 * @property string $telefone_engenheiro_tecnico
 * @property string $qnt_torres
 * @property string $qnt_repetidora
 * @property boolean $notificacao_anatel
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
            [['situacao', 'operando', 'parceria', 'link_dedicado', 'zero800', 'consultoria_mensal', 'engenheiro_tecnico', 'notificacao_anatel'], 'boolean'],
            [['obs'], 'string'],
            [['cnpj'], 'string', 'max' => 18],
            [['fantasia', 'razao_social'], 'string', 'max' => 200],
            [['fistel', 'num0800'], 'string', 'max' => 15],
            [['responsavel', 'natureza_juridica'], 'string', 'max' => 300],
            [['nome_contador', 'nome_engenheiro_tecnico'], 'string', 'max' => 100],
            [['telefone_contador', 'telefone_engenheiro_tecnico'], 'string', 'max' => 30],
            [['velocidade'], 'string', 'max' => 10],
            [['qnt_torres', 'qnt_repetidora'], 'string', 'max' => 3]
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
            'nome_contador' => 'Nome Contador',
            'telefone_contador' => 'Telefone Contador',
            'num0800' => '0800',
            'velocidade' => 'Caso sim, qual a 
Velocidade?',
            'nome_engenheiro_tecnico' => 'Nome Engenheiro Tecnico',
            'telefone_engenheiro_tecnico' => 'Telefone Engenheiro Tecnico',
            'qnt_torres' => 'Possui quantas torres cadastradas?',
            'qnt_repetidora' => 'Possui Repetidoras? Quantas?',
            'notificacao_anatel' => 'Já recebeu notificação da ANATEL?',
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
