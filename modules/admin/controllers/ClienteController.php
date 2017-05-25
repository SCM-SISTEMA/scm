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
                if ($endereco) {
                    foreach ($endereco as $key => $value) {

                        if (strpos($value['cod_endereco'], 'novo') !== false) {
                            $value['cod_endereco'] = null;
                            $modelEnd = new \app\models\TabEnderecoSearch();
                            $modelEnd->attributes = $value;
                            $modelEnd->chave_fk = $modelEnd->save();
                        }
                    }
                }

                if ($contato) {
                    foreach ($contato as $key => $value) {

                        if (strpos($value['cod_endereco'], 'novo') !== false) {
                            $value['cod_contato'] = null;
                            $modelCon = new \app\models\TabEnderecoSearch();
                            $modelCon->attributes = $value;
                            $modelCon->save();
                        }
                    }
                }

                print_r($model->attributes);
                exit;

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
            $model->ativo = (($post['TabContatoSearch']['ativo'] === '0') ? '0' : '1');
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

            $itens[$model->cod_contato] = $model->attributes + ['contato_email' => $model->contato_email];
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


        $transaction = Yii::$app->db->beginTransaction();
        try {
            for ($row = 2; $row <= $highestRow; ++$row) {


                $rowDatas = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                $cliente = TabClienteSearch::findOne(['cnpj' => $rowDatas[0][2]]);
                if (!$cliente) {
                    $cliente = new TabClienteSearch();
                    $cliente->cod_cliente = $rowDatas[0][0];
                    $cliente->cnpj = $rowDatas[0][2];
                }
                $cliente->razao_social = $rowDatas[0][1];
                $cliente->setScenario('admin');
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

                $cliente->responsavel = $rowDatas[0][5];

                if (trim($rowDatas[0][5])) {
                    $contato = \app\models\TabContatoSearch::find()->where(['contato' => strtolower($rowDatas[0][5]), 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();
                    if (!$contato) {

                        $contato = new \app\models\TabContatoSearch;
                        $contato->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'S');
                        $contato->contato = strtolower($rowDatas[0][5]);
                        $contato->tipo_tabela_fk = $cliente->tableName();
                        $contato->chave_fk = $cliente->cod_cliente;
                        $contato->save();
                        print_r($contato->attributes);
                        exit;
                    }
                }
                $rowData[] = $rowDatas;
                print_r('sdaf');
                exit;
                if ($row == 600) {
                    break;
                }

                $transaction->rollBack();

                $this->session->setFlashProjeto('success', 'create');

                return $this->redirect(['update', 'id' => $sici->cod_sici]);
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            $this->session->setFlash('danger', 'Erro na importação - ' . $e->getMessage());
        }


        return compact('cliente');
    }

}
