<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TabAtributosValores;
use yii\helpers\ArrayHelper;

/**
 * TabAtributosValoresSearch represents the model behind the search form about `app\models\TabAtributosValores`.
 */
class TabAtributosValoresSearch extends TabAtributosValores {

    // Scenarios
    const SCENARIO_ALTERAR_SITUACAO_PREENCHIMENTO = 'alterar_situacao_preenchimento';

    /**
     * @inheritdoc
     */
    public function rules() {

        $rules = [
            [['fk_atributos_valores_atributos_id'], 'required', 'on' => self::SCENARIO_ALTERAR_SITUACAO_PREENCHIMENTO, 'message' => '"Situação de preenchimento" não pode ficar em branco.'],
            [['fk_atributos_valores_atributos_id', 'sgl_valor', 'dsc_descricao'], 'safe'],
        ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        $labels = [
            'cod_atributos_valores' => 'Código da tabela',
            'fk_atributos_valores_atributos_id' => 'Atributo pai',
            'sgl_valor' => 'Identificador único',
            'dsc_descricao' => 'Descrição',
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = TabAtributosValoresSearch::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_atributos_valores' => $this->cod_atributos_valores,
            $this->tableName() . '.fk_atributos_valores_atributos_id' => $this->fk_atributos_valores_atributos_id,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.sgl_valor', $this->sgl_valor])
                ->andFilterWhere(['ilike', $this->tableName() . '.dsc_descricao', $this->dsc_descricao]);

        $query->orderBy('sgl_valor, dsc_descricao');

        return $dataProvider;
    }

    /**
     * Metodo que busca os atributos valores de acordo com a fk passada por parâmetro
     * @param int $fk_atributos_valores_atributos_id id do atributo conforme constante em TabAtributosSearch
     * @param boolean $is_array
     * @return Array
     */
    public static function getAtributoValor($fk_atributos_valores_atributos_id, $is_array = true, $is_cod = false, $order = 'dsc_descricao') {
        if ($is_array) {
            $dados = self::find()
                    ->where('fk_atributos_valores_atributos_id=:fk_atributos_valores_atributos_id', [':fk_atributos_valores_atributos_id' => $fk_atributos_valores_atributos_id])
                    ->orderBy($order)
                    ->asArray()
                    ->all();
            foreach ($dados as $key => $atributo_valor) {
                if ($is_cod) {
                    $arr[] = ['value' => $atributo_valor['cod_atributos_valores'], 'text' => $atributo_valor['dsc_descricao']];
                } else {
                    $arr[] = ['value' => $atributo_valor['sgl_valor'], 'text' => $atributo_valor['dsc_descricao']];
                }
            }
            $arr = ArrayHelper::map($arr, 'value', 'text');
        } else {
            /**
             * @todo Ver a necessidade desta opção
             */
            $arr = self::find()
                    ->where('fk_atributos_valores_atributos_id=:fk_atributos_valores_atributos_id', [':fk_atributos_valores_atributos_id' => $fk_atributos_valores_atributos_id])
                    ->asArray()
                    ->one();
        }

        return $arr;
    }

    /**
     * Metodo que retorna a descrição de um atributo valor de acordo com a chave e valor
     * @param int $fk_atributos_valores_atributos_id id do atributo conforme constante em TabAtributosSearch
     * @param String $valor do índice do array do atributo valor
     * @return String
     */
    public static function getDescricaoAtributoValor($fk_atributos_valores_atributos_id, $valor) {
        $dados = self::find()
                ->where('fk_atributos_valores_atributos_id=:fk_atributos_valores_atributos_id', [':fk_atributos_valores_atributos_id' => $fk_atributos_valores_atributos_id])
                ->asArray()
                ->all();
        $descricao = 'Não localizada';
        foreach ($dados as $key => $atributo_valor) {
            if ($atributo_valor['sgl_valor'] == $valor) {
                $descricao = $atributo_valor['dsc_descricao'];
                break;
            }
        }

        return $descricao;
    }

    /** Metodo que retorna a descrição de um atributo valor de acordo com a chave e valor
     * @param int $fk_atributos_valores_atributos_id id do atributo conforme constante em TabAtributosSearch
     * @param String $valor do índice do array do atributo valor
     * @return String
     */
    public static function getAtributoValorAtributo($sgl_chave, $valor = null, $chave = false) {
        $atributo = TabAtributosSearch::find()->where(['sgl_chave' => $sgl_chave])->asArray()->one();
        
        $dados = self::find()
                ->where(['fk_atributos_valores_atributos_id' => $atributo['cod_atributos']])
                ->asArray()
                ->all();

        if (!$valor) {
            return $dados;
        } elseif ($dados) {
            foreach ($dados as $key => $value) {
                if ($chave) {
                    if (\projeto\Util::tirarAcentos(strtoupper($valor)) == str_replace(' ', '',  strtoupper(\projeto\Util::tirarAcentos($value['dsc_descricao'])))) {
                        return $value['cod_atributos_valores'];
                    }
                } else {
       
                    if ($valor == $value['sgl_valor']) {
                        return $value['cod_atributos_valores'];
                    }
                }
            }
        } else {
            return $dados;
        }
    }

    public function afterSave($insert, $changedAttributes) {
        VisAtributosValores::atualizar();
    }

    public function afterDelete() {
        VisAtributosValores::atualizar();
    }

}
