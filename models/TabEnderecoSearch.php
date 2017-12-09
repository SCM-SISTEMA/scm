<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TabEndereco;

/**
 * TabEnderecoSearch represents the model behind the search form about `app\models\TabEndereco`.
 */
class TabEnderecoSearch extends TabEndereco {

    /**
     * @inheritdoc
     */
    public $uf;
    public $municipio;
    public $dadosCep;

    public function rules() {

        return [
            [['correspondencia', 'ativo'], 'boolean'],
            [['cod_municipio_fk', 'cep', 'logradouro', 'numero'], 'required', 'on' => 'criar'],
            //[['cod_municipio_fk', 'cep', 'logradouro'], 'required'],
            [['chave_fk', 'tipo_usuario'], 'integer'],
            [['dt_inclusao', 'cod_endereco', 'bairro','tipo_tabela_fk', 'cod_municipio_fk'], 'safe'],
            [['logradouro'], 'string', 'max' => 200],
            [['numero'], 'string', 'max' => 20],
            [['complemento'], 'string', 'max' => 100],
            [['cep'], 'string', 'max' => 10],
            [['cod_municipio_fk'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {


        $labels = parent::attributeLabels();

        $labels['numero'] = 'Número';
        $labels['cep'] = 'CEP';
        $labels['correspondencia'] = 'Endereco para correspondência?';
        $labels['cod_municipio_fk'] = 'Município';
        $labels['cod_municipio'] = 'Município';
        $labels['uf'] = 'UF';
        $labels['ativo'] = 'Ativo?';

        return $labels;
    }

    public function afterFind() {
        parent::afterFind();
        $end = \app\models\TabMunicipiosSearch::findOneAsArray(['cod_municipio' => $this->cod_municipio_fk]);

        $this->uf = $end['sgl_estado_fk'];
        $this->municipio = $end['txt_nome'];
        return true;
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
        $query = TabEnderecoSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_endereco' => $this->cod_endereco,
            $this->tableName() . '.correspondencia' => $this->correspondencia,
            $this->tableName() . '.chave_fk' => $this->chave_fk,
            $this->tableName() . '.tipo_usuario' => $this->tipo_usuario,
            $this->tableName() . '.dt_inclusao' => $this->dt_inclusao,
            $this->tableName() . '.ativo' => $this->ativo,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.logradouro', $this->logradouro])
                ->andFilterWhere(['ilike', $this->tableName() . '.numero', $this->numero])
                ->andFilterWhere(['ilike', $this->tableName() . '.complemento', $this->complemento])
                ->andFilterWhere(['ilike', $this->tableName() . '.cep', $this->cep])
                ->andFilterWhere(['ilike', $this->tableName() . '.cod_municipio_fk', $this->cod_municipio_fk]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    public static function buscaCampos($itens = []) {

        $itens = (\Yii::$app->session->get('endereco')) ? \Yii::$app->session->get('endereco') : ( ($itens) ? $itens : []);

        $dataProvider = new \yii\data\ArrayDataProvider([
            'id' => 'grid_lista_endereco',
            'allModels' => $itens,
            'sort' => false,
            'pagination' => ['pageSize' => 10],
        ]);


        return $dataProvider;
    }

    public function buscaCep($cep = null) {

        $cep = (!$cep) ? $this->cep : $cep;


        $cep = \projeto\Util::retiraCaracter($cep);
        $url = 'viacep.com.br/ws/' . $cep . '/json/';

        $ch = curl_init();
        curl_setopt_array($ch, array
            (
            CURLOPT_TIMEOUT => 250,
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => TRUE
        ));

        $response = curl_exec($ch);
        if ($this->cep) {
            $this->dadosCep = json_decode($response);
        } else {
            return json_decode($response);
        }
    }

    public static function salvarEnderecos($endereco, $model, $save = true) {


        foreach ($endereco as $key => $value) {

            if (strpos($value['cod_endereco'], 'novo') !== false) {
                unset($value['cod_endereco']);

                $modelEnd = new \app\models\TabEnderecoSearch();

                $modelEnd->attributes = $value;
                $modelEnd->tipo_tabela_fk = $model->tableName();
                if (!$save) {
                    $modelEnd->cod_endereco = 'novo-' . rand('100000000', '999999999');
                    return $modelEnd->attributes;
                }
                $modelEnd->chave_fk = $model->getPrimaryKey();
                $modelEnd->save();

                $naoExcluir[] = $modelEnd->cod_endereco;
            } else {

                $modelEnd = \app\models\TabEnderecoSearch::find()->where(['cod_endereco' => $value['cod_endereco']])->one();

                unset($value['dt_inclusao']);
                $modelEnd->attributes = $value;
                if (!$save) {
                    return $modelEnd->attributes;
                }
                $modelEnd->save();

                $naoExcluir[] = $modelEnd->cod_endereco;
            }
        }
        if ($naoExcluir) {

            TabEnderecoSearch::deleteAll("chave_fk = {$model->getPrimaryKey()} and tipo_tabela_fk = '{$model->tableName()}' and cod_endereco not in (" . implode(',', $naoExcluir) . ")");
        }
    }

}
