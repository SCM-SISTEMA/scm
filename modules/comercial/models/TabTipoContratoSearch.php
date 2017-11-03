<?php

namespace app\modules\comercial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\comercial\models\TabTipoContrato;

/**
 * TabTipoContratoSearch represents the model behind the search form about `app\modules\comercial\models\TabTipoContrato`.
 */
class TabTipoContratoSearch extends TabTipoContrato {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cod_usuario_fk', 'tipo_produto_fk'], 'integer'],
            [['cod_contrato_fk'], 'safe']
        ];
    }

    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['cod_usuario_fk'] = 'Usuário Responsável';


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
        $query = TabTipoContratoSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_tipo_contrato' => $this->cod_tipo_contrato,
            $this->tableName() . '.cod_usuario_fk' => $this->cod_usuario_fk,
            $this->tableName() . '.cod_contrato_fk' => $this->cod_contrato_fk,
            $this->tableName() . '.tipo_produto_fk' => $this->tipo_produto_fk,
            $this->tableName() . '.ativo' => $this->ativo,
        ]);

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    public static function salvarTipoContratos($tipo, $model) {

        foreach ($tipo as $skey => $ser) {

            if (strpos($ser['cod_tipo_contrato'], 'N') !== false) {

                unset($ser['cod_tipo_contrato']);
                $servico = new \app\modules\comercial\models\TabTipoContratoSearch();
                $servico->attributes = $ser;
                $servico->cod_contrato_fk = (int) $model->cod_contrato;
                $servico->save();

                $modulo = \app\modules\admin\models\TabModulosSearch::find()->where(['id' => 'comercial'])->one();
                $responsavel = new \app\modules\comercial\models\TabTipoContratoResponsavelSearch();

                $responsavel->cod_tipo_contrato_fk = $servico->cod_tipo_contrato;
                $responsavel->cod_modulo_fk = $modulo->cod_modulo;
                $responsavel->cod_usuario_fk = $ser['cod_usuario_fk'];
                $responsavel->save();

                $naoExcluir[] = $servico->cod_tipo_contrato;
            } else {

                $servico = TabTipoContratoSearch::find()->where(['cod_tipo_contrato' => $ser['cod_tipo_contrato']])->one();
                $servico->attributes = $ser;
                $servico->save();
                $naoExcluir[] = $servico->cod_tipo_contrato;

                $modulo = \app\modules\admin\models\TabModulosSearch::find()->where(['id' => 'comercial'])->one();

                $responsavel = \app\modules\comercial\models\TabTipoContratoResponsavelSearch()->find()->where(['cod_modulo_fk' => $modulo->cod_modulo, 'cod_tipo_contrato_fk' => $servico->cod_tipo_contrato])->one();
                if (!$responsavel) {
                    $responsavel = new \app\modules\comercial\models\TabTipoContratoResponsavelSearch();
                    $responsavel->cod_tipo_contrato_fk = $servico->cod_tipo_contrato;
                    $responsavel->cod_modulo_fk = $modulo->cod_modulo;
                }

                $responsavel->cod_usuario_fk = $ser['cod_usuario_fk'];
                $responsavel->save();
            }

            if ($naoExcluir) {
                TabTipoContratoSearch::updateAll(['ativo' => false], "cod_contrato_fk = {$servico->cod_contrato_fk} and cod_tipo_contrato not in (" . implode(',', $naoExcluir) . ")");
            }
        }
    }

}
