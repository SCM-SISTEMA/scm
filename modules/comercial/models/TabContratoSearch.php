<?php

namespace app\modules\comercial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\comercial\models\TabContrato;

/**
 * TabContratoSearch represents the model behind the search form about `app\modules\comercial\models\TabContrato`.
 */
class TabContratoSearch extends TabContrato {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['valor_contrato'], 'number'],
            [['cod_contrato', 'dt_prazo', 'dt_inclusao', 'dt_vencimento', 'tipo_contrato_fk', 'dia_vencimento', 'qnt_parcelas', 'responsavel_fk', 'qnt_clientes', 'cod_cliente_fk'], 'safe'],
            [['operando', 'link', 'zero800', 'parceiria', 'consultoria_scm', 'engenheiro_tecnico'], 'boolean'],
            [['contador'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $labels = parent::attributeLabels();

        $labels['tipo_contrato_fk'] = 'Tipo Contrato';
        $labels['dt_prazo'] = 'Prazo';
        $labels['dt_vencimento'] = 'Vencimento';
        $labels['responsavel_fk'] = 'Usuário Responsável';
        $labels['qnt_parcelas'] = 'Qnt de Parcelas';

        return $labels
        ;
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
        $query = TabContratoSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_contrato' => $this->cod_contrato,
            $this->tableName() . '.tipo_contrato_fk' => $this->tipo_contrato_fk,
            $this->tableName() . '.valor_contrato' => $this->valor_contrato,
            $this->tableName() . '.dia_vencimento' => $this->dia_vencimento,
            $this->tableName() . '.qnt_parcelas' => $this->qnt_parcelas,
            $this->tableName() . '.dt_prazo' => $this->dt_prazo,
            $this->tableName() . '.dt_inclusao' => $this->dt_inclusao,
            $this->tableName() . '.dt_vencimento' => $this->dt_vencimento,
            $this->tableName() . '.responsavel_fk' => $this->responsavel_fk,
            $this->tableName() . '.operando' => $this->operando,
            $this->tableName() . '.qnt_clientes' => $this->qnt_clientes,
            $this->tableName() . '.link' => $this->link,
            $this->tableName() . '.zero800' => $this->zero800,
            $this->tableName() . '.parceiria' => $this->parceiria,
            $this->tableName() . '.consultoria_scm' => $this->consultoria_scm,
            $this->tableName() . '.engenheiro_tecnico' => $this->engenheiro_tecnico,
            $this->tableName() . '.cod_cliente_fk' => $this->cod_cliente_fk,
            $this->tableName() . '.ativo' => $this->ativo,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.contador', $this->contador]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    public static function salvarContratos($contratos, $model) {

        if ($contratos) {
            foreach ($contratos as $key => $cont) {
                $modelCon = new \app\modules\comercial\models\TabContratoSearch();

                if (strpos($cont['attributes']['cod_contrato'], 'N') !== false) {


                    unset($cont['attributes']['cod_contrato']);

                    $modelCon->attributes = $cont['attributes'];
                    $modelCon->cod_cliente_fk = $model->cod_cliente;
                    $modelCon->save();

                    if ($cont['tipo_contratos']) {
                        TabTipoContratoSearch::salvarTipoContratos($cont['tipo_contratos'], $modelCon);
                    }


                    if ($cont['parcelas']) {
                        \app\modules\comercial\models\TabContratoParcelasSearch::salvarContratoParcelas($cont['parcelas'], $modelCon);
                    }

                    $andamento = new \app\models\TabAndamentoSearch();
                    $andamento->cod_usuario_inclusao_fk = \Yii::$app->user->identity->getId();
                    $andamento->cod_assunto_fk = "535";
                    $andamento->cod_contrato_fk = $modelCon->cod_contrato;
                    $andamento->cod_modulo_fk = \app\modules\admin\models\TabModulosSearch::find()->where(['id'=>Yii::$app->controller->module->id])->one()->cod_modulo;
                    $andamento->txt_notificacao = 'Inclusao de Contrato';
                    $andamento->save();
                    
                    
                } else {
                    
                    $modelCon = TabContratoSearch::find()->where(['cod_contrato' => $value['cod_contrato']])->one();
                    $modelCon->attributes = $value;
                    $modelCon->save();
                    
                    $naoExcluir[] = $modelCon->cod_contrato;

                    if ($cont['tipo_contratos']) {
                        TabTipoContratoSearch::salvarTipoContratos($cont['tipo_contratos'], $modelCon);
                    }


                    if ($cont['parcelas']) {
                        \app\modules\comercial\models\TabContratoParcelasSearch::salvarContratoParcelas($cont['parcelas'], $modelCon);
                    }
                    if($modelCon->isNewRecord){
                        $andamento = new \app\models\TabAndamentoSearch();
                        $andamento->cod_usuario_inclusao_fk = $this->user->identity->getId();
                        $andamento->cod_assunto_fk = "535";
                        $andamento->cod_contrato_fk = $modelCon->cod_contrato;
                        $andamento->cod_modulo_fk = 1;
                        $andamento->save();
                    }
                }

                if ($naoExcluir) {

                    TabContratoSearch::updateAll(['ativo' => false], "cod_cliente_fk = {$model->cod_cliente} and cod_contrato not in (" . implode(',', $naoExcluir) . ")");
                }
            }
        }
    }

}
