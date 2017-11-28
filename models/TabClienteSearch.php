<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TabCliente;

/**
 * TabClienteSearch represents the model behind the search form about `app\models\TabCliente`.
 */
class TabClienteSearch extends TabCliente {

    public $file;

    /**
     * @inheritdoc
     */
    public $dadosReceita;

    public function rules() {
        return [
            [['dt_inclusao', 'qnt_clientes', 'responsavel', 'ie', 'fistel', 'dt_exclusao', 'situacao', 'operando', 'parceria', 'link_dedicado', 'zero800', 'consultoria_mensal', 'engenheiro_tecnico'], 'safe'],
            [['cnpj'], 'string', 'max' => 18],
            [['cnpj'], 'unique'],
            // [['responsavel'], 'required'],
            [['cnpj'], '\projeto\validators\CnpjValidator'],
            [['fantasia', 'razao_social'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        $labels = parent::attributeLabels();
        $labels['cnpj'] = 'CNPJ';
        $labels['ie'] = 'Inscrição Estadual';
        $labels['fantasia'] = 'Fantasia';
        $labels['razao_social'] = 'Razão Social';
        $labels['responsavel'] = 'Nome do cliente';
        $labels['situacao'] = 'Ativo?';

        return $labels;
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = TabClienteSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.ie' => $this->ie,
            $this->tableName() . '.dt_inclusao' => $this->dt_inclusao,
            $this->tableName() . '.dt_exclusao' => $this->dt_exclusao,
            $this->tableName() . '.cod_cliente' => $this->cod_cliente,
            $this->tableName() . '.situacao' => $this->situacao,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.cnpj', $this->cnpj])
                ->andFilterWhere(['ilike', $this->tableName() . '.fantasia', $this->fantasia])
                ->andFilterWhere(['ilike', $this->tableName() . '.responsavel', $this->responsavel])
                ->andFilterWhere(['ilike', $this->tableName() . '.razao_social', $this->razao_social]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    public function beforeSave($insert) {

        
        $sim = TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                    TabAtributosSearch::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos
                        , 'sgl_valor'=>'S'])->one()->cod_atributos_valores;
        
        $this->situacao = ($this->situacao == $sim) ? true : false;
        $this->link_dedicado = ($this->link_dedicado == $sim) ? true : false;
        $this->zero800 = ($this->zero800 == $sim) ? true : false;
        $this->consultoria_mensal = ($this->consultoria_mensal == $sim) ? true : false;
        $this->engenheiro_tecnico = ($this->engenheiro_tecnico == $sim) ? true : false;
        $this->parceria = ($this->parceria == $sim) ? true : false;
        $this->operando = ($this->operando == $sim) ? true : false;

        return parent::beforeSave($insert);
    }
    
    public function afterFind() {
        
        parent::afterFind();
        
        $sim = TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                    TabAtributosSearch::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos
                        , 'sgl_valor'=>'S'])->one()->cod_atributos_valores;
        $nao = TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                  TabAtributosSearch::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos
                        , 'sgl_valor'=>'N'])->one()->cod_atributos_valores;
        
        $this->situacao = ($this->situacao == true) ? $sim : $nao;
        $this->link_dedicado = ($this->link_dedicado == true) ? $sim : $nao;
        $this->zero800 = ($this->zero800 == true) ? $sim : $nao;
        $this->consultoria_mensal = ($this->consultoria_mensal == true) ? $sim : $nao;
        $this->engenheiro_tecnico = ($this->engenheiro_tecnico == true) ? $sim : $nao;
        $this->parceria = ($this->parceria == true) ? $sim : $nao;
        $this->operando = ($this->operando == true) ? $sim : $nao;
        
        return true;

    }

    public function buscaCliente() {
        $ch = curl_init();

        $nu_cnpj = \projeto\Util::retiraCaracter($this->cnpj);

        $url = "http://receitaws.com.br/v1/cnpj/" . $nu_cnpj;
        curl_setopt_array($ch, array
            (
            CURLOPT_TIMEOUT => 7,
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => TRUE
        ));


        if ($response = curl_exec($ch)) {
;
            curl_close($ch);
        }

        $dados = json_decode($response);

        if ($dados->nome) {
            $this->razao_social = $dados->nome;
            $this->fantasia = $dados->fantasia;
            $this->dadosReceita = $dados;
        }
    }

}
