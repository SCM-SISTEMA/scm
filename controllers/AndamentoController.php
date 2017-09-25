<?php

namespace app\controllers;

use Yii;
use app\models\TabAndamento;
use app\models\TabAndamentoSearch;
use projeto\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AndamentoController implements the CRUD actions for TabAndamento model.
 */
class AndamentoController extends Controller {

    /**
     * Lists all TabAndamento models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TabAndamentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->titulo = 'Gerenciar Andamento';
        $this->subTitulo = '';

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabAndamento model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $this->titulo = 'Detalhar Andamento';
        $this->subTitulo = '';

        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates e Updates a new TabAndamento  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdmin($id = null) {

        if ($id) {

            $model = $this->findModel($id);
            $acao = 'update';
            $this->titulo = 'Alterar Andamento';
            $this->subTitulo = '';
        } else {

            $acao = 'create';
            $model = new TabAndamento();
            $this->titulo = 'Incluir Andamento';
            $this->subTitulo = '';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', $acao);
            return $this->redirect(['view', 'id' => $model->cod_andamento]);
        }

        return $this->render('admin', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new TabAndamento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabAndamento();

        $this->titulo = 'Incluir Andamento';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_andamento]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TabAndamento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $this->titulo = 'Alterar Andamento';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_andamento]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TabAndamento model.
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
     * Finds the TabAndamento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabAndamento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabAndamento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIncluirAndamento() {

        $post = Yii::$app->request->post();

        $msg = $new = null;

        $model = new \app\models\TabAndamentoSearch();


        $model->attributes = $post['TabAndamentoSearch'];
        $model->cod_usuario_inclusao_fk = $this->user->identity->getId();
        $str = 'Inclusão';

        $model->save();

        if ($model && $model->getErrors()) {
            $dados = $model->getErrors();
        } else {
            $msg['tipo'] = 'success';
            $msg['msg'] = $str . ' efetivada com sucesso.';
            $msg['icon'] = 'check';

            $find = \app\models\TabAndamentoSearch::find()->where(['cod_contrato_fk'=>$model->cod_contrato_fk])->orderBy('cod_andamento desc')->all();
            
            if ($find) {
                    
                foreach($find as $cont) {
                    
                    $conts[] = $cont->attributes;
                    
                }
                
            }
            
            $contrato['andamentos']['contrato'] = $conts;
            

            $dados = ['lista' => $this->renderAjax('@app/views/andamento/_lista_andamento', ['msg' => $msg, 'contrato' => $contrato])];


        }


        return \yii\helpers\Json::encode($dados);
    }

    public function actionExcluirAndamento($cod_contato = null) {

        $itens = \Yii::$app->session->get('contato');

        $str = 'Exclusão da(o) com sucesso';
        unset($itens[$cod_contato]);
        \Yii::$app->session->set('contato', $itens);
        $msg['tipo'] = 'success';
        $msg['msg'] = $str;
        $msg['icon'] = 'check';


        $dados = ['grid' => $this->renderAjax('@app/views/contato/_grid_cliente', ['msg' => $msg])];

        return \yii\helpers\Json::encode($dados);
    }

}
