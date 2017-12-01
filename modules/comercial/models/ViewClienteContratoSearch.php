<?php

namespace app\modules\comercial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\comercial\models\ViewClienteContrato;

/**
 * TabContratoSearch represents the model behind the search form about `app\modules\comercial\models\TabContrato`.
 */
class ViewClienteContratoSearch extends ViewClienteContrato {

    
    public $tipo_contato;

    
    /**
     * @inheritdoc
     */
    public function rules() {
        $rules = parent::rules();
        
        //$rules[] =  [['contato'], 'safe'];
        return $rules;
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['cod_contrato'] = 'Número';
        $labels['dsc_tipo_contrato'] = 'Contrato';
        $labels['cod_tipo_contrato'] = 'Contrato';
        $labels['valor_contrato'] = 'Valor';                
        $labels['qnt parcelas'] = 'Nº de Parcelas';                
        $labels['txt_login'] = 'Responsável';    
        $labels['responsavel'] = 'Cliente'; 
        $labels['dsc_status'] = 'Status';
        $labels['dsc_tipo_produto'] = 'Serviço';
        $labels['txt_notificacao_res'] = 'Ult. Andamento';                
        $labels['dt_inclusao_contrato'] = 'Inclusão';                
        $labels['txt_login_andamento'] = 'Usuário And.'; 
        $labels['dt_inclusao_andamento'] = 'Data And.';
        $labels['dt_retorno'] = 'Retorno';
        return $labels
        ;
    }

//    public function afterFind() {
//        parent::afterFind();
//
//        $this->contato = \app\models\TabContatoSearch::find()->where(['chave_fk' => $this->cod_cliente, 'tipo_tabela_fk' => \app\models\TabCliente::tableName()])->asArray()->one();
//                
//        $tp = \app\models\TabAtributosValoresSearch::find()->where(['cod_atributos_valores' => $this->contato['tipo']])->asArray()->one();
//        
//        $this->contato = $this->contato['contato'];
//        $this->tipo_contato = $tp['dsc_descricao'];
//
//        return true;
//    }
    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
  public function search($params) {
      
        $query = ViewClienteContratoSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_contrato' => $this->cod_contrato,
            $this->tableName() . '.atributos_status' => $this->dsc_status,
            $this->tableName() . '.atributos_tipo_produto' => $this->dsc_tipo_produto,
            
            
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.razao_social', $this->razao_social]);
        $query->andFilterWhere(['ilike', $this->tableName() . '.responsavel', $this->responsavel]);
        $query->andFilterWhere(['ilike', $this->tableName() . '.dsc_tipo_contrato', $this->dsc_tipo_contrato]);
        $query->andFilterWhere(['ilike', $this->tableName() . '.txt_login', $this->txt_login]);
        $query->andFilterWhere(['ilike', $this->tableName() . '.dt_retorno', $this->dt_retorno]);
        $query->andFilterWhere(['ilike', $this->tableName() . '.cnpj', $this->cnpj]);
        $query->andFilterWhere(['ilike', $this->tableName() . '.contato', $this->contato]);
        
//        echo '<pre>';
//        print_r(['LEFT OUTER JOIN', \app\models\TabContatoSearch::tableName() ,
//                
//                "chave_fk = ". $this->tableName().".cod_cliente AND tipo_tabela_fk = '".\app\models\TabClienteSearch::tableName()."'"
//                ]); 
//         echo '</pre>';       exit;
//        if($this->contato){
//        $query->join('LEFT OUTER JOIN', \app\models\TabContatoSearch::tableName() ,
//                "chave_fk = ". $this->tableName().".cod_cliente AND tipo_tabela_fk = '".\app\models\TabClienteSearch::tableName()."'"
//              );
//       //$query->andFilterWhere(['ilike', \app\models\TabContatoSearch::tableName() . '.contato', $this->contato]);
//        }
  
        //$query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }
}
