<?php

namespace app\modules\comercial\controllers;

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

        $searchModel = new \app\modules\comercial\models\ViewClienteContratoSearch();
        if(!Yii::$app->request->queryParams){
            
            $query['ViewClienteContratoSearch']['txt_login'] = $this->user->identity->txt_login;
        }else{
            $query = Yii::$app->request->queryParams;
        }
        //$this->dd($query);
        $dataProvider = $searchModel->search($query);

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

    public function montaArrayContratos($contrato = []) {
        if ($contrato) {
            foreach ($contrato as $cont) {

                $tipo_contrato = \app\modules\comercial\models\TabTipoContratoSearch::find()->where(['cod_contrato_fk' => $cont->cod_contrato])->all();

                $tipo_contratos = null;
                if ($tipo_contrato) {
                    foreach ($tipo_contrato as $tp_cont) {
//                        $andamento[$tp_cont->cod_tipo_contrato] = \app\models\TabAndamentoSearch::findAllAsArray([
//                                    'cod_assunto_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-assunto-notificacao', '1'),
//                                    'cod_tipo_contrato_fk' => $tp_cont->cod_tipo_contrato,
//                                    'cod_modulo_fk' => '1']);

                        $tipo_contratos[] = $tp_cont->attributes;
                    }
                }

                /*  if (!$cont->isNewRecord) {

                  $andamento['contrato'] = \app\models\TabAndamentoSearch::find()->where([
                  'cod_assunto_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-assunto-notificacao', '1'),
                  'cod_contrato_fk' => $cont->cod_contrato,
                  'cod_modulo_fk' => \app\modules\admin\models\TabModulosSearch::find()->where(['id' => Yii::$app->controller->module->id])->one()->cod_modulo])->asArray()->orderBy('cod_andamento desc')->all();
                  }
                 */
                $parcelas = \app\modules\comercial\models\TabContratoParcelasSearch::find()->where(['cod_contrato_fk' => $cont->cod_contrato])->asArray()->orderBy('numero')->all();
                $contratos[] = ['attributes' => $cont->attributes, 'tipo_contratos' => $tipo_contratos, 'parcelas' => $parcelas, 'andamentos' => $andamento];
            }
        }

        return $contratos;
    }

    /**
     * Creates e Updates a new TabCliente  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdmin($id = null, $migrar = null) {
         
        if ($id) {

            $model = $this->findModel($id);
            $contrato = \app\modules\comercial\models\TabContratoSearch::find()->where(['cod_cliente_fk' => $model->cod_cliente, 'ativo' => true])->all();
            $contato = \app\models\TabContatoSearch::find()->where(['chave_fk' => $model->cod_cliente, 'tipo_tabela_fk' => $model->tableName()])->indexBy('cod_contato')->asArray()->all();
            $endereco = \app\models\TabEnderecoSearch::find()->where(['chave_fk' => $model->cod_cliente, 'tipo_tabela_fk' => $model->tableName()])->indexBy('cod_endereco')->asArray()->all();

            $contratos = $this->montaArrayContratos($contrato);

            $acao = 'update';
            $this->titulo = 'Alterar Cliente';
            $this->subTitulo = '';
        } else {

            $acao = 'create';
            $model = new TabClienteSearch();
            $cont = new \app\modules\comercial\models\TabContratoSearch();
            $tipo_contratos = new \app\modules\comercial\models\TabTipoContratoSearch();
            $cont->cod_contrato = 'N_' . rand(100000000, 999999999);
            $contratos = [];

            $this->titulo = 'Incluir Cliente';
            $this->subTitulo = '';
        }


        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $post = Yii::$app->request->post();

                $endereco = \Yii::$app->session->get('endereco');
                $contato = \Yii::$app->session->get('contato');
                
                if ($model->save()) {

                    if ($endereco) {
                        \app\models\TabEnderecoSearch::salvarEnderecos($endereco, $model);
                        
                    }
                    if ($contato) {

                        \app\models\TabContatoSearch::salvarContatos($contato, $model);
                    }
                

                    $transaction->commit();
                    $this->session->setFlashProjeto('success', $acao);
                    return $this->redirect(['admin', 'id' => $model->cod_cliente]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        } else {

            \Yii::$app->session->set('endereco', []);
            \Yii::$app->session->set('contato', []);
            \Yii::$app->session->set('contratos', []);
        }

        \Yii::$app->session->set('endereco', $endereco);
        \Yii::$app->session->set('contato', $contato);
        \Yii::$app->session->set('contratos', $contratos);

        return $this->render('admin', [
                    'model' => $model, 'contratos' => $contratos
        ]);
    }

    /**
     * Creates a new TabCliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionMigrar($id, $migrar) {

        if ($migrar & $migrar != $id) {
            $cliente = \app\models\TabClienteSearch::find()->where(['cod_cliente' => $migrar])->one();

            $contato = \app\models\TabContatoSearch::find()->where(['chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->all();
            $endereco = \app\models\TabEnderecoSearch::find()->where(['chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->all();
            $contrato = \app\modules\comercial\models\TabContratoSearch::find()->where(['cod_cliente_fk' => $migrar])->all();

            $cli = \app\models\TabClienteSearch::find()->where(['cod_cliente' => $id])->one();
            $cli->responsavel = ($cliente->responsavel) ? $cliente->responsavel : $cli->responsavel;
            $cli->save();
            if ($contrato) {
                foreach ($contrato as $value) {
                    $value->cod_cliente_fk = $id;
                    $value->save();
                }
            }$conts = \Yii::$app->session->get('contratos');
            if ($contato) {
                foreach ($contato as $value) {
                    $value->chave_fk = $id;
                    $value->save();
                }
            }

            if ($endereco) {
                foreach ($endereco as $value) {
                    $value->chave_fk = $id;
                    $value->save();
                }
            }
        }

        $cliente->delete();
        return $this->redirect(['admin', 'id' => $id, 'migrar' => $migrar]);
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
        $model->dt_exclusao = date('d/m/Y');
        $model->situacao = false;

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
        if (($model = TabClienteSearch::findOne($id)) !== null) {
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
            $str = 'Alteração';

            $model->municipio = \app\models\TabMunicipiosSearch::findOneAsArray(['cod_municipio' => $model->cod_municipio_fk])['txt_nome'];
        } else {

            $model = new \app\models\TabEnderecoSearch();
            $model->load($post);
            $model->cod_endereco = 'novo-' . rand('100000000', '999999999');
            $model->uf = $post['TabEnderecoSearch']['uf'];
            $model->ativo = 1;
            $str = 'Inclusão';

            $model->municipio = \app\models\TabMunicipiosSearch::findOneAsArray(['cod_municipio' => $model->cod_municipio_fk])['txt_nome'];
        }

        $model->setScenario('criar');
        $model->validate();

        if ($model && $model->getErrors()) {
            $dados = $model->getErrors();
        } else {

            $itens[$model->cod_endereco] = $model->attributes + ['uf' => $model->uf, 'municipio' => $model->municipio];
            \Yii::$app->session->set('endereco', $itens);


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
            $model->ativo = (($post['TabContatoSearch']['ativo'] === '0') ? '0' : '1');
            $str = 'Alteração';
        } else {

            $model = new \app\models\TabContatoSearch();
            $model->load($post);
            $model->tipo = $post['TabContatoSearch']['tipo'];
            $model->cod_contato = 'novo-' . rand('100000000', '999999999');
            $model->contato_email = $post['TabContatoSearch']['contato_email'];
            $model->ativo = 1;
            $str = 'Inclusão';
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

            $itens[$model->cod_contato] = $model->attributes + ['contato_email' => $model->contato_email];
            \Yii::$app->session->set('contato', $itens);

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

    /**
     * Creates a new TabSici model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionImportar() {
        $model = new TabClienteSearch();
        $this->titulo = 'Importar planilha de Clientes';
        $this->subTitulo = '';
        $importacao = [];
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $dados = \yii\web\UploadedFile::getInstance($model, 'file');

            if (array_key_exists('importar', Yii::$app->request->post())) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $post = Yii::$app->request->post();
                    $sici = new TabSiciSearch();

                    $cliente = new \app\models\TabClienteSearch;

                    unset($post['TabSiciSearch']['cod_sici']);
                    $sici->attributes = $post['TabSiciSearch'];

                    $cliente->attributes = $post['TabClienteSearch'];

                    $cli = \app\models\TabClienteSearch::findOne(['cnpj' => $cliente->cnpj]);

                    $contatoT = new \app\models\TabContatoSearch;
                    $contatoT->attributes = $post['TabContatoSearchT'];

                    $contatoC = new \app\models\TabContatoSearch;
                    $contatoC->attributes = $post['TabContatoSearchC'];

                    if (!$cli) {
                        $cliente->buscaCliente();
                        $cliente->save();

                        $contrato = new \app\modules\comercial\models\TabContratoSearch();
                        $contrato->cod_cliente_fk = $cliente->cod_cliente;
                        $contrato->save();
                        $tipo_contrato = new \app\modules\comercial\models\TabTipoContrato();
                        $tipo_contrato->cod_contrato_fk = $contrato->cod_contrato;
                        $tipo_contrato->save();
                        $sici->cod_tipo_contrato_fk = $tipo_contrato->cod_tipo_contrato;
                        $sici->save();

                        if ($cliente->dadosReceita->email) {
                            $contato = new \app\models\TabContatoSearch;
                            $contato->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'E');
                            $contato->contato = $cliente->dadosReceita->email;
                            $contato->tipo_tabela_fk = $cliente->tableName();
                            $contato->chave_fk = $cliente->cod_cliente;
                            $contato->save();
                        }

                        if ($cliente->dadosReceita->telefone) {
                            $contato = new \app\models\TabContatoSearch;
                            $contato->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T');
                            $contato->contato = str_replace(' ', '', $cliente->dadosReceita->telefone);
                            $contato->tipo_tabela_fk = $cliente->tableName();
                            $contato->chave_fk = $cliente->cod_cliente;
                            $contato->save();
                        }

                        if (\projeto\Util::retiraCaracter($contato->contato) != \projeto\Util::retiraCaracter($contatoT->contato)) {
                            $contatoT->tipo_tabela_fk = $cliente->tableName();
                            $contatoT->chave_fk = $cliente->cod_cliente;
                            $contatoT->save();
                        }
                        if (\projeto\Util::retiraCaracter($contato->contato) != \projeto\Util::retiraCaracter($contatoC->contato)) {

                            $contatoC->tipo_tabela_fk = $cliente->tableName();
                            $contatoC->chave_fk = $cliente->cod_cliente;
                            $contatoC->save();
                        }

                        if ($cliente->dadosReceita->logradouro) {
                            $endereco = new \app\models\TabEnderecoSearch();
                            $endereco->logradouro = $cliente->dadosReceita->logradouro;
                            $endereco->cep = $cliente->dadosReceita->cep;
                            $endereco->complemento = $cliente->dadosReceita->complemento;
                            $endereco->numero = $cliente->dadosReceita->numero;
                            $endereco->bairro = $cliente->dadosReceita->bairro;
                            $endereco->buscaCep();
                            $endereco->tipo_tabela_fk = $cliente->tableName();
                            $endereco->chave_fk = $cliente->cod_cliente;


                            if (!$endereco->dadosCep->ibge) {

                                $nome = strtoupper(\projeto\Util::tirarAcentos($cliente->dadosReceita->municipio));

                                $uf = null;
                                if ($cliente->dadosReceita->uf) {
                                    $uf = "AND sgl_estado_fk='{$cliente->dadosReceita->uf}'";
                                }

                                $municipio = \app\models\TabMunicipiosSearch::find()->where("(upper(txt_nome) ilike '%" . $nome . "%' or upper(txt_nome) ilike '%" . strtoupper($cliente->dadosReceita->municipio) . "%') $uf")->asArray()->one();

                                if ($municipio) {
                                    $endereco->cod_municipio_fk = $municipio['cod_municipio'];
                                }
                            } else {
                                $endereco->cod_municipio_fk = substr($endereco->dadosCep->ibge, 0, 6);
                            }
                            $endereco->save();
                        }
                    } else {
                        $cliente = $cli;

                        $contrato = \app\modules\comercial\models\TabContratoSearch::find()->where(['cod_cliente_fk' => $cliente->cod_cliente])->one();

                        $tipo_contrato = \app\modules\comercial\models\TabTipoContrato::find()->where(['cod_contrato_fk' => $contrato->cod_contrato])->one();

                        $sici->cod_tipo_contrato_fk = $tipo_contrato->cod_tipo_contrato;
                        $sici->save();

                        $contato = \app\models\TabContatoSearch::find()->where(['contato' => $post['TabContatoSearchT']['contato'], 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();

                        if (!$contato) {
                            $contatoT->tipo_tabela_fk = $cliente->tableName();
                            $contatoT->chave_fk = $cliente->cod_cliente;
                            $contatoT->save();
                        }

                        $contato = \app\models\TabContatoSearch::find()->where(['contato' => $post['TabContatoSearchC']['contato'], 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();
                        if (!$contato) {

                            $contatoC->tipo_tabela_fk = $cliente->tableName();
                            $contatoC->chave_fk = $cliente->cod_cliente;
                            $contatoC->save();
                        }
                    }


                    $planof = new \app\modules\posoutorga\models\TabPlanosSearch();
                    $planof_mn = new \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch();

                    $planoj = new \app\modules\posoutorga\models\TabPlanosSearch();
                    $planoj_mn = new \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch();

                    $planof->attributes = Yii::$app->request->post()['TabPlanosF'];
                    $planof->tipo_tabela_fk = $sici->tableName();
                    $planof->cod_chave = $sici->cod_sici;
                    $planof->save();

                    $planof_mn->attributes = Yii::$app->request->post()['TabPlanosMenorMaiorF'];
                    $planof_mn->cod_sici_fk = $sici->cod_sici;
                    $planof_mn->save();

                    $planoj->attributes = Yii::$app->request->post()['TabPlanosJ'];
                    $planoj->tipo_tabela_fk = $sici->tableName();
                    $planoj->cod_chave = $sici->cod_sici;
                    $planoj->save();

                    $planoj_mn->attributes = Yii::$app->request->post()['TabPlanosMenorMaiorJ'];
                    $planoj_mn->cod_sici_fk = $sici->cod_sici;
                    $planoj_mn->save();

                    $municipios = \Yii::$app->session->get('empresasSessao');
                    if ($municipios) {
                        foreach ($municipios as $municipio) {

                            $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
                            $empresa->attributes = $municipio[0];

                            $empresa->cod_sici_fk = $sici->cod_sici;
                            $empresa->save();

                            $planof_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                            unset($municipio[1]['cod_plano']);
                            $planof_municipio->attributes = $municipio[1];
                            $planof_municipio->tipo_tabela_fk = $empresa->tableName();
                            $planof_municipio->cod_chave = $empresa->cod_empresa_municipio;
                            $planof_municipio->save();

                            $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                            unset($municipio[2]['cod_plano']);
                            $planoj_municipio->attributes = $municipio[2];
                            $planoj_municipio->tipo_tabela_fk = $empresa->tableName();
                            $planoj_municipio->cod_chave = $empresa->cod_empresa_municipio;
                            $planoj_municipio->save();
                        }
                    }
                    //$sici->mes_ano_referencia = $dados_sici['mes_ano_referencia'];
                    $transaction->commit();

                    $this->session->setFlashProjeto('success', 'create');

                    return $this->redirect(['update', 'id' => $sici->cod_sici]);
                } catch (Exception $e) {

                    $transaction->rollBack();
                    $this->session->setFlash('danger', 'Erro na importação - ' . $e->getMessage());
                }
//$municipios = \Yii::$app->session->get('dados');
            } else {

                $importacao = $this->importExcel($dados->tempName, Yii::$app->request->post()['TabClienteSearch']);
                ;
            }
        } else {
            \Yii::$app->session->set('empresasSessao', null);
            $model->setScenario('importar');
        }
        return $this->render('importar', [
                    'model' => $model,
                    'importacao' => $importacao
        ]);
    }

    public function importExcel($inputFiles, $post) {
        ini_set('memory_limit', '512M');
        $arr_dados = [];
        try {
            $inputFileType = \PHPExcel_IOFactory::identify($inputFiles);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFiles);
        } catch (Exception $ex) {
            die('Error');
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();



        try {
            for ($row = 2; $row <= $highestRow; ++$row) {


                $rowDatas = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                $cliente = TabClienteSearch::findOne(['cnpj' => trim($rowDatas[0][2])]);
                if (!$cliente && $rowDatas[0][2]) {
                    $transaction = Yii::$app->db->beginTransaction();

                    $cliente = new TabClienteSearch();
                    $cliente->cod_cliente = $rowDatas[0][0];
                    $cliente->cnpj = $rowDatas[0][2];
                    $cliente->razao_social = $rowDatas[0][1];
                    $cliente->fantasia = $rowDatas[0][1];
                    $cliente->responsavel = $rowDatas[0][5];

                    $cliente->buscaCliente();
                    if (!$cliente->fantasia)
                        $cliente->fantasia = $cliente->razao_social;
                    $cliente->save(false);

                    $emails = explode(';', str_replace(';', ';', str_replace(',', ';', $rowDatas[0][3])));
                    if ($emails) {
                        foreach ($emails as $email) {

                            $contato = \app\models\TabContatoSearch::find()->where(['contato' => strtolower($email), 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();
                            if (!$contato) {
                                $contato = new \app\models\TabContatoSearch;
                                $contato->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'E');
                                $contato->contato = strtolower($email);
                                $contato->tipo_tabela_fk = $cliente->tableName();
                                $contato->chave_fk = $cliente->cod_cliente;
                                $contato->save();
                            }
                        }
                    }


                    $contatosT = explode(';', str_replace('/', ';', str_replace(':', ';', str_replace(',', ';', $rowDatas[0][4]))));

                    if ($contatosT) {
                        foreach ($contatosT as $contatos) {
                            $tel = trim($contatos);

                            $contato = \app\models\TabContatoSearch::find()->where(['contato' => strtolower($contatos), 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();
                            if (!$contato) {
                                $contato = new \app\models\TabContatoSearch;
                                $contato->tipo = ($tel[0] == 8 || $tel[0] == 9) ? \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C') : \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T');
                                $contato->contato = strtolower($tel);
                                $contato->tipo_tabela_fk = $cliente->tableName();
                                $contato->chave_fk = $cliente->cod_cliente;
                                $contato->save();
                            }
                        }
                    }



                    if (trim($rowDatas[0][6])) {
                        $contato = \app\models\TabContatoSearch::find()->where(['contato' => strtolower($rowDatas[0][6]), 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();
                        if (!$contato) {

                            $contato = new \app\models\TabContatoSearch;
                            $contato->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'S');
                            $contato->contato = strtolower($rowDatas[0][6]);
                            $contato->tipo_tabela_fk = $cliente->tableName();
                            $contato->chave_fk = $cliente->cod_cliente;
                            $contato->save();
                        }
                    }


                    if ($cliente->dadosReceita) {
                        foreach ($cliente->dadosReceita->atividade_principal as $value) {
                            $atividade = new \app\models\TabAtividadeSearch();
                            $atividade->descricao = $value->text;
                            $atividade->codigo = $value->code;
                            $atividade->primario = true;
                            $atividade->cod_cliente_fk = $cliente->cod_cliente;
                            $atividade->save();
                        }
                        if ($cliente->dadosReceita->atividades_secundarias) {
                            foreach ($cliente->dadosReceita->atividades_secundarias as $value) {
                                $atividade = new \app\models\TabAtividadeSearch();
                                $atividade->descricao = $value->text;
                                $atividade->codigo = $value->code;
                                $atividade->primario = false;
                                $atividade->cod_cliente_fk = $cliente->cod_cliente;
                                $atividade->save();
                            }
                        }


                        if ($cliente->dadosReceita->qsa) {
                            foreach ($cliente->dadosReceita->qsa as $value) {
                                $socio = new \app\modules\comercial\models\TabSociosSearch();
                                $socio->qual = $value->qual;
                                $socio->nome = $value->nome;
                                $socio->cod_cliente_fk = $cliente->cod_cliente;
                                $socio->save();
                            }
                        }
                        $cliente->natureza_juridica = $cliente->dadosReceita->natureza_juridica;
                        $cliente->razao_social = $cliente->dadosReceita->nome;
                        $cliente->fantasia = $cliente->dadosReceita->fantasia;

                        if ($cliente->dadosReceita->email) {
                            $contato = \app\models\TabContatoSearch::find()->where(['contato' => $cliente->dadosReceita->email, 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();
                            if (!$contato) {
                                $contato = new \app\models\TabContatoSearch;
                                $contato->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'E');
                                $contato->contato = $cliente->dadosReceita->email;
                                $contato->tipo_tabela_fk = $cliente->tableName();
                                $contato->chave_fk = $cliente->cod_cliente;
                                $contato->save();
                            }
                        }
                        if ($cliente->dadosReceita->telefone) {
                            $contato = \app\models\TabContatoSearch::find()->where(['contato' => $cliente->dadosReceita->telefone, 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();
                            if (!$contato) {
                                $contato = new \app\models\TabContatoSearch;
                                $contato->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T');
                                $contato->contato = str_replace(' ', '', $cliente->dadosReceita->telefone);
                                $contato->tipo_tabela_fk = $cliente->tableName();
                                $contato->chave_fk = $cliente->cod_cliente;
                                $contato->save();
                            }
                        }


                        if ($cliente->dadosReceita->logradouro) {
                            $endereco = \app\models\TabEnderecoSearch::find()->where(['logradouro' => $cliente->dadosReceita->logradouro, 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();
                            if (!$endereco) {
                                $endereco = new \app\models\TabEnderecoSearch();
                                $endereco->logradouro = $cliente->dadosReceita->logradouro;
                                $endereco->cep = $cliente->dadosReceita->cep;
                                $endereco->complemento = $cliente->dadosReceita->complemento;
                                $endereco->numero = $cliente->dadosReceita->numero;
                                $endereco->bairro = $cliente->dadosReceita->bairro;
                                $endereco->buscaCep();
                                $endereco->tipo_tabela_fk = $cliente->tableName();
                                $endereco->chave_fk = $cliente->cod_cliente;


                                if (!$endereco->dadosCep->ibge) {

                                    $nome = trim(strtoupper(\projeto\Util::tirarAcentos($rowDatas[0][11])));
                                    $uf = null;
                                    if (trim($rowDatas[0][12])) {
                                        $uf = "AND sgl_estado_fk='" . strtoupper(trim($rowDatas[0][12])) . "'";
                                    }

                                    $municipio = \app\models\TabMunicipiosSearch::find()->where("(upper(txt_nome_sem_acento) ilike $$%" . $nome . "%$$ or upper(txt_nome) ilike $$%" . $nome . "%$$ or upper(txt_nome) ilike $$%" . strtoupper($rowDatas[0][11]) . "%$$) $uf")->asArray()->one();

                                    if ($municipio) {
                                        $endereco->cod_municipio_fk = $municipio['cod_municipio'];
                                    }
                                } else {

                                    $endereco->cod_municipio_fk = substr($endereco->dadosCep->ibge, 0, 6);
                                }
                                if ($endereco->validate()) {
                                    $endereco->save();
                                }
                            }
                        }
                    } else {
                        $endereco = new \app\models\TabEnderecoSearch();
                        $endereco->logradouro = $rowDatas[0][9];
                        $endereco->cep = $rowDatas[0][13];
                        $endereco->bairro = $rowDatas[0][10];
                        $endereco->buscaCep();
                        $endereco->tipo_tabela_fk = $cliente->tableName();
                        $endereco->chave_fk = $cliente->cod_cliente;


                        if (!$endereco->dadosCep->ibge) {

                            $nome = trim(strtoupper(\projeto\Util::tirarAcentos($rowDatas[0][11])));
                            $uf = null;
                            if (trim($rowDatas[0][12])) {
                                $uf = "AND sgl_estado_fk='" . strtoupper(trim($rowDatas[0][12])) . "'";
                            }
                            $municipio = \app\models\TabMunicipiosSearch::find()->where("(upper(txt_nome_sem_acento) ilike $$%" . $nome . "%$$ or upper(txt_nome) ilike $$%" . $nome . "%$$ or upper(txt_nome) ilike $$%" . strtoupper($rowDatas[0][11]) . "%$$) $uf")->asArray()->one();

                            if ($municipio) {
                                $endereco->cod_municipio_fk = $municipio['cod_municipio'];
                            }
                        } else {

                            $endereco->cod_municipio_fk = substr($endereco->dadosCep->ibge, 0, 6);
                        }
                        if ($endereco->validate()) {
                            $endereco->save();
                        }
                    }

                    $cliente->save();

                    $transaction->commit();
                } else {
                    if ($cliente) {
                        $endereco = \app\models\TabEnderecoSearch::find()->where(['chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();

                        if (!$endereco) {
                            $cliente->buscaCliente();

                            if ($cliente->dadosReceita->logradouro) {
                                $transaction = Yii::$app->db->beginTransaction();

                                $endereco = new \app\models\TabEnderecoSearch();
                                $endereco->logradouro = $cliente->dadosReceita->logradouro;
                                $endereco->cep = $cliente->dadosReceita->cep;
                                $endereco->complemento = $cliente->dadosReceita->complemento;
                                $endereco->numero = $cliente->dadosReceita->numero;
                                $endereco->bairro = $cliente->dadosReceita->bairro;
                                $endereco->buscaCep();
                                $endereco->tipo_tabela_fk = $cliente->tableName();
                                $endereco->chave_fk = $cliente->cod_cliente;


                                if (!$endereco->dadosCep->ibge) {

                                    $nome = strtoupper(\projeto\Util::tirarAcentos($cliente->dadosReceita->municipio));

                                    $uf = null;
                                    if ($cliente->dadosReceita->uf) {
                                        $uf = "AND sgl_estado_fk='{$cliente->dadosReceita->uf}'";
                                    }

                                    $municipio = \app\models\TabMunicipiosSearch::find()->where("(upper(txt_nome) ilike '%" . $nome . "%' or upper(txt_nome) ilike '%" . strtoupper($cliente->dadosReceita->municipio) . "%') $uf")->asArray()->one();

                                    if ($municipio) {
                                        $endereco->cod_municipio_fk = $municipio['cod_municipio'];
                                    }
                                } else {
                                    $endereco->cod_municipio_fk = substr($endereco->dadosCep->ibge, 0, 6);
                                }
                                $endereco->save();
                                $transaction->commit();
                            } else {
                                $transaction = Yii::$app->db->beginTransaction();

                                $endereco = new \app\models\TabEnderecoSearch();
                                $endereco->logradouro = $rowDatas[0][9];
                                $endereco->cep = $rowDatas[0][13];
                                $endereco->bairro = $rowDatas[0][10];
                                $endereco->buscaCep();
                                $endereco->tipo_tabela_fk = $cliente->tableName();
                                $endereco->chave_fk = $cliente->cod_cliente;

                                if (!$endereco->dadosCep->ibge) {

                                    $nome = strtoupper(\projeto\Util::tirarAcentos($cliente->dadosReceita->municipio));

                                    $uf = null;
                                    if ($cliente->dadosReceita->uf) {
                                        $uf = "AND sgl_estado_fk='{$cliente->dadosReceita->uf}'";
                                    }

                                    $municipio = \app\models\TabMunicipiosSearch::find()->where("(upper(txt_nome) ilike '%" . $nome . "%' or upper(txt_nome) ilike '%" . strtoupper($cliente->dadosReceita->municipio) . "%') $uf")->asArray()->one();

                                    if ($municipio) {
                                        $endereco->cod_municipio_fk = $municipio['cod_municipio'];
                                    }
                                } else {
                                    $endereco->cod_municipio_fk = substr($endereco->dadosCep->ibge, 0, 6);
                                }
                                $endereco->save();
                                $transaction->commit();
                            }
                        }
                    }
                    // $cliente->save();
                }
            }


            $this->session->setFlashProjeto('success', 'create');

            return $this->redirect(['importar']);
        } catch (Exception $e) {
            $transaction->rollBack();
            $this->session->setFlash('danger', 'Erro na importação - ' . $e->getMessage());
        }


        return compact('cliente');
    }

    public function actionVerificaCnpj() {

        $this->module->module->layout = null;
        $post = Yii::$app->request->post();

        $cliente = \app\models\TabClienteSearch::findOne(['cnpj' => $post['dados']]);

        if ($cliente) {

            return \yii\helpers\Json::encode(['cliente' => $cliente, 'existe' => true]);
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

    public function dadosCliente($cliente, &$grids) {

        if ($cliente->dadosReceita->email) {
            $emails = explode('/', $cliente->dadosReceita->email);
            foreach ($emails as $ema) {

                $contato = new \app\models\TabContatoSearch;
                $contato->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'E');
                $contato->contato = $ema;
                $contato->ativo = 1;
                $contato->cod_contato = 'novo-' . rand('100000000', '999999999');
                $contato->setScenario('email');
                $itens[$contato->cod_contato] = $contato->attributes + ['contato_email' => $ema];
            }
        }



        if ($cliente->dadosReceita->telefone) {
            $telefones = explode('/', $cliente->dadosReceita->telefone);
            foreach ($telefones as $tel) {

                $contato = new \app\models\TabContatoSearch;
                $contato->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T');
                $contato->contato = str_replace(' ', '', $tel);
                $contato->ativo = 1;
                $contato->cod_contato = 'novo-' . rand('100000000', '999999999');
                $contato->setScenario('telefone');
                $itens[$contato->cod_contato] = $contato->attributes + ['contato_email' => $contato->contato_email];
            }
        }

        \Yii::$app->session->set('contato', $itens);


        if ($cliente->dadosReceita->logradouro) {
            $itensE = [];
            $endereco = new \app\models\TabEnderecoSearch();
            $endereco->logradouro = $cliente->dadosReceita->logradouro;
            $endereco->cep = $cliente->dadosReceita->cep;
            $endereco->complemento = $cliente->dadosReceita->complemento;
            $endereco->uf = $cliente->dadosReceita->uf;
            $endereco->numero = $cliente->dadosReceita->numero;
            $endereco->bairro = $cliente->dadosReceita->bairro;
            $endereco->correspondencia = 1;
            $endereco->cod_endereco = 'novo-' . rand('100000000', '999999999');
            if ($endereco->cep) {
                $endereco->buscaCep();
            }

            if (!$endereco->dadosCep->ibge) {

                $nome = strtoupper(\projeto\Util::tirarAcentos($cliente->dadosReceita->municipio));

                $uf = null;
                if ($cliente->dadosReceita->uf) {
                    $uf = "AND sgl_estado_fk='{$cliente->dadosReceita->uf}'";
                }

                $municipio = \app\models\TabMunicipiosSearch::find()->where("(upper(txt_nome) ilike '%" . $nome . "%' or upper(txt_nome) ilike '%" . strtoupper($cliente->dadosReceita->municipio) . "%') $uf")->asArray()->one();

                if ($municipio) {
                    $endereco->cod_municipio_fk = $municipio['cod_municipio'];
                }
            } else {
                $endereco->cod_municipio_fk = substr($endereco->dadosCep->ibge, 0, 6);
            }

            $endereco->cod_endereco = 'novo-' . rand('100000000', '999999999');
            $endereco->ativo = 1;
            $endereco->municipio = \app\models\TabMunicipiosSearch::findOneAsArray(['cod_municipio' => $endereco->cod_municipio_fk])['txt_nome'];
            $itensE[$endereco->cod_endereco] = $endereco->attributes + ['uf' => $endereco->uf, 'municipio' => $endereco->municipio];

            \Yii::$app->session->set('endereco', $itensE);


            $grids = ['itens' => $itens, 'itensE' => $itensE];
        }
    }

    public function actionIncluirTipoContrato() {
        $this->module->module->layout = null;

        $contratoSessao = (\Yii::$app->session->get('contratos')) ? \Yii::$app->session->get('contratos') : [];
        $post = Yii::$app->request->post();

        if (strpos($post['TabTipoContratoSearchServico']['cod_contrato_fk'], 'N') === false) {
            $str = 'Inclusão';
            foreach ($contratoSessao as $key => $contrato) {

                if ($contrato['attributes']['cod_contrato'] == $post['TabTipoContratoSearchServico']['cod_contrato_fk']) {
                    $servico = new \app\modules\comercial\models\TabTipoContratoSearch();
                    //$servico->cod_tipo_contrato = 'N' . rand('100000000', '999999999');
                    $servico->attributes = $post['TabTipoContratoSearchServico'];
                    $servico->save();
                    if (!$contratoSessao[$key]['tipo_contratos']) {
                        $contratoSessao[$key]['tipo_contratos'] = [];
                    }
                    array_unshift($contratoSessao[$key]['tipo_contratos'], $servico->attributes);

                    $cont = $contratoSessao[$key];
                }
            }
        } else {
            $str = 'Alteração';
            foreach ($contratoSessao as $key => $contrato) {

                if ($contrato['attributes']['cod_contrato'] == $post['TabTipoContratoSearchServico']['cod_contrato_fk']) {
                    $servico = new \app\modules\comercial\models\TabTipoContratoSearch();
                    $servico->cod_tipo_contrato = 'N' . rand('100000000', '999999999');
                    $servico->attributes = $post['TabTipoContratoSearchServico'];

                    array_unshift($contratoSessao[$key]['tipo_contratos'], $servico->attributes);
                    $cont = $contratoSessao[$key];
                }
            }
        }

        \Yii::$app->session->set('contratos', $contratoSessao);
        $form = \yii\widgets\ActiveForm::begin();
        $contrato = $cont;


        if ($servico && $servico->getErrors()) {
            $dados = $servico->getErrors();
            $msgT['tipo'] = 'error';
            $msgT['msg'] = 'Erro na solicitacao.';
            $msgT['icon'] = 'check';
        } else {

            $msgT['tipo'] = 'success';
            $msgT['msg'] = $str . ' efetivada com sucesso.';
            $msgT['icon'] = 'check';
        }

        Yii::$app->controller->action->id = 'index';

        $dados = ['html' => $this->render('@app/modules/comercial/views/contrato/_guia_tipo_contrato', compact('form', 'contrato', 'msgT')), 'cod_contrato' => $post['TabTipoContratoSearchServico']['cod_contrato_fk']];

        return \yii\helpers\Json::encode($dados);
    }

    public function actionIncluirContrato() {
        Yii::$app->controller->action->id = 'index';

        $post = Yii::$app->request->post();

        if (!$post['TabContratoSearch']['cod_contrato']) {
            $transaction = Yii::$app->db->beginTransaction();

            try {

                $str = 'Inclusão';
                $contrato = new \app\modules\comercial\models\TabContratoSearch();
                unset($post['TabContratoSearch']['cod_contrato']);
                $contrato->attributes = $post['TabContratoSearch'];
                $contrato->status = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('status-contrato', '1');
                $contrato->cod_cliente_fk = $post['TabClienteSearch']['cod_cliente'];
                $contrato->save();


                $servicos = \app\modules\comercial\models\TabContratoTipoContrato::find()->where(['cod_contrato_fk' => $contrato->tipo_contrato_fk])->asArray()->all();
                $sers = [];

                if ($servicos) {
                    foreach ($servicos as $key => $ser) {

                        $servico = new \app\modules\comercial\models\TabTipoContratoSearch();

                        $servico->cod_usuario_fk = $post['TabTipoContratoSearch']['cod_usuario_fk'];
                        $servico->cod_contrato_fk = $contrato->cod_contrato;
                        $servico->tipo_produto_fk = $ser['cod_tipo_contrato_fk'];
                        $servico->save();

                        $setor = new \app\models\TabSetoresSearch();
                        $setor->cod_tipo_contrato_fk = $servico->cod_tipo_contrato;
                        $setor->cod_usuario_responsavel_fk = $post['TabTipoContratoSearch']['cod_usuario_fk'];
                        $setor->cod_tipo_setor_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('setores', '1');
                        $setor->save();

                        $andam = new \app\models\TabAndamentoSearch();
                        $andam->txt_notificacao = 'Fechamento de Contrato';
                        $andam->cod_usuario_inclusao_fk = $this->user->identity->getId();
                        $andam->cod_setor_fk = $setor->cod_setor;
                        $andam->dt_retorno = date('d/m/Y', strtotime(date('Y-m-d').'+5 days'));
                        $andam->save();
                    }
                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        } else {
            $str = 'Alteração';
            $contrato = \app\modules\comercial\models\TabContratoSearch::find()->where(['cod_contrato' => $post['TabContratoSearch']['cod_contrato']])->one();

            if ($contrato) {
                unset($post['TabContratoSearch']['cod_contrato']);
                                
                $post['TabContratoSearch']['valor_contrato'] = (strpos($post['TabContratoSearch']['cod_contrato'], ',') === false) ? $post['TabContratoSearch']['valor_contrato'] :
                \projeto\Util::decimalFormatForBank($post['TabContratoSearch']['valor_contrato']);
                                
                if (
                        $post['TabContratoSearch']['valor_contrato'] == $contrato->valor_contrato ||
                        $post['TabContratoSearch']['qnt_parcelas'] == $contrato->qnt_parcelas ||
                        $post['TabContratoSearch']['dt_vencimento'] == $contrato->dt_vencimento
                ) {
                    \app\modules\comercial\models\TabContratoParcelasSearch::atualizarParcelas($contrato->cod_contrato, $post['TabContratoSearch']);
                }
                
                $contrato->attributes = $post['TabContratoSearch'];
                
                $contrato->status = $post['TabContratoSearch']['status'];
                              
                $contrato->save();
            }
        }

        if ($contrato && $contrato->getErrors()) {
            $dados = $contrato->getErrors();
            $msg['tipo'] = 'error';
            $msg['msg'] = 'Erro na solicitacao.';
            $msg['icon'] = 'check';
        } else {

            $msg['tipo'] = 'success';
            $msg['msg'] = $str . ' efetivada com sucesso.';
            $msg['icon'] = 'check';
        }


        $form = \yii\widgets\ActiveForm::begin();
        $this->module->module->layout = null;
        $dados = $this->render('@app/modules/comercial/views/contrato/_lista_contratos', ['cod_cliente' => $post['TabClienteSearch']['cod_cliente'], 'form' => $form, 'msg' => $msg]);

        return \yii\helpers\Json::encode($dados);
    }


}
