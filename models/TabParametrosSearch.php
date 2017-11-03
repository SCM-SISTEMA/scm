<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TabParametros;

/**
 * TabParametrosSearch represents the model behind the search form about `app\models\TabParametros`.
 */
class TabParametrosSearch extends TabParametros {

    public $sitExterno;
    public $munExterno;

    /**
     * @inheritdoc
     */
    public function rules() {
        $rules = [];

        switch ($this->sgl_parametro) {
            case ('email-padrao') : $rules[] = ['vlr_parametro', 'email', 'message' => Yii::t('yii', $this->dsc_parametro . ' não é um endereço de e-mail válido.')];
                break;
            case ('email-alternativo1') : $rules[] = ['vlr_parametro', 'email', 'message' => Yii::t('yii', $this->dsc_parametro . ' não é um endereço de e-mail válido.')];
                break;
            case ('email-alternativo2') : $rules[] = ['vlr_parametro', 'email', 'message' => Yii::t('yii', $this->dsc_parametro . ' não é um endereço de e-mail válido.')];
                break;
            case ('email-alternativo3') : $rules[] = ['vlr_parametro', 'email', 'message' => Yii::t('yii', $this->dsc_parametro . ' não é um endereço de e-mail válido.')];
                break;
            case ('data-fim-coleta') : $rules[] = ['vlr_parametro', 'validateDataColeta'];
                break;
            case ('data-fim-consulta') : $rules[] = ['vlr_parametro', 'validateDataConsulta'];
                break;
        }

        return array_merge($rules, parent::rules());
    }

    public function validateDataColeta($attribute, $params) {

        $formatData = function ($data) {
            $data = explode('/', $data);
            return $data[2] . $data[1] . $data[0];
        };
        $modulo = \app\modules\admin\models\TabModulos::findOne(['id' => 'drenagem']);
        $inicioColeta = TabParametrosSearch::findOne(['num_ano_ref' => Yii::$app->params['ano-ref'], 'sgl_parametro' => 'data-inicio-coleta', 'modulo_fk' => $modulo->cod_modulo]);

        if ($this->$attribute && ( $formatData($inicioColeta->vlr_parametro) > $formatData($this->$attribute) )) {

            $this->addError($attribute, 'Data de início não pode ser maior que a data final.');
        }
    }

    public function validateDataConsulta($attribute, $params) {
        $formatData = function ($data) {
            $data = explode('/', $data);
            return $data[2] . $data[1] . $data[0];
        };
        $modulo = \app\modules\admin\models\TabModulos::findOne(['id' => 'drenagem']);
        $inicioConsulta = TabParametrosSearch::findOne(['num_ano_ref' => Yii::$app->params['ano-ref'], 'sgl_parametro' => 'data-inicio-consulta', 'modulo_fk' => $modulo->cod_modulo]);

        if ($this->$attribute && ( $formatData($inicioConsulta->vlr_parametro) > $formatData($this->$attribute) )) {

            $this->addError($attribute, 'Data de início não pode ser maior que a data final.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $labels = [
            'cod_parametro' => 'Código',
            'modulo_fk' => 'Módulo',
            'num_ano_ref' => 'Ano',
            'sgl_parametro' => 'Sigla',
            'vlr_parametro' => 'Valor',
            'dsc_parametro' => 'Descrição',
        ];

        switch ($this->sgl_parametro) {
            case ('modulo-bloqueado') : $labelsParam = ['vlr_parametro' => $this->dsc_parametro];
                break;
            case ('data-inicio-coleta') : $labelsParam = ['vlr_parametro' => $this->dsc_parametro];
                break;
            case ('data-fim-coleta') : $labelsParam = ['vlr_parametro' => $this->dsc_parametro];
                break;
            case ('data-inicio-consulta') : $labelsParam = ['vlr_parametro' => $this->dsc_parametro];
                break;
            case ('data-fim-consulta') : $labelsParam = ['vlr_parametro' => $this->dsc_parametro];
                break;
        }
        $labels = array_merge($labels, $labelsParam);
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
        $query = TabParametrosSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_parametro' => $this->cod_parametro,
            $this->tableName() . '.modulo_fk' => $this->modulo_fk,
            $this->tableName() . '.num_ano_ref' => $this->num_ano_ref,
            $this->tableName() . '.dte_inclusao' => $this->dte_inclusao,
            $this->tableName() . '.dte_alteracao' => $this->dte_alteracao,
            $this->tableName() . '.dte_exclusao' => $this->dte_exclusao,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.sgl_parametro', $this->sgl_parametro])
                ->andFilterWhere(['ilike', $this->tableName() . '.vlr_parametro', $this->vlr_parametro])
                ->andFilterWhere(['ilike', $this->tableName() . '.dsc_parametro', $this->dsc_parametro])
                ->andFilterWhere(['ilike', $this->tableName() . '.txt_login_inclusao', $this->txt_login_inclusao]);

        $query->andWhere($this->tableName() . '.dte_exclusao IS NULL');

        return $dataProvider;
    }

    public static function getListaPrestadores() {

        $query = \app\models\VisConsultaPrestadoresSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $modulo = \app\modules\admin\models\TabModulos::findOne(['id' => 'drenagem']);

        $externoMun = TabParametrosSearch::findOne(['num_ano_ref' => Yii::$app->params['ano-ref'], 'sgl_parametro' => 'sistema-bloqueio-usr-externo-mun', 'modulo_fk' => $modulo->cod_modulo]);

        $vlr_parametro = ($externoMun->vlr_parametro) ? \yii\helpers\Json::decode($externoMun->vlr_parametro) : [];


        if ($vlr_parametro) {
            $query->andWhere("cod_municipio::integer in (" . implode(', ', $vlr_parametro) . ")");
        } else {
            $query->andWhere("false");
        }
        $query->orderBy('nome_municipio');

        return $dataProvider;
    }
    
    
    public function afterSave($insert, $changedAttributes) {
		$r = parent::afterSave($insert, $changedAttributes);
		Yii::$app->cache->delete('parametros-do-sistema');
		return $r;
	}
	
	public function afterDelete() {
		$r = parent::afterDelete();
		Yii::$app->cache->delete('parametros-do-sistema');
		return $r;
	}

}
