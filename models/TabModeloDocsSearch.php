<?php

namespace app\models;

use projeto\Util;
use yii\data\ActiveDataProvider;
use \yii\helpers\ArrayHelper;

class TabModeloDocsSearch extends TabModeloDocs {

    public $dsc_cabecalho;
    public $dsc_rodape;
    public $dsc_finalidade;
    public $dsc_tipo_modelo_documento;
    public $camposChaveAttrVlr = [
        'cabecalho_fk',
        'rodape_fk',
        'finalidade_fk',
        'tipo_modelo_documento_fk',
    ];

    public function search($params) {
        $query = TabModeloDocsSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['txt_descricao' => SORT_ASC]]
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_modelo_doc' => $this->cod_modelo_doc,
            $this->tableName() . '.modulo_fk' => $this->modulo_fk,
            $this->tableName() . '.cabecalho_fk' => $this->cabecalho_fk,
            $this->tableName() . '.rodape_fk' => $this->rodape_fk,
            $this->tableName() . '.tipo_modelo_documento_fk' => $this->tipo_modelo_documento_fk,
            $this->tableName() . '.finalidade_fk' => $this->finalidade_fk,
            $this->tableName() . '.dte_inclusao' => $this->dte_inclusao,
            $this->tableName() . '.dte_alteracao' => $this->dte_alteracao,
            $this->tableName() . '.dte_exclusao' => $this->dte_exclusao,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.sgl_id', $this->sgl_id])
                ->andFilterWhere(['ilike', $this->tableName() . '.txt_descricao', $this->txt_descricao])
                ->andFilterWhere(['ilike', $this->tableName() . '.txt_conteudo', $this->txt_conteudo])
                ->andFilterWhere(['ilike', $this->tableName() . '.txt_login_inclusao', $this->txt_login_inclusao]);

        $query->andWhere($this->tableName() . '.dte_exclusao IS NULL');
        $query->orderBy('dte_alteracao desc');
        $dataProvider->sort->defaultOrder = 'dte_alteracao';
        $dataProvider->sort->attributes['dte_alteracao'] = [
            'asc' => ['dte_alteracao' => SORT_ASC],
            'desc' => ['dte_alteracao' => SORT_DESC],
        ];

        return $dataProvider;
    }

    /**
     * @param integer $cod_modulo
     * @param integer $tipo - tipo documento
     * @return ArrayHelper
     */
    public static function getAllDocs($cod_modulo) {
        $dados = TabModeloDocsSearch::find()
                        ->where(['modulo_fk' => $cod_modulo])
                        ->andWhere('dte_exclusao IS NULL')
                        ->orderBy('txt_descricao')->asArray()->all();

        $arr = ArrayHelper::map($dados, 'sgl_id', 'txt_descricao');
        return $arr;
    }

    public function rules() {
        $rules = parent::rules();

        // remove regra de validação do cabeçalho
        $rules[0] = [['finalidade_fk', 'sgl_id', 'tipo_modelo_documento_fk', 'txt_conteudo'], 'required'];

        // tira as regras para 'integer' por conta dos campos self::$camposChaveAttrVlr
        $rules[1] = [['modulo_fk'], 'integer'];

        // ...
        $rules[] = [['finalidade_fk', 'rodape_fk', 'cabecalho_fk', 'tipo_modelo_documento_fk'], 'safe'];

        // altera a regra de validação do cabeçalho
        $rules[] = [['cabecalho_fk'], 'required', 'when' => function ($model) {
                return Util::attrVal($model->tipo_modelo_documento_fk) == 'tipo-modelo-documento-pdf';
            }, 'whenClient' => 'function (attribute, value) {
			return projeto.util.attrVal($("#tabmodelodocs-tipo_modelo_documento_fk").find("option:selected")) == "tipo-modelo-documento-pdf";
		}'];

        // altera a regra de validação do rodapé
        $rules[] = [['rodape_fk'], 'required', 'when' => function ($model) {
                return Util::attrVal($model->tipo_modelo_documento_fk) == 'tipo-modelo-documento-pdf';
            }, 'whenClient' => 'function (attribute, value) {
			return projeto.util.attrVal($("#tabmodelodocs-tipo_modelo_documento_fk").find("option:selected")) == "tipo-modelo-documento-pdf";
		}'];

        return $rules;
    }

    public function attributeLabels() {
        return [
            'cod_modelo_doc' => 'Código',
            'modulo_fk' => 'Cód. Módulo',
            'cabecalho_fk' => 'Cabeçalho',
            'dsc_cabecalho' => 'Cabeçalho',
            'rodape_fk' => 'Rodapé',
            'dsc_rodape' => 'Rodapé',
            'finalidade_fk' => 'Finalidade',
            'dsc_finalidade' => 'Finalidade',
            'tipo_modelo_documento_fk' => 'Tipo do documento',
            'dsc_tipo_modelo_documento' => 'Tipo do documento',
            'sgl_id' => 'Identificador',
            'txt_descricao' => 'Descrição',
            'txt_conteudo' => 'Conteúdo',
            'dte_inclusao' => 'Dte Inclusao',
            'dte_alteracao' => 'Data',
            'dte_exclusao' => 'Dte Exclusao',
            'txt_login_inclusao' => 'Login Inclusao',
        ];
    }

    public function beforeSave($insert) {
        $tipoModeloDoc = Util::attrVal($this->tipo_modelo_documento_fk);

        if (parent::beforeSave($insert)) {
            if ($tipoModeloDoc == 'tipo-modelo-documento-email') {
                $this->cabecalho_fk = VisAtributosValores::getTupla('cabecalho-modelo-documento', 'cabecalho-sem');
                $this->rodape_fk = VisAtributosValores::getTupla('rodape-modelo-documento', 'rodape-sem');
            }
            return true;
        }

        return false;
    }

    public function afterFind() {
        parent::afterFind();
        static::carregarDescricaoAtributoValor([
            'cabecalho_fk' => 'dsc_cabecalho',
            'rodape_fk' => 'dsc_rodape',
            'finalidade_fk' => 'dsc_finalidade',
            'tipo_modelo_documento_fk' => 'dsc_tipo_modelo_documento',
        ]);
    }

}
