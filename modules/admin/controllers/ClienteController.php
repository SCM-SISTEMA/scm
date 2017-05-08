<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\TabCliente;
use app\models\TabClienteSearch;
use yii\web\NotFoundHttpException;

/**
 * ClienteController implements the CRUD actions for TabCliente model.
 */
class ClienteController extends \app\controllers\ClienteController {

    /**
     * Lists all TabCliente models.
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new TabClienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->titulo = 'Gerenciar Cliente';
        $this->subTitulo = '';

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabCliente model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $this->titulo = 'Detalhar Cliente';
        $this->subTitulo = '';

        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates e Updates a new TabCliente  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdmin($id = null) {
        if ($id) {

            $model = $this->findModel($id);
            $acao = 'update';
            $this->titulo = 'Alterar Cliente';
            $this->subTitulo = '';
        } else {

            $acao = 'create';
            $model = new TabClienteSearch();
            $this->titulo = 'Incluir Cliente';
            $this->subTitulo = '';
        }

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $post = Yii::$app->request->post();
                
                $endereco = \Yii::$app->session->get('endereco');
                $contato = \Yii::$app->session->get('contato');
                $model->save();
                if($endereco){
                    foreach ($endereco as $key => $value) {
                        
                        if( strpos($value['cod_endereco'], 'novo') !== false ){
                            $value['cod_endereco'] = null;
                            $modelEnd = new \app\models\TabEnderecoSearch();
                            $modelEnd->attributes = $value;
                            $modelEnd->chave_fk = 
                           print_r($modelEnd->attributes); exit;
                            $modelEnd->save();
                        }
                    }
                }
                
                if($contato){
                    foreach ($contato as $key => $value) {
                        
                        if( strpos($value['cod_endereco'], 'novo') !== false ){
                            $value['cod_contato'] = null;
                            $modelCon = new \app\models\TabEnderecoSearch();
                            $modelCon->attributes = $value;
                            $modelCon->save();
                        }
                    }
                }
                
                print_r($model->attributes); exit;
                
                $this->session->setFlashProjeto('success', $acao);
                return $this->redirect(['view', 'id' => $model->cod_cliente]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('admin', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new TabCliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabCliente();

        $this->titulo = 'Incluir Cliente';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_cliente]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TabCliente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $this->titulo = 'Alterar Cliente';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_cliente]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TabCliente model.
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
     * Finds the TabCliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabCliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabCliente::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIncluirEndereco() {

        $post = Yii::$app->request->post();

        $msg = $new = null;
        $model = null;
        $itens = \Yii::$app->session->get('endereco');

        if ($post['TabEnderecoSearch']['cod_endereco'] != null) {

            $model = new \app\models\TabEnderecoSearch();
            $model->load($post);
            $model->uf = $post['TabEnderecoSearch']['uf'];
           
            $model->municipio = \app\models\TabMunicipiosSearch::findOneAsArray(['cod_municipio' => $model->cod_municipio_fk])['txt_nome'];
        } else {

            $model = new \app\models\TabEnderecoSearch();
            $model->load($post);
            $model->cod_endereco = 'novo-' . rand('100000000', '999999999');
            $model->uf = $post['TabEnderecoSearch']['uf'];
            $model->ativo = 1;
            $model->municipio = \app\models\TabMunicipiosSearch::findOneAsArray(['cod_municipio' => $model->cod_municipio_fk])['txt_nome'];
        }
 
        $model->setScenario('criar');
        $model->validate();

        if ($model && $model->getErrors()) {
            $dados = $model->getErrors();
        } else {

            $itens[$model->cod_endereco] = $model->attributes + ['uf' => $model->uf, 'municipio' => $model->municipio];
            \Yii::$app->session->set('endereco', $itens);

            $str = 'Inclusão com sucesso';

            $msg['tipo'] = 'success';
            $msg['msg'] = $str . ' efetivada com sucesso.';
            $msg['icon'] = 'check';


            Yii::$app->controller->action->id = 'index';

            $dados = ['grid' => $this->renderAjax('@app/views/endereco/_grid_cliente', ['msg' => $msg])];
        }


        return \yii\helpers\Json::encode($dados);
    }

    public function actionExcluirEndereco($cod_endereco = null) {

        $itens = \Yii::$app->session->get('endereco');

        $str = 'Exclusão da(o) com sucesso';
        unset($itens[$cod_endereco]);
        \Yii::$app->session->set('endereco', $itens);
        $msg['tipo'] = 'success';
        $msg['msg'] = $str;
        $msg['icon'] = 'check';


        $dados = ['grid' => $this->renderAjax('@app/views/endereco/_grid_cliente', ['msg' => $msg])];

        return \yii\helpers\Json::encode($dados);
    }

    public function actionIncluirContato() {

        $post = Yii::$app->request->post();

        $msg = $new = null;
        $model = null;
        $itens = \Yii::$app->session->get('contato');

        if ($post['TabContatoSearch']['cod_contato'] != null) {

            $model = new \app\models\TabContatoSearch();
            $model->attributes = $post['TabContatoSearch'];
            $model->tipo = $post['TabContatoSearch']['tipo'];
            $model->ativo = (($post['TabContatoSearch']['ativo']==='0') ? '0' : '1');
            
        } else {

            $model = new \app\models\TabContatoSearch();
            $model->load($post);
            $model->tipo = $post['TabContatoSearch']['tipo'];
            $model->cod_contato = 'novo-' . rand('100000000', '999999999');
            $model->contato_email = $post['TabContatoSearch']['contato_email'];
            $model->ativo = 1;
        }
        if ($model->contato_email) {
            $model->setScenario('email');
        } else {
            $model->setScenario('telefone');
        }

  
        $model->validate();
        if ($model && $model->getErrors()) {
            $dados = $model->getErrors();
        } else {

            $itens[$model->cod_contato] = $model->attributes + ['contato_email' =>  $model->contato_email];
            \Yii::$app->session->set('contato', $itens);

            $str = 'Inclusão com sucesso';

            $msg['tipo'] = 'success';
            $msg['msg'] = $str . ' efetivada com sucesso.';
            $msg['icon'] = 'check';


            Yii::$app->controller->action->id = 'index';

            $dados = ['grid' => $this->renderAjax('@app/views/contato/_grid_cliente', ['msg' => $msg])];
        }


        return \yii\helpers\Json::encode($dados);
    }

    public function actionExcluirContato($cod_contato = null) {

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
