<?php

namespace app\modules\comercial\controllers;

use Yii;
use app\models\TabAndamento;
use app\models\TabAndamentoSearch;
use projeto\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AndamentoController implements the CRUD actions for TabAndamento model.
 */
class AndamentoController extends \app\controllers\AndamentoController {

    public function actionIncluirAndamento() {

        $post = Yii::$app->request->post();
        $msg = $new = null;


        $model = new \app\models\TabAndamentoSearch();


        $model->attributes = $post['TabAndamentoSearch'];
        $model->cod_usuario_inclusao_fk = $this->user->identity->getId();
        $str = 'Andamento';
        $model->save();


        if ($model && $model->getErrors()) {
            $dados = $model->getErrors();
        } else {
            $msg['tipo'] = 'success';
            $msg['msg'] = $str . ' efetivada com sucesso.';
            $msg['icon'] = 'check';

            $form = \yii\widgets\ActiveForm::begin();
            $this->module->module->layout = null;
            $dados = $this->render('@app/modules/comercial/views/contrato/_lista_contratos', ['cod_cliente' => $post['TabClienteSearch']['cod_cliente'], 'form' => $form, 'msg' => $msg]);
        }


        return \yii\helpers\Json::encode($dados);
    }

    public function actionExcluirAndamentos() {
        $post = Yii::$app->request->post();
        $andamento = TabAndamentoSearch::find()->where(['cod_andamento' => $post['id']])->orderBy('cod_andamento desc')->one();
        

        $setor = $andamento->cod_setor_fk;
        if ($andamento->delete()) {
            $str = 'Exclusão da(o) com sucesso';

            $msg['tipo'] = 'success';
            $msg['msg'] = $str;
            $msg['icon'] = 'check';
        } else {
            $str = 'Erro na exclusão';

            $msg['tipo'] = 'error';
            $msg['msg'] = $str;
            $msg['icon'] = 'check';
        }
        $andamento = TabAndamentoSearch::find()->where(['cod_setor_fk' => $setor])->orderBy('cod_andamento desc');

        $dados = $this->renderAjax('@app/views/andamento/_lista_andamento', ['andamento' => $andamento]);

        return \yii\helpers\Json::encode($dados);
    }

    public function actionCarregarAndamento() {


        $andamento = TabAndamentoSearch::find()->where(['cod_setor_fk' => Yii::$app->request->post()['cod_setor_fk']])->orderBy('cod_andamento desc');

        $dados = $this->renderAjax('@app/views/andamento/_lista_andamento', ['andamento' => $andamento]);

        return \yii\helpers\Json::encode($dados);
    }

}
