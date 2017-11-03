<?php

namespace app\modules\comercial\controllers;

use Yii;
use app\modules\comercial\models\TabContratoParcelas;
use app\modules\comercial\models\TabContratoParcelasSearch;
use projeto\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContratoParcelasController implements the CRUD actions for TabContratoParcelas model.
 */
class ContratoParcelasController extends Controller {

    /**
     * Lists all TabContratoParcelas models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TabContratoParcelasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->titulo = 'Gerenciar ContratoParcelas';
        $this->subTitulo = '';

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabContratoParcelas model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $this->titulo = 'Detalhar ContratoParcela';
        $this->subTitulo = '';

        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates e Updates a new TabContratoParcelas  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdmin($id = null) {

        if ($id) {

            $model = $this->findModel($id);
            $acao = 'update';
            $this->titulo = 'Alterar ContratoParcela';
            $this->subTitulo = '';
        } else {

            $acao = 'create';
            $model = new TabContratoParcelas();
            $this->titulo = 'Incluir ContratoParcela';
            $this->subTitulo = '';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', $acao);
            return $this->redirect(['view', 'id' => $model->cod_contrato_parcelas]);
        }

        return $this->render('admin', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new TabContratoParcelas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabContratoParcelas();

        $this->titulo = 'Incluir ContratoParcela';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_contrato_parcelas]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TabContratoParcelas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $this->titulo = 'Alterar ContratoParcela';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_contrato_parcelas]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TabContratoParcelas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {

        $model = $this->findModel($id);
        $model->dte_exclusao = 'NOW()';

        if ($model->save()) {

            $this->session->setFlashProjeto('success', 'delete');
        } else {

            $this->session->setFlashProjeto('danger', 'delete');
        }

        return $this->redirect(['index']);
    }

    public function actionBuscarParcelasContato() {
        $post = Yii::$app->request->post();

        $i = 0;
        $nparcela = ($post['TabContratoPSearch']['qnt_parcelas']) ? $post['TabContratoPSearch']['qnt_parcelas'] : 1;

        $valor = (float) $post['TabContratoPSearch']['valor_contrato'] / (int) $nparcela;
        $dataArray = explode('/', $post['TabContratoPSearch']['dt_vencimento']);
        $dados = null;

        while ($i < $nparcela) {

            $parcela = new \app\modules\comercial\models\TabContratoParcelasSearch();
            $parcela->cod_contrato_fk = $post['TabContratoPSearch']['cod_contrato'];
            $parcela->numero = $i + 1;

            $parcela->valor = number_format($valor, 2, ".", "");

            if (str_pad($dataArray[1] + 1, '2', '0', 0) > 12) {
                $dia = $dataArray[0];
                $dataArray[1] = 1;
                $dataArray[2] = $dataArray[2] + 1;
            } elseif (str_pad($dataArray[1] + 1, '2', '0', 0) == '02' && str_pad($dataArray[0] + $i, '2', '0', 0) > 28) {

                $dia = 28;
                $dataArray[1] = $dataArray[1] + 1;
            } else {
                $dataArray[1] = $dataArray[1] + 1;
                $dia = $dataArray[0];
            }

            $parcela->dt_vencimento = $dia . '/' . str_pad($dataArray[1], '2', '0', 0) . '/' . $dataArray[2];

            $this->module->module->layout = null;
            $form = \yii\widgets\ActiveForm::begin();

            $dados .= $this->renderAjax('@app/modules/comercial/views/contrato-parcelas/_form_lista_parcela_add', compact('i', 'parcela', 'form'));

            $i++;
        }
        return \yii\helpers\Json::encode($dados);
    }

    public function actionIncluirParcelas() {

        $post = Yii::$app->request->post();

        $msg = $new = null;

        TabContratoParcelasSearch::deleteAll(['cod_contrato_fk' => $post['TabContratoPSearch']['cod_contrato']]);

        //TabContratoPSearch
        $i = 0;
        foreach ($post['TabContratoParcelasSearch'] as $key => $parcela) {
            $model = new TabContratoParcelasSearch();
            if ($i == 0) {
                $data = $model->dt_vencimento;
            }

            $model->attributes = $parcela;
            $model->numero = $i+1;
            $total += $model->valor;
            $model->save();
            $i++;
        }

        $contrato = \app\modules\comercial\models\TabContratoSearch::find()->where(['cod_contrato' => $post['TabContratoPSearch']['cod_contrato']])->one();
        unset($post['TabContratoPSearch']['cod_contrato']);
        $contrato->dt_vencimento = $data;
        $contrato->valor_contrato = round($total, 2);
        $contrato->qnt_parcelas = $i;
        $contrato->save();

        if ($contrato && $contrato->getErrors()) {
            $dados = $contrato->getErrors();
        } else {
            $msg['tipo'] = 'success';
            $msg['msg'] = 'Forma de pagamento incluída com sucesso.';
            $msg['icon'] = 'check';

            $form = \yii\widgets\ActiveForm::begin();
            $this->module->module->layout = null;
            $dados = $this->render('@app/modules/comercial/views/contrato/_lista_contratos', ['cod_cliente' => $post['TabClienteSearch']['cod_cliente'], 'form' => $form, 'msg' => $msg]);
        }


        return \yii\helpers\Json::encode($dados);
    }

    public function actionCarregarParcelas() {

        $post = Yii::$app->request->post();

        $msg = $new = null;

        $parcelas = \app\modules\comercial\models\TabContratoParcelasSearch::find()->where(['cod_contrato_fk' => $post['cod_contrato']])->all();
        $dados = null;
        foreach ($parcelas as $i => $parcela) {

            $this->module->module->layout = null;
            $form = \yii\widgets\ActiveForm::begin();

            $dados .= $this->renderAjax('@app/modules/comercial/views/contrato-parcelas/_form_lista_parcela_add', compact('i', 'parcela', 'form'));
        }

        return \yii\helpers\Json::encode($dados);
    }

    /**
     * Finds the TabContratoParcelas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabContratoParcelas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabContratoParcelas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
