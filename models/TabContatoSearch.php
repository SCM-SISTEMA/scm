<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TabContato;

/**
 * @property TabCliente $tabCliente
 * TabContatoSearch represents the model behind the search form about `app\models\TabContato`.
 */
class TabContatoSearch extends TabContato {

    /**
     * @inheritdoc
     */
    public $contato_email;
    public $contato_desc;
    public $tipo_desc;

    public function rules() {

        $rules = [
            [['contato'], 'string', 'max' => 200],
            [['ramal'], 'string', 'max' => 5],
            [['contato_email', 'tipo'], 'required', 'on' => 'email'],
            [['contato', 'tipo'], 'required', 'on' => 'telefone'],
            [['contato_email', 'contato', 'cod_contato', 'ativo', 'tipo'], 'safe'],
            [['contato_email'], 'email'],
        ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        $labels = parent::attributeLabels();
        $labels['contato'] = 'Número';
        $labels['contato_email'] = 'Email';
        $labels['ramal'] = 'Ramal';
        $labels['ativo'] = 'Ativo';
        $labels['tipo'] = 'Tipo de contato';

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
        $query = TabContatoSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_contato' => $this->cod_contato,
            $this->tableName() . '.ativo' => $this->ativo,
            $this->tableName() . '.dt_inclusao' => $this->dt_inclusao,
            $this->tableName() . '.tipo' => $this->tipo,
            $this->tableName() . '.chave_fk' => $this->chave_fk,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.contato', $this->contato])
                ->andFilterWhere(['ilike', $this->tableName() . '.ramal', $this->ramal]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    public static function buscaCampos($itens = []) {

        $itens = (\Yii::$app->session->get('contato')) ? \Yii::$app->session->get('contato') : ( ($itens) ? $itens : []);

        if ($itens) {
            foreach ($itens as $key => $value) {
                $itens[$key]['contato_desc'] = ($value['contato']) ? $value['contato'] : $value['contato_email'];
                $itens[$key]['tipo_desc'] = TabAtributosValoresSearch::findOneAsArray(['cod_atributos_valores' => $value['tipo']])['dsc_descricao'];
            }
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'id' => 'grid_lista_contato',
            'allModels' => $itens,
            'sort' => false,
            'pagination' => ['pageSize' => 10],
        ]);


        return $dataProvider;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabCliente() {
        return $this->hasOne(TabClienteSearch::className(), ['cod_cliente' => 'cod_cliente_fk']);
    }

    public static function salvarContatos($contato, $model) {


        foreach ($contato as $key => $value) {

            if (strpos($value['cod_contato'], 'novo') !== false) {

                unset($value['cod_contato']);
                $modelCon = new \app\models\TabContatoSearch();
                $modelCon->attributes = $value;
                $modelCon->chave_fk = $model->cod_cliente;
                $modelCon->tipo_tabela_fk = $model->tableName();
                $modelCon->save();
                $naoExcluir[] = $modelCon->cod_contato;
            } else {
                $modelCon = \app\models\TabContatoSearch::find()->where(['cod_contato' => $value['cod_contato']])->one();
                $modelCon->attributes = $value;
                $modelCon->save();
                $naoExcluir[] = $modelCon->cod_contato;
            }

            if ($naoExcluir[0]) {

                TabContatoSearch::deleteAll("chave_fk = {$model->cod_cliente} and tipo_tabela_fk = '{$model->tableName()}' and cod_contato not in (" . implode(',', $naoExcluir) . ")");
            }
        }
    }

}
