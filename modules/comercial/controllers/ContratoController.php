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

        $dados = $this->montarContrato($post['cod_contrato'], $post['padrao']);

        return \yii\helpers\Json::encode($dados);
    }

    public function actionImpressao($cod_contrato) {

        $contrato = TabContratoSearch::find()->where(['cod_contrato' => $cod_contrato])->one();

        //$contrato = \app\modules\comercial\models\ViewClienteContratoSearch::find()->where(['cod_contrato' => $post['cod_contrato']])->one();
        //$nome = \projeto\Util::retiraAcento(str_replace(' ', '_', $contrato->razao_social)) . '-' . $contrato->cod_contrato . '-' . date('dmYs') . '.pdf';
        $nome = $cod_contrato . '_' . date('YmdHis') . '.pdf';
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
            'content' => $contrato->contrato_html,
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

        $contrato = TabContratoSearch::find()->where(['cod_contrato' => $post['cod_contrato']])->one();
        $contrato->contrato_html = $post['html_contrato'];
        $contrato->save();
        return true;
    }

    public function montarContrato($cod_contrato, $limpar = false) {

        $contrato = \app\modules\comercial\models\ViewClienteContratoSearch::find()->where(['cod_contrato' => $cod_contrato])->one();

        if (!$contrato->contrato_html || $limpar) {

            $modelo = \app\modules\comercial\models\TabModeloContratoSearch::find()->where(['cod_contrato_tipo_contrato_fk' => $contrato->tipo_contrato_fk])->one();

            if ($modelo) {
                $modelo->substituiVariaveis($contrato);

                return $modelo['txt_modelo'];
            }
        } else {

            return $contrato->contrato_html;
        }

        return null;
    }

    public function actionExcluirContrato() {
        $post = Yii::$app->request->post();

        $contrato = \app\modules\comercial\models\TabContratoSearch::find()->where(['cod_contrato' => $post['id']])->one();

        if ($contrato) {

            $contrato->status = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('status-contrato', '4');
            $contrato->save();

            $str = 'Contranto cancelado';

            $andam = new \app\models\TabAndamentoSearch();
            $andam->txt_notificacao = $str;
            $andam->cod_usuario_inclusao_fk = $this->user->identity->getId();
            $andam->cod_setor_fk = $post['setor'];
            $andam->save();
        }

        $str = $str . ' com sucesso';

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
            $contrato->tipo_contrato_fk = ($post['status'] == 5 || $post['status'] == 1 || $post['status'] == 2) ? $contrato->tipo_contrato_fk : $post['tipo_contrato'];

            if ($contrato->save()) {

                if ($post['status'] == 3) {
                    $msg = 'Contranto fechado';
                } elseif ($post['status'] == 1) {
                    $msg = 'Contranto ativado';
                } elseif ($post['status'] == 6) {
                    $msg = 'Contranto aprovado';

                    $setor = \app\models\TabSetoresSearch::find()->where([
                                'cod_tipo_contrato_fk' => $post['tipo_contrato'],
                                'cod_tipo_setor_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('setores', '1')
                            ])->one();

                    $andam = new \app\models\TabAndamentoSearch();
                    $andam->txt_notificacao = 'Aprovado';
                    $andam->cod_usuario_inclusao_fk = $this->user->identity->getId();
                    $andam->cod_setor_fk = $setor->cod_setor;
                    $andam->dt_retorno = date('d/m/Y');
                    $andam->save();
                } elseif ($post['status'] == 5) {
                    $msg = 'Contranto enviado para o financeiro';

                    $perfil = \app\modules\admin\models\VisUsuariosPerfisSearch::find()->where("
                        modulo_id='financeiro' and
                        nome_perfil ilike 'administrador%'
                        ")->asArray()->one();

                    $setor = new \app\models\TabSetoresSearch();
                    $setor->cod_tipo_contrato_fk = $post['tipo_contrato'];
                    $setor->cod_usuario_responsavel_fk = $perfil['cod_usuario_fk'];
                    $setor->cod_tipo_setor_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('setores', '2');
                    $setor->save();

                    $andam = new \app\models\TabAndamentoSearch();
                    $andam->txt_notificacao = 'Aguardando Aprovação';
                    $andam->cod_usuario_inclusao_fk = $this->user->identity->getId();
                    $andam->cod_setor_fk = $setor->cod_setor;
                    $andam->dt_retorno = date('d/m/Y', strtotime(date('Y-m-d') . '+5 days'));
                    $andam->save();
                } else {
                    $msg = 'Contranto recusado';
                }

                $andam = new \app\models\TabAndamentoSearch();
                $andam->txt_notificacao = $msg;
                $andam->cod_usuario_inclusao_fk = $this->user->identity->getId();
                $andam->cod_setor_fk = $post['setor'];
                $andam->dt_retorno = date('d/m/Y', strtotime(date('Y-m-d') . '+5 days'));
                $andam->save();
            }
        }

        $msg = $msg . ' com sucesso';

        $msgs['tipo'] = 'success';
        $msgs['msg'] = $msg;
        $msgs['icon'] = 'check';

        $form = \yii\widgets\ActiveForm::begin();
        $this->module->module->layout = null;
        $dados['proposta'] = $this->render('@app/modules/comercial/views/contrato/_lista_proposta', ['cod_cliente' => $contrato->cod_cliente_fk, 'form' => $form, 'msg' => $msgs]);
        $dados['contrato'] = $this->render('@app/modules/comercial/views/contrato/_lista_contratos', ['cod_cliente' => $contrato->cod_cliente_fk, 'form' => $form, 'msg' => $msgs]);

        return \yii\helpers\Json::encode($dados);
    }

    public function actionIncluirProposta() {
        $post = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();

        try {

            $contrato = new \app\modules\comercial\models\TabContratoSearch();
            $contrato->status = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('status-contrato', '1');
            $contrato->tipo_contrato_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contrato', 'proposta');
            $contrato->cod_cliente_fk = $post['TabClienteSearch']['cod_cliente'];
            $contrato->save();
            $servico = new \app\modules\comercial\models\TabTipoContratoSearch();
            $servico->cod_usuario_fk = $post['TabPropostaSearch']['cod_usuario_fk'];
            $servico->cod_contrato_fk = $contrato->cod_contrato;
            $servico->tipo_produto_fk = $post['TabPropostaSearch']['tipo_produto_fk'];
            $servico->save();

            $setor = new \app\models\TabSetoresSearch();
            $setor->cod_tipo_contrato_fk = $servico->cod_tipo_contrato;
            $setor->cod_usuario_responsavel_fk = $post['TabPropostaSearch']['cod_usuario_fk'];
            $setor->cod_tipo_setor_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('setores', '1');
            $setor->save();


            $andam = new \app\models\TabAndamentoSearch();
            $andam->txt_notificacao = 'Inclusão de proposta';
            $andam->cod_usuario_inclusao_fk = $this->user->identity->getId();
            $andam->cod_setor_fk = $setor->cod_setor;
            $andam->dt_retorno = date('d/m/Y', strtotime(date('Y-m-d') . '+5 days'));
            $andam->save();

            $transaction->commit();


            $msg = 'Proposta incluída com sucesso';

            $msgs['tipo'] = 'success';
            $msgs['msg'] = $msg;
            $msgs['icon'] = 'check';

            $form = \yii\widgets\ActiveForm::begin();
            $this->module->module->layout = null;
            $dados = $this->render('@app/modules/comercial/views/contrato/_lista_proposta', ['cod_cliente' => $contrato->cod_cliente_fk, 'form' => $form, 'msg' => $msgs]);

            return \yii\helpers\Json::encode($dados);
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function actionIncluirImportacao() {
        $post = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();

        try {

            $contrato = new \app\modules\comercial\models\TabContratoSearch();
            $contrato->status = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('status-contrato', '1');
            $contrato->tipo_contrato_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contrato', 'proposta');
            $contrato->cod_cliente_fk = $post['TabClienteSearch']['cod_cliente'];
            $contrato->file = $post['TabImportacaoSearch']['file'];

            print_r($_FILES);

            print_r($dados);
            exit;
            $contrato->save();
            $servico = new \app\modules\comercial\models\TabTipoContratoSearch();
            $servico->cod_usuario_fk = $post['TabPropostaSearch']['cod_usuario_fk'];
            $servico->cod_contrato_fk = $contrato->cod_contrato;
            $servico->tipo_produto_fk = $post['TabPropostaSearch']['tipo_produto_fk'];
            $servico->save();

            $setor = new \app\models\TabSetoresSearch();
            $setor->cod_tipo_contrato_fk = $servico->cod_tipo_contrato;
            $setor->cod_usuario_responsavel_fk = $post['TabPropostaSearch']['cod_usuario_fk'];
            $setor->cod_tipo_setor_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('setores', '1');
            $setor->save();


            $andam = new \app\models\TabAndamentoSearch();
            $andam->txt_notificacao = 'Inclusão de proposta';
            $andam->cod_usuario_inclusao_fk = $this->user->identity->getId();
            $andam->cod_setor_fk = $setor->cod_setor;
            $andam->dt_retorno = date('d/m/Y', strtotime(date('Y-m-d') . '+5 days'));
            $andam->save();

            $transaction->commit();


            $msg = 'Proposta incluída com sucesso';

            $msgs['tipo'] = 'success';
            $msgs['msg'] = $msg;
            $msgs['icon'] = 'check';

            $form = \yii\widgets\ActiveForm::begin();
            $this->module->module->layout = null;
            $dados = $this->render('@app/modules/comercial/views/contrato/_lista_proposta', ['cod_cliente' => $contrato->cod_cliente_fk, 'form' => $form, 'msg' => $msgs]);

            return \yii\helpers\Json::encode($dados);
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

}
