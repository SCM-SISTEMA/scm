<?php

namespace app\controllers;

use Yii;
use app\models\TabEndereco;
use app\models\TabEnderecoSearch;
use projeto\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EnderecoController implements the CRUD actions for TabEndereco model.
 */
class EnderecoController extends Controller {

    /**
     * Lists all TabEndereco models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TabEnderecoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->titulo = 'Gerenciar Endereco';
        $this->subTitulo = '';

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabEndereco model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        $this->titulo = 'Detalhar Endereco';
        $this->subTitulo = '';

        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates e Updates a new TabEndereco  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdmin($id = null) {

        if ($id) {

            $model = $this->findModel($id);
            $acao = 'update';
            $this->titulo = 'Alterar Endereco';
            $this->subTitulo = '';
        } else {

            $acao = 'create';
            $model = new TabEndereco();
            $this->titulo = 'Incluir Endereco';
            $this->subTitulo = '';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', $acao);
            return $this->redirect(['view', 'id' => $model->cod_municipio_fk]);
        }

        return $this->render('admin', [
                    'model' => $model,
                ]);
    }

    /**
     * Creates a new TabEndereco model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabEndereco();

        $this->titulo = 'Incluir Endereco';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_municipio_fk]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TabEndereco model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $this->titulo = 'Alterar Endereco';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_municipio_fk]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TabEndereco model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
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
     * Finds the TabEndereco model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TabEndereco the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabEndereco::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    
    
    public function actionVerificaCnpj() {

        $this->module->module->layout = null;
        $post = Yii::$app->request->post();

        $cliente = \app\models\TabClienteSearch::findOne(['cnpj' => $post['dados']]);

        if ($cliente) {
            
        } else {
            $cliente = new \app\models\TabClienteSearch();
            $cliente->cnpj = $post['dados'];
            \Yii::$app->session->set('endereco', []);
            \Yii::$app->session->set('contato', []);
            $cliente->buscaCliente();
            $grids = $gridCont = $gridEnd = [];

            if ($cliente->dadosReceita) {

                $this->dadosCliente($cliente, $grids);

                if ($grids['itens'])
                    $gridCont = ['grid' => $this->renderAjax('@app/views/contato/_grid_cliente', ['msg' => $msg])];

                if ($grids['itensE'])
                    $gridEnd = ['grid' => $this->renderAjax('@app/views/endereco/_grid_cliente', ['msg' => $msg])];
            }
        }
        $cliente = $cliente->attributes;
        return \yii\helpers\Json::encode(['cliente' => $cliente, 'gridCont' => $gridCont, 'gridEnd' => $gridEnd]);
    }
    public function actionVerificaCep() {

        $post = Yii::$app->request->post();
        $endereco = \app\models\TabEnderecoSearch();
        $endereco->cep = $post['dados'];
        $endereco->buscaCep();
        
        $this->module->module->layout = null;
        
        return \yii\helpers\Json::encode($endereco->dadosCep);
    }

}
