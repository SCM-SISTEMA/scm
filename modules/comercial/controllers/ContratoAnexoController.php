<?php

namespace app\modules\comercial\controllers;

use Yii;
use app\modules\comercial\models\TabContratoAnexo;
use app\modules\comercial\models\TabContratoAnexoSearch;
use projeto\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContratoAnexoController implements the CRUD actions for TabContratoAnexo model.
 */
class ContratoAnexoController extends Controller {

    /**
     * Lists all TabContratoAnexo models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TabContratoAnexoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->titulo = 'Gerenciar ContratoAnexo';
        $this->subTitulo = '';

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabContratoAnexo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $this->titulo = 'Detalhar ContratoAnexo';
        $this->subTitulo = '';

        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates e Updates a new TabContratoAnexo  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdmin($id = null) {

        if ($id) {

            $model = $this->findModel($id);
            $acao = 'update';
            $this->titulo = 'Alterar ContratoAnexo';
            $this->subTitulo = '';
        } else {

            $acao = 'create';
            $model = new TabContratoAnexo();
            $this->titulo = 'Incluir ContratoAnexo';
            $this->subTitulo = '';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', $acao);
            return $this->redirect(['view', 'id' => $model->cod_contrato_anexo]);
        }

        return $this->render('admin', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new TabContratoAnexo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabContratoAnexo();

        $this->titulo = 'Incluir ContratoAnexo';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_contrato_anexo]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TabContratoAnexo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $this->titulo = 'Alterar ContratoAnexo';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_contrato_anexo]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TabContratoAnexo model.
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

    /**
     * Finds the TabContratoAnexo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabContratoAnexo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabContratoAnexo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCarregarAnexo() {

        $contrato = \app\modules\comercial\models\TabContratoAnexoSearch::find()->where(['cod_contrato_fk' => Yii::$app->request->post()['cod_contrato']])->orderBy('cod_contrato_anexo desc');

        $dados = $this->renderAjax('@app/modules/comercial/views/anexo/_lista_anexo', ['anexos' => $contrato]);

        return \yii\helpers\Json::encode($dados);
    }

    public function actionExcluirAnexo($cod_contrato_anexo) {
        $post = Yii::$app->request->post();
     
        $anexo = \app\modules\comercial\models\TabContratoAnexoSearch::find()->where(['cod_contrato_anexo' => $cod_contrato_anexo])->one();

        $cod_contrato = $anexo->cod_contrato_fk;
        if ($anexo) {
            $url = \Yii::getAlias('@webroot') . '/arquivos/' . $anexo->cod_contrato_fk . '/' . $anexo->nome;
            
            if (@unlink($url)) {
                $str = 'Arquivo excluído com sucesso';
                $msg['tipo'] = 'success';
                $msg['msg'] = $str;
                $msg['icon'] = 'check';
               
            } else {
                $str = 'Erro na exclusão do arquivo';
                $msg['tipo'] = 'error';
                $msg['msg'] = $str;
                $msg['icon'] = 'check';
            }
        }
         $anexo->delete();
        $contrato = \app\modules\comercial\models\TabContratoAnexoSearch::find()->where(['cod_contrato_fk' => $cod_contrato])->orderBy('cod_contrato_anexo desc');

        $dados = $this->renderAjax('@app/modules/comercial/views/anexo/_lista_anexo', ['anexos' => $contrato]);

        return \yii\helpers\Json::encode($dados);
    }

}
