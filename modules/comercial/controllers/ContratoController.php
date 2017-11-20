<?php

namespace app\modules\comercial\controllers;

use Yii;
use app\modules\comercial\models\TabContrato;
use app\modules\comercial\models\TabContratoSearch;
use projeto\web\Controller;
use yii\web\NotFoundHttpException;
use kartik\mpdf\Pdf;

/**
 * ContratoController implements the CRUD actions for TabContrato model.
 */
class ContratoController extends Controller {

    /**
     * Lists all TabContrato models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TabContratoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->titulo = 'Gerenciar Contrato';
        $this->subTitulo = '';

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabContrato model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $this->titulo = 'Detalhar Contrato';
        $this->subTitulo = '';

        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates e Updates a new TabContrato  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdmin($id = null) {

        if ($id) {

            $model = $this->findModel($id);
            $acao = 'update';
            $this->titulo = 'Alterar Contrato';
            $this->subTitulo = '';
        } else {

            $acao = 'create';
            $model = new TabContrato();
            $this->titulo = 'Incluir Contrato';
            $this->subTitulo = '';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', $acao);
            return $this->redirect(['view', 'id' => $model->cod_contrato]);
        }

        return $this->render('admin', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new TabContrato model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabContrato();

        $this->titulo = 'Incluir Contrato';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_contrato]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TabContrato model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $this->titulo = 'Alterar Contrato';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_contrato]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TabContrato model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {

        $model = $this->findModel($id);
        $model->dt_exclusao = 'NOW()';

        if ($model->save()) {

            $this->session->setFlashProjeto('success', 'delete');
        } else {

            $this->session->setFlashProjeto('danger', 'delete');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the TabContrato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabContrato the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabContrato::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCarregarContrato() {

        $this->module->module->layout = null;
        $contrato = \app\modules\comercial\models\ViewContratosSearch::find()->where(['cod_contrato' => Yii::$app->request->post()['cod']])->asArray()->all();

        return \yii\helpers\Json::encode($contrato);
    }

    public function actionCarregarGridContrato() {
        $post = Yii::$app->request->post();

        $form = \yii\widgets\ActiveForm::begin();
        $this->module->module->layout = null;
        $dados = $this->render('@app/modules/comercial/views/contrato/_lista_contratos', ['cod_cliente' => $post['id'], 'form' => $form, 'msg' => $msg]);

        return \yii\helpers\Json::encode($dados);
    }

    public function actionAbrirImpressao() {
        $post = Yii::$app->request->post();

//$dados = $this->printContrato($id);

        $dados = $this->montarContrato($post['cod_contrato']);
        
        return \yii\helpers\Json::encode($dados);
    }
    public function actionImpressao($cod_contrato) {
        
        $post = \Yii::$app->session->get('pdfContrato'); 

        //$contrato = \app\modules\comercial\models\ViewClienteContratoSearch::find()->where(['cod_contrato' => $post['cod_contrato']])->one();
        //$nome = \projeto\Util::retiraAcento(str_replace(' ', '_', $contrato->razao_social)) . '-' . $contrato->cod_contrato . '-' . date('dmYs') . '.pdf';
        $nome = $cod_contrato.'_'.date('YmdHis').'.pdf';
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD,
            // your html content input
            'filename' => $nome,
            'content' => $post,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => [],
            // call mPDF methods on the fly
            'methods' => [
                //'SetHeader' => ['Krajee Report Header'],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        if (!is_dir(Yii::getAlias("@runtime/tmp/"))) {
            mkdir(Yii::getAlias("@runtime/tmp/"), 0755);
        };
        
        $dados = $pdf->render();
        
        return $dados;
    }

    
    public function actionImprimirContrato() {

        $post = Yii::$app->request->post();
        
        \Yii::$app->session->set('pdfContrato', ''); 
        
                 \Yii::$app->session->set('pdfContrato', $post['html_contrato']); 
        
       
        
        return true;
    }

    
    public function montarContrato($cod_contrato) {


        $contrato = \app\modules\comercial\models\ViewClienteContratoSearch::find()->where(['cod_contrato' => $cod_contrato])->one();

        $modelo = \app\modules\comercial\models\TabModeloContratoSearch::find()->where(['cod_contrato_tipo_contrato_fk' => $contrato->tipo_contrato_fk])->one();

        $modelo->substituiVariaveis($contrato);
        
        return $modelo['txt_modelo'];
    
  
    }

    public function actionExcluirContrato() {
        $post = Yii::$app->request->post();

        $contrato = \app\modules\comercial\models\TabContratoSearch::find()->where(['cod_contrato' => $post['id']])->one();

        if ($contrato) {
            $contrato->ativo = false;
            $contrato->save();
        }

        $str = 'Exclusão efetuada com sucesso';

        $msg['tipo'] = 'success';
        $msg['msg'] = $str;
        $msg['icon'] = 'check';

        $form = \yii\widgets\ActiveForm::begin();
        $this->module->module->layout = null;
        $dados = $this->render('@app/modules/comercial/views/contrato/_lista_contratos', ['cod_cliente' => $contrato->cod_cliente_fk, 'form' => $form, 'msg' => $msg]);

        return \yii\helpers\Json::encode($dados);
    }

    public function actionMudarStatus() {
        $post = Yii::$app->request->post();

        $contrato = \app\modules\comercial\models\TabContratoSearch::find()->where(['cod_contrato' => $post['id']])->one();

        if ($contrato) {
            $contrato->status = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('status-contrato', $post['status']);

            if ($contrato->save()) {
                if ($post['status'] == 4) {
                    $msg = 'Contranto fechado, encaminhado para o financeiro';


                    $andam = new \app\models\TabAndamentoSearch();
                    $andam->txt_notificacao = $msg;
                    $andam->cod_usuario_inclusao_fk = $this->user->identity->getId();
                    $andam->cod_setor_fk = $post['cod_setor'];
                    $andam->dt_retorno = date('d/m/Y', strtotime(date('Y-m-d') . '+5 days'));
                    $andam->save();

                    $setor = new \app\models\TabSetoresSearch();
                    $setor->cod_tipo_contrato_fk = $post['tipo_contrato'];
                    $setor->cod_tipo_setor_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('setores', '2');
                    $setor->save();

                    $andam = new \app\models\TabAndamentoSearch();
                    $andam->txt_notificacao = 'Contrato fechado, aguardando validação';
                    $andam->cod_usuario_inclusao_fk = $this->user->identity->getId();
                    $andam->cod_setor_fk = $setor->cod_setor;
                    $andam->dt_retorno = date('d/m/Y', strtotime(date('Y-m-d') . '+5 days'));
                    $andam->save();
                } elseif ($post['status'] == 2) {
                    $msg = 'Contranto recusado';

                    $andam = new \app\models\TabAndamentoSearch();
                    $andam->txt_notificacao = $msg;
                    $andam->cod_usuario_inclusao_fk = $this->user->identity->getId();
                    $andam->cod_setor_fk = $post['cod_setor'];
                    $andam->dt_retorno = date('d/m/Y', strtotime(date('Y-m-d') . '+5 days'));
                    $andam->save();
                }
            }
        }

        $msg = $msg . ' com sucesso';

        $msgs['tipo'] = 'success';
        $msgs['msg'] = $msg;
        $msgs['icon'] = 'check';

        $form = \yii\widgets\ActiveForm::begin();
        $this->module->module->layout = null;
        $dados = $this->render('@app/modules/comercial/views/contrato/_lista_contratos', ['cod_cliente' => $contrato->cod_cliente_fk, 'form' => $form, 'msg' => $msgs]);

        return \yii\helpers\Json::encode($dados);
    }

}
