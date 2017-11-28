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



        $contrato = \app\modules\comercial\models\ViewClienteContratoAll::find()->where(['cod_contrato' => $cod_contrato])->one();

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
            $contrato->tipo_contrato_fk = ($post['status'] == 2) ? $contrato->tipo_contrato_fk : $post['tipo_contrato'];
            if ($contrato->save()) {
                if ($post['status'] == 3) {
                    $msg = 'Contranto fechado';

                    $andam = new \app\models\TabAndamentoSearch();
                    $andam->txt_notificacao = 'Contrato fechado';
                    $andam->cod_usuario_inclusao_fk = $this->user->identity->getId();
                    $andam->cod_setor_fk = $post['setor'];
                    $andam->dt_retorno = date('d/m/Y', strtotime(date('Y-m-d') . '+5 days'));
                    $andam->save();
                } else{
                    $msg = 'Contranto recusado';
            
                    $andam = new \app\models\TabAndamentoSearch();
                    $andam->txt_notificacao = $msg;
                    $andam->cod_usuario_inclusao_fk = $this->user->identity->getId();
                    $andam->cod_setor_fk = $post['setor'];
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
            $contrato->cod_cliente_fk =  $post['TabClienteSearch']['cod_cliente'];
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
            $contrato->cod_cliente_fk =  $post['TabClienteSearch']['cod_cliente'];
            $contrato->file = $post['TabImportacaoSearch']['file'];
        
             print_r($_FILES);
             
print_r($dados); exit;
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

    
    
    
      public function importWord($inputFiles, $post) {
        ini_set('memory_limit', '512M');

        $xml = simplexml_load_file($inputFiles);
        print_r($xml); exit;
        $sici = new TabSiciSearch();

        $dom = new \DOMDocument();
        $dom->load($inputFiles);

        if ($dom->getElementsByTagName('UploadSICI')->item(0)->getAttribute('mes') == 1) {
            $anual = true;
            $sici->tipo_sici_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-sici', 'A');
        } elseif ($dom->getElementsByTagName('UploadSICI')->item(0)->getAttribute('mes') == '7') {
            $indicadores = true;
            $sici->tipo_sici_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-sici', 'S');
        } else {

            $sici->tipo_sici_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-sici', 'M');
        }
        $sici->mes_ano_referencia = $dom->getElementsByTagName('UploadSICI')->item(0)->getAttribute('mes') . '/' . $dom->getElementsByTagName('UploadSICI')->item(0)->getAttribute('ano');
        $outorga = $dom->getElementsByTagName('Outorga')->item(0);
        $fistel = $outorga->getAttribute('fistel');

        $cliente = \app\models\TabClienteSearch::findOne(['fistel' => $fistel]);
        $contrato = \app\modules\comercial\models\TabContratoSearch::findOne(['cod_cliente_fk' => $cliente->cod_cliente]);
        $tipo_contrato = \app\modules\comercial\models\TabTipoContratoSearch::findOne(['cod_contrato_fk' => $contrato->cod_contrato]);

        $sici->cod_tipo_contrato_fk = $tipo_contrato->cod_tipo_contrato;
        if (!$cliente) {
            $cliente = new \app\models\TabClienteSearch;
            $cliente->fistel = $fistel;
        }

        $planof = new \app\modules\posoutorga\models\TabPlanosSearch();
        $planoj = new \app\modules\posoutorga\models\TabPlanosSearch();

        $planof_mn = new \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch();
        $planoj_mn = new \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch();

        foreach ($outorga->getElementsByTagName('Indicador') as $indicador) {
            switch ($indicador->getAttribute('Sigla')) {
                case 'IEM4' : $sici->qtd_funcionarios_fichados = $indicador->getElementsByTagName('Conteudo')->item(0)->getAttribute('valor');
                    break;
                case 'IEM5' : $sici->qtd_funcionarios_terceirizados = $indicador->getElementsByTagName('Conteudo')->item(0)->getAttribute('valor');
                    break;
                case 'IEM9' : $planof->setIEM9($indicador, 'F');
                    $planoj->setIEM9($indicador, 'J');
                    break;
                case 'IEM10' : $planof_mn->setIEM10($indicador, 'F');
                    $planoj_mn->setIEM10($indicador, 'J');
                    break;
                case 'QAIPL4SM' :

                    foreach ($outorga->getElementsByTagName('Municipio') as $mun) {
                        if (!$mun->getAttribute('codmunicipio')) {
                            continue;
                        }
                        if ($mun->getElementsByTagName('Tecnologia')) {
                            foreach ($mun->getElementsByTagName('Tecnologia') as $tec) {


                                $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
                                $empresa->tecnologia_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tecnologia', $tec->getAttribute('item'));

                                $municipio = \app\models\TabMunicipiosSearch::find()->where("cod_municipio='" . substr(trim($mun->getAttribute('codmunicipio')), 0, 6) . "' OR cod_ibge='" . trim($mun->getAttribute('codmunicipio')) . "'")->asArray()->one();

                                $empresa->uf = $municipio['sgl_estado_fk'];
                                $empresa->cod_municipio_fk = $municipio['cod_municipio'];

                                $empresa->setQAIPL4SM($tec);

                                $empresa->cod_empresa_municipio = 'N_' . rand(100000000, 999999999);

                                if ((int) $empresa->total > 0) {
                                    $planos = new \app\modules\posoutorga\models\TabPlanosSearch();

                                    $empresasSessao[$empresa->cod_empresa_municipio] = [$empresa->attributes, $planos->attributes, $planos->attributes];
                                }
                            }
                        }
                    }
                    break;

                case 'IPL6IM' :


                    foreach ($indicador->getElementsByTagName('Conteudo') as $mun) {
                        $capacidades[$mun->getAttribute('codmunicipio')] = $mun->getAttribute('valor');
                    }
                    break;

                case 'IPL3' :

                    foreach ($indicador->getElementsByTagName('Municipio') as $mun) {
                        foreach ($mun->getElementsByTagName('Pessoa') as $pes) {
                            $ipl3[$mun->getAttribute('codmunicipio')][$pes->getAttribute('item')] = $pes->getElementsByTagName('Conteudo')->item(0)->getAttribute('valor');
                        }
                    }
                    break;


                case 'IAU1' :
                    $sici->num_central_atendimento = $indicador->getElementsByTagName('Conteudo')->item(0)->getAttribute('valor');
                    break;


                case 'IPL1' :

                    $sici->setIPL1($indicador);
                    break;
                case 'IPL2' :

                    $sici->setIPL2($indicador);
                    break;
                case 'IEM1' :

                    $sici->setIEM1($indicador);
                    break;
                case 'IEM2' :

                    $sici->setIEM2($indicador);
                    break;
                case 'IEM3' :
                    $sici->valor_consolidado = \projeto\Util::decimalFormatForBank($indicador->getElementsByTagName('Conteudo')->item(0)->getAttribute('valor'));

                    break;
                case 'IEM6' :

                    $sici->receita_bruta = \projeto\Util::decimalFormatForBank($indicador->getElementsByTagName('Conteudo')->item(0)->getAttribute('valor'));

                    break;
                case 'IEM7' :

                    $sici->receita_liquida = \projeto\Util::decimalFormatToBank($indicador->getElementsByTagName('Conteudo')->item(0)->getAttribute('valor'));
                    break;
                case 'IEM8' :
                    $sici->setIEM8($indicador);
                    break;
            }
        }


        foreach ($empresasSessao as $key => $emp) {
            $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
            $empresa->attributes = $emp[0];
            $empresa->cod_empresa_municipio = $emp[0]['cod_empresa_municipio'];

            foreach ($capacidades as $ckey => $cap) {


                if (substr($ckey, 0, 6) == $empresa->cod_municipio_fk) {
                    $empresa->capacidade_municipio = $cap;
                }
            }

            foreach ($ipl3 as $ikey => $ip) {

                if (substr($ikey, 0, 6) == $empresa->cod_municipio_fk) {
                    $empresa->total_fisica = $ip['F'];
                    $empresa->total_juridica = $ip['J'];
                }
            }

            $empresas[] = $empresa;
            $planos = new \app\modules\posoutorga\models\TabPlanosSearch();
            $planos->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');
            $arrayF = $planos->attributes;
            $arrayF['tipo_pessoa'] = 'Física';

            $planos->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');

            $arrayJ = $planos->attributes;
            $arrayJ['tipo_pessoa'] = 'Juridica';

            $totais = $empresa->calculaTotais($planos, $planos, false);
            $totais['tipo_pessoa'] = 'Totais';
            $totais['total'] = $empresa->total_fisica + $empresa->total_juridica;

            $arrayF['total'] = $empresa->total_fisica;
            $arrayJ['total'] = $empresa->total_juridica;

            $empresa->gridMunicipios[] = $arrayF;
            $empresa->gridMunicipios[] = $arrayJ;
            $empresa->gridMunicipios[] = $totais;


            $empresa->gridMunicipios = new \yii\data\ArrayDataProvider([
                'id' => 'grid_lista_acesso-' . $key,
                'allModels' => $empresa->gridMunicipios,
                'sort' => false,
                'pagination' => ['pageSize' => 10],
            ]);



            $empresasSessao[$empresa->cod_empresa_municipio] = [$empresa->attributes, $arrayF, $arrayJ];
        }

        $contatoC = \app\models\TabContatoSearch::find()
                ->where(['ativo' => true, 'tipo_tabela_fk' => $cliente->tableName(), 'chave_fk' => $cliente->cod_cliente, 'tipo' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C')])
                ->orderBy('cod_contato desc')
                ->one();

        if (!$contatoC)
            $contatoC = new \app\models\TabContatoSearch();


        $contatoT = \app\models\TabContatoSearch::find()
                ->where(['ativo' => true, 'tipo_tabela_fk' => $cliente->tableName(), 'chave_fk' => $cliente->cod_cliente, 'tipo' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C')])
                ->orderBy('cod_contato desc')
                ->one();

        if (!$contatoT)
            $contatoT = new \app\models\TabContatoSearch();
        \Yii::$app->session->set('empresasSessao', $empresasSessao);

        $cliente->validate();
        $sici->tipo_entrada_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-entrada', 'X');
        $sici->validate();
        $erro = [];
        if ($sici->errors) {
            foreach ($sici->errors as $value) {

                foreach ($value as $val) {
                    if (array_search($val, $erro) === false) {
                        $erro[] = $val;
                    }
                }
            }
        }

        if ($cliente->errors) {
            foreach ($cliente->errors as $value) {

                foreach ($value as $val) {
                    if (array_search($val, $erro) === false) {
                        $erro[] = $val;
                    }
                }
            }
        }
        if ($erro) {
            $this->session->setFlash('danger', 'Erro encontrados: <br/>' . implode('<br/>', $erro));
        }

        return compact('sici', 'cliente', 'contatoC', 'contatoT', 'planof', 'planof_mn', 'planoj', 'planoj_mn', 'empresas', 'anual', 'indicadores');
    }
}
