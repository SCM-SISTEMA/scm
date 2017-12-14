<?php

namespace app\modules\comercial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\comercial\models\TabSocios;
use app\models\TabAtributosValoresSearch;
use app\models\TabAtributosSearch;

/**
 * TabSociosSearch represents the model behind the search form about `app\modules\comercial\models\TabSocios`.
 */
class TabSociosSearch extends TabSocios {

    public $telefone;
    public $skype;
    public $email;

    /**
     * @inheritdoc
     */
    public function rules() {


        return [
            [['estado_civil_fk', 'cod_cliente_fk'], 'integer'],
            [['dt_inclusao', 'dt_alteracao', 'nacimento', 'representante_comercial', 'telefone', 'skype', 'email', 'cod_socio'], 'safe'],
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
    public function attributeLabels() {

        $labels = [
                //exemplo 'campo' => 'label',         
        ];

        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function beforeSave($insert) {

        $sim = TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                    TabAtributosSearch::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos
                    , 'sgl_valor' => 'S'])->one()->cod_atributos_valores;

        $this->representante_comercial = ($this->representante_comercial == $sim) ? true : false;

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {

        parent::afterSave($insert, $changedAttributes);


        $tel = TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                    TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-contato'])->one()->cod_atributos
                    , 'sgl_valor' => 'T'])->one()->cod_atributos_valores;

        $sky = TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                    TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-contato'])->one()->cod_atributos
                    , 'sgl_valor' => 'S'])->one()->cod_atributos_valores;

        $email = TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                    TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-contato'])->one()->cod_atributos
                    , 'sgl_valor' => 'E'])->one()->cod_atributos_valores;

        if ($this->telefone)
            $telefone = \app\models\TabContatoSearch::salvarContatoSocios($this->telefone, $this->cod_socio, $tel, $this->tableName());

        if ($this->skype)
            $skype = \app\models\TabContatoSearch::salvarContatoSocios($this->skype, $this->cod_socio, $sky, $this->tableName());

        if ($this->email)
            $email = \app\models\TabContatoSearch::salvarContatoSocios($this->email, $this->cod_socio, $email, $this->tableName());


        return true;
    }

    public function afterFind() {

        parent::afterFind();

        $tel = TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                    TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-contato'])->one()->cod_atributos
                    , 'sgl_valor' => 'T'])->one()->cod_atributos_valores;

        $sky = TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                    TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-contato'])->one()->cod_atributos
                    , 'sgl_valor' => 'S'])->one()->cod_atributos_valores;

        $email = TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                    TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-contato'])->one()->cod_atributos
                    , 'sgl_valor' => 'E'])->one()->cod_atributos_valores;

        $this->telefone = \projeto\Util::formataDataParaBanco($this->telefone);

        $this->telefone = \app\models\TabContatoSearch::find()->where(['chave_fk' => $this->cod_socio, 'tipo_tabela_fk' => $this->tableName(), 'tipo' => $tel])->one()->contato;
        $this->email = \app\models\TabContatoSearch::find()->where(['chave_fk' => $this->cod_socio, 'tipo_tabela_fk' => $this->tableName(), 'tipo' => $email])->one()->contato;
        $this->skype = \app\models\TabContatoSearch::find()->where(['chave_fk' => $this->cod_socio, 'tipo_tabela_fk' => $this->tableName(), 'tipo' => $sky])->one()->contato;

        $sim = TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                    TabAtributosSearch::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos
                    , 'sgl_valor' => 'S'])->one()->cod_atributos_valores;
        $nao = TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                    TabAtributosSearch::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos
                    , 'sgl_valor' => 'N'])->one()->cod_atributos_valores;

        $this->representante_comercial = ($this->representante_comercial == true) ? $sim : $nao;
        return true;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = TabSociosSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_socio' => $this->cod_socio,
            $this->tableName() . '.estado_civil_fk' => $this->estado_civil_fk,
            $this->tableName() . '.cod_cliente_fk' => $this->cod_cliente_fk,
            $this->tableName() . '.dt_inclusao' => $this->dt_inclusao,
            $this->tableName() . '.dt_alteracao' => $this->dt_alteracao,
            $this->tableName() . '.representante_comercial' => $this->representante_comercial,
            $this->tableName() . '.nacimento' => $this->nacimento,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.nome', $this->nome])
                ->andFilterWhere(['ilike', $this->tableName() . '.nacionalidade', $this->nacionalidade])
                ->andFilterWhere(['ilike', $this->tableName() . '.profissao', $this->profissao])
                ->andFilterWhere(['ilike', $this->tableName() . '.rg', $this->rg])
                ->andFilterWhere(['ilike', $this->tableName() . '.orgao_uf', $this->orgao_uf])
                ->andFilterWhere(['ilike', $this->tableName() . '.cpf', $this->cpf])
                ->andFilterWhere(['ilike', $this->tableName() . '.qual', $this->qual])
                ->andFilterWhere(['ilike', $this->tableName() . '.txt_login_inclusao', $this->txt_login_inclusao])
                ->andFilterWhere(['ilike', $this->tableName() . '.txt_login_alteracao', $this->txt_login_alteracao]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    public static function buscaCampos($itens = []) {

        $itens = (\Yii::$app->session->get('socios')) ? \Yii::$app->session->get('socios') : ( ($itens) ? $itens : []);

        $dataProvider = new \yii\data\ArrayDataProvider([
            'id' => 'grid_lista_socios',
            'allModels' => $itens,
            'sort' => false,
            'pagination' => ['pageSize' => 10],
        ]);


        return $dataProvider;
    }

    public static function salvarSocios($socios, $cod_cliente) {

        foreach ($socios as $key => $value) {
            if (strpos($value['cod_socio'], 'novo') !== false) {

                unset($value['cod_socio']);
                $modelSoc = new TabSociosSearch();
                $modelSoc->attributes = $value;
                $modelSoc->telefone = $value['telefone'];
                $modelSoc->skype = $value['skype'];
                $modelSoc->email = $value['email'];
                $modelSoc->cod_cliente_fk = $cod_cliente;
                $modelSoc->save();


                if ($value['endereco']['cod_endereco']) {
                    \app\models\TabEnderecoSearch::salvarEnderecos([$value['endereco']], $modelSoc);
                }

                $naoExcluir[] = $modelSoc->cod_socio;
            } else {

                $modelSoc = TabSociosSearch::find()->where(['cod_socio' => $value['cod_socio']])->one();
                unset($value['cod_socio']);
                unset($value['dt_inclusao']);

                if ($modelSoc) {
                    $modelSoc->attributes = $value;
                    $modelSoc->telefone = $value['telefone'];
                    $modelSoc->skype = $value['skype'];
                    $modelSoc->email = $value['email'];
                    $modelSoc->save();

                   if ($value['endereco']['cod_endereco']) {
                        \app\models\TabEnderecoSearch::salvarEnderecos([$value['endereco']], $modelSoc);
                    }

                    $naoExcluir[] = $modelSoc->cod_socio;
                }
            }
        }
       
        if ($naoExcluir) {

            TabSociosSearch::deleteAll("cod_cliente_fk={$cod_cliente} and cod_socio not in (" . implode(',', $naoExcluir) . ")");
        }
    }

    
    
    public function formataCpf() {
        $cliente = trim(\projeto\Util::retiraCaracter($this->cpf));
        
         $this->cpf = $cliente[0] . $cliente[1] . $cliente[2] . '.' .
                $cliente[3] . $cliente[4] . $cliente[5] . '.' .
                $cliente[6] . $cliente[7] . $cliente[8] . '-' .
                $cliente[9] . $cliente[10];
        
    }
}
