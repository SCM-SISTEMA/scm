<?php

namespace app\modules\comercial\controllers;

use Yii;
use app\modules\comercial\models\TabSocios;
use app\modules\comercial\models\TabSociosSearch;
use projeto\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SociosController implements the CRUD actions for TabSocios model.
 */
class SociosController extends Controller {

    /**
     * Lists all TabSocios models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TabSociosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->titulo = 'Gerenciar Socios';
        $this->subTitulo = '';

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabSocios model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $this->titulo = 'Detalhar Socio';
        $this->subTitulo = '';

        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates e Updates a new TabSocios  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdmin($id = null) {

        if ($id) {

            $model = $this->findModel($id);
            $acao = 'update';
            $this->titulo = 'Alterar Socio';
            $this->subTitulo = '';
        } else {

            $acao = 'create';
            $model = new TabSocios();
            $this->titulo = 'Incluir Socio';
            $this->subTitulo = '';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', $acao);
            return $this->redirect(['view', 'id' => $model->cod_socio]);
        }

        return $this->render('admin', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new TabSocios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabSocios();

        $this->titulo = 'Incluir Socio';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_socio]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TabSocios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $this->titulo = 'Alterar Socio';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_socio]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TabSocios model.
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
     * Finds the TabSocios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabSocios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabSocios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIncluirSocios() {

        $post = Yii::$app->request->post();

        $msg = $new = null;
        $model = null;
        $itens = \Yii::$app->session->get('socios');

        if ($post['TabSociosSearch']['cod_socio'] != null) {

            $model = new \app\modules\comercial\models\TabSociosSearch();
            $model->load($post);
            $str = 'Alteração';
        } else {

            $model = new \app\modules\comercial\models\TabSociosSearch();
            $model->load($post);
            $model->cod_socio = 'novo-' . rand('100000000', '999999999');
            $str = 'Inclusão';
        }

        $model->validate();

        if ($model && $model->getErrors()) {
            $dados = $model->getErrors();
        } else {
            $itens[$model->cod_socio] = $model->attributes;
            $itens[$model->cod_socio]['email'] = $model->email;
            $itens[$model->cod_socio]['skype'] = $model->skype;
            $itens[$model->cod_socio]['telefone'] = $model->telefone;
            \Yii::$app->session->set('socios', $itens);


            $msg['tipo'] = 'success';
            $msg['msg'] = $str . ' efetivada com sucesso.';
            $msg['icon'] = 'check';


            Yii::$app->controller->action->id = 'index';

            $dados = ['grid' => $this->renderAjax('@app/modules/comercial/views/socios/_grid_socios', ['msg' => $msg])];
        }

        return \yii\helpers\Json::encode($dados);
    }

    public function actionExcluirSocios($cod_socios = null) {

        $itens = \Yii::$app->session->get('socios');

        $str = 'Exclusão da(o) com sucesso';
        unset($itens[$cod_socios]);
        \Yii::$app->session->set('socios', $itens);
        $msg['tipo'] = 'success';
        $msg['msg'] = $str;
        $msg['icon'] = 'check';


        $dados = ['grid' => $this->renderAjax('@app/modules/comercial/views/socios/_grid_socios', ['msg' => $msg])];

        return \yii\helpers\Json::encode($dados);
    }

}
