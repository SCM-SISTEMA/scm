<?php

namespace app\modules\posoutorga\controllers;

use Yii;
use app\modules\posoutorga\models\TabSici;
use app\modules\posoutorga\models\TabSiciSearch;
use projeto\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SiciController implements the CRUD actions for TabSici model.
 */
class SiciController extends Controller {

    /**
     * Lists all TabSici models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new \app\modules\posoutorga\models\VisSiciClienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->titulo = 'Lista SICI';
        $this->subTitulo = '';

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabSici model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $this->titulo = 'Lista SICI';
        $this->subTitulo = '';

        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates e Updates a new TabSici  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdmin($id = null) {

        if ($id) {

            $model = $this->findModel($id);
            $acao = 'update';
            $this->titulo = 'Alterar Sici';
            $this->subTitulo = '';
        } else {

            $acao = 'create';
            $model = new TabSici();
            $this->titulo = 'Incluir Sici';
            $this->subTitulo = '';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', $acao);
            return $this->redirect(['view', 'id' => $model->cod_sici]);
        }

        return $this->render('admin', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing TabSici model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCreate($cnpj = null, $mes = null) {
        $this->layout = null;
        $cnpj = \projeto\Util::retiraCaracter(trim($cnpj));
        $cnpj = str_pad($cnpj, 14, '0', 0);
        $cliente = \app\models\TabClienteSearch::find()->where("cnpj = '{$cnpj}' "
                        . " OR replace(replace(replace(cnpj, '.', ''), '-', ''), '/', '')='{$cnpj}'")->one();

        $cm = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-produto', 'CM');
        $cj = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-produto', 'CJ');
        $contrato = \app\modules\comercial\models\TabContratoSearch::find()->where("ativo is true and cod_cliente_fk = $cliente->cod_cliente")->one();
        $tipo_contrato = \app\modules\comercial\models\TabTipoContrato::find()->where("ativo is true and (tipo_produto_fk in ({$cm}, {$cj})) and cod_contrato_fk = $contrato->cod_contrato")->one();

        $sici = TabSiciSearch::find()->where("cod_tipo_contrato_fk = $tipo_contrato->cod_tipo_contrato "
                        . "and replace(mes_ano_referencia, '/', '')='{$mes}'")->one();

        if (!$sici) {
            $sici = new TabSiciSearch();
            $sici->mes_ano_referencia = $mes;
        }

        $contatoT = \app\models\TabContatoSearch::find()
                ->where(['ativo' => true, 'tipo_tabela_fk' => $cliente->tableName(), 'chave_fk' => $cliente->cod_cliente, 'tipo' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T')])
                ->orderBy('cod_contato desc')
                ->one();

        if (!$contatoT)
            $contatoT = new \app\models\TabContatoSearch();


        $contatoC = \app\models\TabContatoSearch::find()
                ->where(['ativo' => true, 'tipo_tabela_fk' => $cliente->tableName(), 'chave_fk' => $cliente->cod_cliente, 'tipo' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C')])
                ->orderBy('cod_contato desc')
                ->one();

        if (!$contatoC)
            $contatoC = new \app\models\TabContatoSearch();


        $planof = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $sici->tableName(), 'cod_chave' => $sici->cod_sici, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F')])->one();
        if (!$planof)
            $planof = new \app\modules\posoutorga\models\TabPlanosSearch();

        $planof_mn = \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch::find()->where(['cod_sici_fk' => $sici->cod_sici, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F')])->one();
        if (!$planof_mn)
            $planof_mn = new \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch();

        $planoj = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $sici->tableName(), 'cod_chave' => $sici->cod_sici, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J')])->one();
        if (!$planoj)
            $planoj = new \app\modules\posoutorga\models\TabPlanosSearch();


        $planoj_mn = \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch::find()->where(['cod_sici_fk' => $sici->cod_sici, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J')])->one();
        if (!$planoj_mn)
            $planoj_mn = new \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch();


        if (Yii::$app->request->post()) {
            $transaction = Yii::$app->db->beginTransaction();

            try {

                $post = Yii::$app->request->post();

                unset($post['TabSiciSearch']['cod_sici']);
                $sici->attributes = $post['TabSiciSearch'];
                $sici->cod_tipo_contrato_fk = $tipo_contrato->cod_tipo_contrato;
                $sici->situacao_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('situacao-sici', 'E');
                $sici->save();

                $cliente->responsavel = $post['TabClienteSearch']['responsavel'];
                $cliente->save();

                $contatoT->attributes = $post['TabContatoSearchT'];

                $contato = \app\models\TabContatoSearch::find()->where(['contato' => $post['TabContatoSearchT']['contato'], 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();
                if (!$contato) {
                    $contatoC->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T');
                    $contatoC->tipo_tabela_fk = $cliente->tableName();
                    $contatoC->chave_fk = $cliente->cod_cliente;
                    $contatoC->save();
                }


                $contatoC->attributes = $post['TabContatoSearchC'];

                $contato = \app\models\TabContatoSearch::find()->where(['contato' => $post['TabContatoSearchC']['contato'], 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();
                if (!$contato) {
                    $contatoC->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C');
                    $contatoC->tipo_tabela_fk = $cliente->tableName();
                    $contatoC->chave_fk = $cliente->cod_cliente;
                    $contatoC->save();
                }



                $planof->attributes = $post['TabPlanosF'];
                $planof->tipo_tabela_fk = $sici->tableName();
                $planof->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');
                $planof->cod_chave = $sici->cod_sici;
                $planof->save();


                $planof_mn->attributes = $post['TabPlanosMenorMaiorF'];
                $planof_mn->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');
                $planof_mn->cod_sici_fk = $sici->cod_sici;
                $planof_mn->save();


                $planoj->attributes = $post['TabPlanosJ'];
                $planoj->tipo_tabela_fk = $sici->tableName();
                $planoj->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');
                $planoj->cod_chave = $sici->cod_sici;
                $planoj->save();

                $planoj_mn->attributes = $post['TabPlanosMenorMaiorJ'];
                $planoj_mn->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');
                $planoj_mn->cod_sici_fk = $sici->cod_sici;
                $planoj_mn->save();

                $municipios = \Yii::$app->session->get('empresasSessao');

                if ($municipios) {

                    $empresasDados = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()->where(['cod_sici_fk' => $sici->cod_sici])->orderBy('uf, cod_municipio_fk')->all();
                    if ($empresasDados) {
                        foreach ($empresasDados as $key => $value) {

                            \app\modules\posoutorga\models\TabPlanosSearch::deleteAll(['cod_chave' => $value->cod_empresa_municipio, 'tipo_tabela_fk' => $value->tableName()]);
                            $value->delete();
                        }
                    }


                    foreach ($municipios as $k => $municipio) {

                        $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
                        unset($municipio[0]['cod_empresa_municipio']);
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

                $this->session->setFlash('success', 'Dados Enviados com sucesso');
                return $this->redirect(['create', 'cnpj' => $cnpj, 'mes' => $mes]);
            } catch (Exception $e) {

                $transaction->rollBack();
                $this->session->setFlash('danger', 'Erro na importação - ' . $e->getMessage());
            }
        } else {

            if ($sici->cod_sici) {
                $ultSici = $sici->cod_sici;
            } else {
                $ultSici = TabSiciSearch::find()->where("cod_tipo_contrato_fk = $tipo_contrato->cod_tipo_contrato")->orderBy('cod_sici desc')->one();
            }

            if ($ultSici) {

                $empresasDados = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()->where(['cod_sici_fk' => $sici->cod_sici])->orderBy('uf, cod_municipio_fk')->all();
                if (!$empresasDados)
                    $empresasDados = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()->where(['cod_sici_fk' => $ultSici->cod_sici])->orderBy('uf, cod_municipio_fk')->all();


                foreach ($empresasDados as $key => $emp) {
                    if (!$sici->cod_sici) {
                        $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
                        $empresa->cod_municipio_fk = $emp->cod_municipio_fk;
                        $empresa->municipio = $emp->municipio;
                        $empresa->uf = $emp->uf;
                        $empresa->tecnologia_fk = $emp->tecnologia_fk;
                        $empresa->cod_empresa_municipio = 'N_' . rand(100000000, 999999999);
                    } else {
                        $empresa = $emp;
                    }

                    if ($sici->cod_sici) {
                        $planof_municipio = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $empresa->tableName(), 'cod_chave' => $empresa->cod_empresa_municipio, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F')])->one();
                    } else {
                        $planof_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                    }

                    $planof_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');
                    $arrayF = $planof_municipio->attributes;
                    $arrayF['tipo_pessoa'] = 'Física';



                    if ($sici->cod_sici) {
                        $planoj_municipio = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $empresa->tableName(), 'cod_chave' => $empresa->cod_empresa_municipio, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J')])->one();
                    } else {
                        $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                    }
                    $planoj_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');
                    $arrayJ = $planoj_municipio->attributes;
                    $arrayJ['tipo_pessoa'] = 'Juridica';

                    $totais = $empresa->calculaTotais($planof_municipio, $planoj_municipio, false);

                    $totais['tipo_pessoa'] = 'Totais';
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

                    $empresas[] = $empresa;
                    $empresasSessao[$empresa->cod_empresa_municipio] = [$empresa->attributes, $arrayF, $arrayJ];
                }
            } else {
                $empresas = [];
                $empresasSessao = [];
            }
        }

        \Yii::$app->session->set('empresasSessao', $empresasSessao);


        $importacao = compact('sici', 'cliente', 'contatoC', 'contatoT', 'planof', 'planof_mn', 'planoj', 'planoj_mn', 'empresas');

        return $this->render('update', [
                    'importacao' => $importacao
                        ]
        );
    }

    /**
     * Updates an existing TabSici model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = null) {
        if ($id) {

            $sici = $this->findModel($id);

            $sici->calculaTotais();
            $tc = \app\modules\comercial\models\TabTipoContratoSearch::findOne($sici->cod_tipo_contrato_fk);

            $c = \app\modules\comercial\models\TabContratoSearch::findOne($tc->cod_contrato_fk);

            $cliente = \app\models\TabClienteSearch::findOne($c->cod_cliente_fk);

            $acao = 'update';
            $this->titulo = 'Alterar Sici';
            $this->subTitulo = '';
        } else {

            $acao = 'create';
            $sici = new TabSiciSearch();
            $this->titulo = 'Incluir SICI';
            $this->subTitulo = '';
            $sici->mes_ano_referencia = str_pad((date('m') - 1), 2, '0', 0) . '/' . date('Y');
            $cliente = new \app\models\TabClienteSearch();
            $sici->tipo_entrada_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-entrada', 'S');
        }

        $contatoT = \app\models\TabContatoSearch::find()
                ->where(['ativo' => true, 'tipo_tabela_fk' => $cliente->tableName(), 'chave_fk' => $cliente->cod_cliente, 'tipo' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T')])
                ->orderBy('cod_contato desc')
                ->one();


        if (!$contatoT)
            $contatoT = new \app\models\TabContatoSearch();

        $contatoC = \app\models\TabContatoSearch::find()
                ->where(['ativo' => true, 'tipo_tabela_fk' => $cliente->tableName(), 'chave_fk' => $cliente->cod_cliente, 'tipo' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C')])
                ->orderBy('cod_contato desc')
                ->one();

        if (!$contatoC)
            $contatoC = new \app\models\TabContatoSearch();



        $planof = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $sici->tableName(), 'cod_chave' => $sici->cod_sici, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F')])->one();
        if (!$planof)
            $planof = new \app\modules\posoutorga\models\TabPlanosSearch();

        $planof_mn = \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch::find()->where(['cod_sici_fk' => $sici->cod_sici, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F')])->one();
        if (!$planof_mn)
            $planof_mn = new \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch();

        $planoj = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $sici->tableName(), 'cod_chave' => $sici->cod_sici, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J')])->one();
        if (!$planoj)
            $planoj = new \app\modules\posoutorga\models\TabPlanosSearch();


        $planoj_mn = \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch::find()->where(['cod_sici_fk' => $sici->cod_sici, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J')])->one();
        if (!$planoj_mn)
            $planoj_mn = new \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch();


        if (Yii::$app->request->post()) {
            $transaction = Yii::$app->db->beginTransaction();

            try {

                $post = Yii::$app->request->post();
//echo '<pre>'; print_r($post); echo '</pre>'; exit;
                $trataErros = function($erros) {

                    if ($erros) {
                        $erro = [];
                        foreach ($erros as $value) {

                            foreach ($value as $val) {
                                if (array_search($val, $erro) === false) {
                                    $erro[] = $val;
                                }
                            }
                        }
                    }

                    return implode('<br />', $erro);
                };

                unset($post['TabSiciSearch']['cod_sici']);
                $sici->attributes = $post['TabSiciSearch'];


                if (!$sici->save()) {
                    if ($sici->errors) {
                        $erro = $trataErros($sici->errors);
                    }

                    $this->session->setFlash('danger', 'Erro na importação: <br/>' . $erro);
                    return $this->redirect(['update', 'id' => $sici->cod_sici]);
                }

                $cliente->load($post);

                $cli = \app\models\TabClienteSearch::findOne(['cnpj' => $cliente->cnpj]);
                $contatoT->attributes = $post['TabContatoSearchT'];

                $contatoC->attributes = $post['TabContatoSearchC'];

                if (!$cli) {

                    $cliente->buscaCliente();

                    if (!$cliente->save()) {

                        if ($cliente->errors) {
                            $erro = $trataErros($cliente->errors);
                        }

                        $this->session->setFlash('danger', 'Erro na importação: <br/>' . $erro);
                    }

                    $contrato = new \app\modules\comercial\models\TabContratoSearch();
                    $contrato->cod_cliente_fk = $cliente->cod_cliente;
                    $contrato->tipo_contrato_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contrato', 'pos-outorga-flex-scm');
                    $contrato->save();

                    $tipo_contrato = new \app\modules\comercial\models\TabTipoContrato();
                    $tipo_contrato->cod_contrato_fk = $contrato->cod_contrato;
                    $tipo_contrato->tipo_produto_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-produto', 'CM');
                    $tipo_contrato->save();

                    $sici->cod_tipo_contrato_fk = $tipo_contrato->cod_tipo_contrato;
                    $sici->calculaTotais();

                    $sici->save();

                    if (!$sici->save()) {

                        if ($sici->errors) {
                            $erro = $trataErros($sici->errors);
                        }

                        $this->session->setFlash('danger', 'Erro na importação: <br/>' . $erro);
                        return $this->redirect(['update', 'id' => $sici->cod_sici]);
                    }

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
                        $contatoT->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T');
                        $contatoT->tipo_tabela_fk = $cliente->tableName();
                        $contatoT->chave_fk = $cliente->cod_cliente;
                        $contatoT->save();
                    }
                    if (\projeto\Util::retiraCaracter($contato->contato) != \projeto\Util::retiraCaracter($contatoC->contato)) {
                        $contatoC->tipo_tabela_fk = $cliente->tableName();
                        $contatoC->chave_fk = $cliente->cod_cliente;
                        $contatoC->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C');
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

                            $nome = str_replace("'", ' ', $cliente->dadosReceita->municipio);
                            $nome = strtoupper(\projeto\Util::tirarAcentos($nome));
                            $uf = null;
                            if ($cliente->dadosReceita->uf) {
                                $uf = "AND sgl_estado_fk='{$cliente->dadosReceita->uf}'";
                            }

                            $municipio = \app\models\TabMunicipiosSearch::find()->where("(upper(txt_nome_sem_acento) ilike $$%" . $nome . "%$$ or (upper(txt_nome) ilike $$%" . $nome . "%$$ or upper(txt_nome) ilike $$%" . strtoupper($cliente->dadosReceita->municipio) . "%$$) $uf")->asArray()->one();

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

                    $cm = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-produto', 'CM');
                    $cj = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-produto', 'CJ');
                    $contrato = \app\modules\comercial\models\TabContratoSearch::find()->where("ativo is true and cod_cliente_fk = $cliente->cod_cliente")->one();

                    if (!$contrato) {
                        $contrato = new \app\modules\comercial\models\TabContratoSearch();
                        $contrato->tipo_contrato_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contrato', 'pos-outorga-flex-scm');
                        $contrato->cod_cliente_fk = $cliente->cod_cliente;
                        $contrato->save();
                    }

                    $tipo_contrato = \app\modules\comercial\models\TabTipoContrato::find()->where("ativo is true and (tipo_produto_fk in ({$cm}, {$cj})) and cod_contrato_fk = $contrato->cod_contrato")->one();

                    if (!$tipo_contrato) {
                        $tipo_contrato = new \app\modules\comercial\models\TabTipoContrato();
                        $tipo_contrato->cod_contrato_fk = $contrato->cod_contrato;
                        $tipo_contrato->tipo_produto_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-produto', 'CM');
                        $tipo_contrato->save();
                    }

                    $sici->cod_tipo_contrato_fk = $tipo_contrato->cod_tipo_contrato;
                    $sici->save();

                    $contato = \app\models\TabContatoSearch::find()->where(['contato' => $post['TabContatoSearchT']['contato'], 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();
                    if (!$contato) {
                        $contatoT->tipo_tabela_fk = $cliente->tableName();
                        $contatoT->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T');
                        $contatoT->chave_fk = $cliente->cod_cliente;
                        $contatoT->save();
                    }

                    $contato = \app\models\TabContatoSearch::find()->where(['contato' => $post['TabContatoSearchC']['contato'], 'chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();
                    if (!$contato) {
                        $contatoC->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C');
                        $contatoC->tipo_tabela_fk = $cliente->tableName();
                        $contatoC->chave_fk = $cliente->cod_cliente;
                        $contatoC->save();
                    }
                }

                $planof->attributes = $post['TabPlanosF'];
                $planof->tipo_tabela_fk = $sici->tableName();
                $planof->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');
                $planof->cod_chave = $sici->cod_sici;

                if (!$planof->verificarChecks($id))
                    $check[] = false;

                $planof->save();


                $planof_mn->attributes = $post['TabPlanosMenorMaiorF'];
                $planof_mn->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');
                $planof_mn->cod_sici_fk = $sici->cod_sici;
                if (!$planof_mn->verificarChecks($id))
                    $check[] = false;

                $planof_mn->save();


                $planoj->attributes = $post['TabPlanosJ'];
                $planoj->tipo_tabela_fk = $sici->tableName();
                $planoj->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');
                $planoj->cod_chave = $sici->cod_sici;
                if (!$planoj->verificarChecks($id))
                    $check[] = false;

                $planoj->save();

                $planoj_mn->attributes = $post['TabPlanosMenorMaiorJ'];
                $planoj_mn->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');
                $planoj_mn->cod_sici_fk = $sici->cod_sici;
                if (!$planoj_mn->verificarChecks($id))
                    $check[] = false;
                $planoj_mn->save();

                $municipios = \Yii::$app->session->get('empresasSessao');

                if ($municipios) {
                    foreach ($municipios as $k => $value) {

                        $municipios[$k][0]['cod_municipio_fk_check'] = $post['TabEmpresaMunicipioSearch'][$k]['cod_municipio_fk_check'];
                        $municipios[$k][0]['capacidade_municipio_check'] = $post['TabEmpresaMunicipioSearch'][$k]['capacidade_municipio_check'];
                        $municipios[$k][0]['capacidade_servico_check'] = $post['TabEmpresaMunicipioSearch'][$k]['capacidade_servico_check'];
                        $municipios[$k][0]['tecnologia_fk_check'] = $post['TabEmpresaMunicipioSearch'][$k]['tecnologia_fk_check'];
                        $municipios[$k][0]['total_check'] = $post['TabEmpresaMunicipioSearch'][$k]['total_check'];
                        $municipios[$k][0]['total_fisica_check'] = $post['TabEmpresaMunicipioSearch'][$k]['total_fisica_check'];
                        $municipios[$k][0]['total_juridica_check'] = $post['TabEmpresaMunicipioSearch'][$k]['total_juridica_check'];
                        $municipios[$k][0]['uf_check'] = $post['TabEmpresaMunicipioSearch'][$k]['uf_check'];
                    }


                    $empresasDados = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()->where(['cod_sici_fk' => $sici->cod_sici])->orderBy('uf , cod_municipio_fk')->all();
                    if ($empresasDados) {
                        foreach ($empresasDados as $key => $value) {

                            \app\modules\posoutorga\models\TabPlanosSearch::deleteAll(['cod_chave' => $value->cod_empresa_municipio, 'tipo_tabela_fk' => $value->tableName()]);
                            $value->delete();
                        }
                    }

                    foreach ($municipios as $k => $municipio) {

                        $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
                        $empresa->attributes = $municipio[0];
                        $empresa->cod_sici_fk = $sici->cod_sici;

                        if (!$empresa->verificarChecks($id))
                            $check[] = false;

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
                if (!$check) {

                    $sici->verificarChecks($id);
                    $sici->save();
                } else {
                    $sici->verificarChecks($id);
                    $sici->situacao_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('situacao-sici', 'P');
                    $sici->save();
                }

                //$sici->mes_ano_referencia = $dados_sici['mes_ano_referencia'];
                $transaction->commit();


                $this->session->setFlashProjeto('success', $acao);

                return $this->redirect(['update', 'id' => $sici->cod_sici]);
            } catch (Exception $e) {

                $transaction->rollBack();
                $this->session->setFlash('danger', 'Erro na importação - ' . $e->getMessage());
            }
        } else {


            $empresasDados = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()->where(['cod_sici_fk' => $sici->cod_sici])->orderBy('uf, cod_municipio_fk')->all();

            foreach ($empresasDados as $key => $empresa) {

                $planof_municipio = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $empresa->tableName(), 'cod_chave' => $empresa->cod_empresa_municipio, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F')])->one();
                $planof_municipio->numerico();
                $arrayF = $planof_municipio->attributes;
                $arrayF['tipo_pessoa'] = 'Física';

                $planoj_municipio = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $empresa->tableName(), 'cod_chave' => $empresa->cod_empresa_municipio, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J')])->one();
                $planoj_municipio->numerico();
                $arrayJ = $planoj_municipio->attributes;
                $arrayJ['tipo_pessoa'] = 'Juridica';

                $totais = $empresa->calculaTotais($planof_municipio, $planoj_municipio, false);

                $totais['tipo_pessoa'] = 'Totais';
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

                $empresas[] = $empresa;
                $empresasSessao[$empresa->cod_empresa_municipio] = [$empresa->attributes, $arrayF, $arrayJ];
            }

            \Yii::$app->session->set('empresasSessao', $empresasSessao);

            $sici->qntAcesso = count($empresas);
        }

        $importacao = compact('sici', 'cliente', 'contatoC', 'contatoT', 'planof', 'planof_mn', 'planoj', 'planoj_mn', 'empresas');

        return $this->render('update', [
                    'importacao' => $importacao
                        ]
        );
    }

    public function actionGerar($cod_sici) {


        $dom = new \DOMDocument('1.0', "UTF-8");

        $root = $dom->createElement('root');

        $sici = TabSiciSearch::findOne(['cod_sici' => $cod_sici]);
        $tipo_contrato = \app\modules\comercial\models\TabTipoContratoSearch::findOne(['cod_tipo_contrato' => $sici->cod_tipo_contrato_fk]);

        $contrato = \app\modules\comercial\models\TabContratoSearch::findOne(['cod_contrato' => $tipo_contrato->cod_contrato_fk]);

        $cliente = \app\models\TabClienteSearch::find()->where(['cod_cliente' => $contrato->cod_cliente_fk])->one();

        $uploadSICI = $dom->createElement('UploadSICI');
        $mes = $dom->createAttribute('mes');
        $mes->value = substr($sici->mes_ano_referencia, 0, 2);
        $uploadSICI->appendChild($mes);

        $ano = $dom->createAttribute('ano');
        $ano->value = substr($sici->mes_ano_referencia, 3, 4);
        $uploadSICI->appendChild($ano);

        $outorga = $dom->createElement('Outorga');
        $fistel = $dom->createAttribute('fistel');
        $fistel->value = $cliente->fistel;
        $outorga->appendChild($fistel);

        $endereco = \app\models\TabEnderecoSearch::find()->where(['chave_fk' => $cliente->cod_cliente, 'tipo_tabela_fk' => $cliente->tableName()])->one();

// ITEM4
        $indicador = $dom->createElement('Indicador');
        $ITEM4 = $dom->createAttribute('Sigla');
        $ITEM4->value = 'IEM4';
        $indicador->appendChild($ITEM4);

        $conteudo = $dom->createElement('Conteudo');
        $uf = $dom->createAttribute('uf');
        $item = $dom->createAttribute('item');
        $valor = $dom->createAttribute('valor');

        $uf->value = $endereco->tabMunicipios->sgl_estado_fk;
        $item->value = 'a';
        $valor->value = empty($sici->qtd_funcionarios_fichados) ? '0' : (int) $sici->qtd_funcionarios_fichados;
        $conteudo->appendChild($uf);
        $conteudo->appendChild($item);
        $conteudo->appendChild($valor);
        $indicador->appendChild($conteudo);

        $outorga->appendChild($indicador);


// ITEM5
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IEM5';
        $indicador->appendChild($ITEM);


        $conteudo = $dom->createElement('Conteudo');
        $uf = $dom->createAttribute('uf');
        $item = $dom->createAttribute('item');
        $valor = $dom->createAttribute('valor');
        $uf->value = $endereco->tabMunicipios->sgl_estado_fk;
        $item->value = 'a';
        $valor->value = empty($sici->qtd_funcionarios_terceirizados) ? '0' : $sici->qtd_funcionarios_terceirizados;
        $conteudo->appendChild($uf);
        $conteudo->appendChild($item);
        $conteudo->appendChild($valor);
        $indicador->appendChild($conteudo);

        $outorga->appendChild($indicador);


// ITEM9
        $planos = \app\modules\posoutorga\models\TabPlanosSearch::getITEM9($sici->cod_sici, $sici->tableName());
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IEM9';
        $indicador->appendChild($ITEM);


        foreach ($planos as $key => $plano) {

            $pessoa = $dom->createElement('Pessoa');
            $item = $dom->createAttribute('item');
            $item->value = $key;
            $pessoa->appendChild($item);

            foreach ($plano as $k => $faixa) {

                $conteudo = $dom->createElement('Conteudo');

                $uf = $dom->createAttribute('uf');
                $item = $dom->createAttribute('item');
                $valor = $dom->createAttribute('valor');

                $uf->value = $endereco->tabMunicipios->sgl_estado_fk;
                $item->value = $k;
                $valor->value = empty($faixa) ? '0,00' : \projeto\Util::decimalFormatToBank($faixa);

                $conteudo->appendChild($uf);
                $conteudo->appendChild($item);
                $conteudo->appendChild($valor);

                $pessoa->appendChild($conteudo);
            }
            $indicador->appendChild($pessoa);
        }
        $outorga->appendChild($indicador);


// ITEM10
        $planosMM = \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch::getIEM10($sici->cod_sici);
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IEM10';
        $indicador->appendChild($ITEM);


        foreach ($planosMM as $key => $plano) {

            $pessoa = $dom->createElement('Pessoa');
            $item = $dom->createAttribute('item');
            $item->value = $key;
            $pessoa->appendChild($item);

            foreach ($plano as $k => $faixa) {

                $conteudo = $dom->createElement('Conteudo');

                $uf = $dom->createAttribute('uf');
                $item = $dom->createAttribute('item');
                $valor = $dom->createAttribute('valor');

                $uf->value = $endereco->tabMunicipios->sgl_estado_fk;
                $item->value = $k;
                $valor->value = empty($faixa) ? '0,00' : str_replace('.', '', \projeto\Util::decimalFormatToBank($faixa));

                $conteudo->appendChild($uf);
                $conteudo->appendChild($item);
                $conteudo->appendChild($valor);

                $pessoa->appendChild($conteudo);
            }
            $indicador->appendChild($pessoa);
        }
        $outorga->appendChild($indicador);


// IPL3
        $empresa_municipio = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::getIPL3($cod_sici);

        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IPL3';
        $indicador->appendChild($ITEM);
        if ($empresa_municipio) {
            foreach ($empresa_municipio as $item => $valor) {
                $municipio = $dom->createElement('Municipio');
                $codmunicipio = $dom->createAttribute('codmunicipio');
                $codmunicipio->value = $item;
                $municipio->appendChild($codmunicipio);

                foreach ($valor as $i => $val) {
                    $pessoa = $dom->createElement('Pessoa');

                    $pitem = $dom->createAttribute('item');
                    $pitem->value = $i;
                    $pessoa->appendChild($pitem);

                    $conteudo = $dom->createElement('Conteudo');

                    $citem = $dom->createAttribute('item');
                    $valor = $dom->createAttribute('valor');

                    $citem->value = 'a';
                    $valor->value = empty($val['total']) ? '0' : (int) $val['total'];

                    $conteudo->appendChild($citem);
                    $conteudo->appendChild($valor);

                    $pessoa->appendChild($conteudo);

                    $municipio->appendChild($pessoa);
                }
                $indicador->appendChild($municipio);
            }
            $outorga->appendChild($indicador);
        }


        // QAIPL4SM
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'QAIPL4SM';
        $indicador->appendChild($ITEM);
        $empresa_municipio = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::getQAIPL4SM($cod_sici);

        if ($empresa_municipio) {

            foreach ($empresa_municipio as $item => $valor) {

                $municipio = $dom->createElement('Municipio');
                $codmunicipio = $dom->createAttribute('codmunicipio');
                $codmunicipio->value = $item;
                $municipio->appendChild($codmunicipio);

                foreach ($valor as $iT => $tecno) {

                    $tec = \app\models\TabAtributosValoresSearch::findOne($iT);

                    $tecnologia = $dom->createElement('Tecnologia');
                    $tItem = $dom->createAttribute('item');
                    $tItem->value = strtoupper($tec->sgl_valor);
                    $tecnologia->appendChild($tItem);

                    $conteudo = $dom->createElement('Conteudo');
                    $nome = $dom->createAttribute('nome');
                    $valor = $dom->createAttribute('valor');
                    $nome->value = 'QAIPL4SM';
                    $valor->value = empty($tecno['total']) ? '0' : ($tecno['total']);

                    $conteudo->appendChild($nome);
                    $conteudo->appendChild($valor);

                    $tecnologia->appendChild($tItem);

                    foreach ($tecno as $i => $val) {

                        if ($i == 'total' || $i == 'QAIPL5SM') {
                            $conteudo = $dom->createElement('Conteudo');
                            $nome = $dom->createAttribute('nome');
                            $valor = $dom->createAttribute('valor');
                            $nome->value = $i;
                            $valor->value = empty($val) ? '0' : $val;

                            $conteudo->appendChild($nome);
                            $conteudo->appendChild($valor);
                        } else {

                            $conteudo = $dom->createElement('Conteudo');
                            $faixa = $dom->createAttribute('faixa');
                            $valor = $dom->createAttribute('valor');
                            $faixa->value = $i;
                            $valor->value = empty($val) ? '0' : $val;

                            $conteudo->appendChild($faixa);
                            $conteudo->appendChild($valor);
                        }
                        $tecnologia->appendChild($conteudo);
                    }
                    $municipio->appendChild($tecnologia);
                }

                $indicador->appendChild($municipio);
            }

            $outorga->appendChild($indicador);
        }


// IPL6IM
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IPL6IM';
        $indicador->appendChild($ITEM);

        $empresa_municipio = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::getIPL6IM($cod_sici);
        if ($empresa_municipio) {
            foreach ($empresa_municipio as $key => $value) {

                $conteudo = $dom->createElement('Conteudo');
                $codmunicipio = $dom->createAttribute('codmunicipio');
                $valor = $dom->createAttribute('valor');
                $codmunicipio->value = $key;
                $valor->value = empty($value['capacidade_municipio']) ? '0' : $value['capacidade_municipio'];

                $conteudo->appendChild($codmunicipio);
                $conteudo->appendChild($valor);
                $indicador->appendChild($conteudo);
            }


            $outorga->appendChild($indicador);
        }

// IAU1
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IAU1';
        $indicador->appendChild($ITEM);

        $conteudo = $dom->createElement('Conteudo');
        $valor = $dom->createAttribute('valor');
        $valor->value = empty($sici->num_central_atendimento) ? '0' : $sici->num_central_atendimento;

        $conteudo->appendChild($valor);
        $indicador->appendChild($conteudo);
        $outorga->appendChild($indicador);

// IPL1
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IPL1';
        $indicador->appendChild($ITEM);

        foreach ($sici->getIPL1() as $key => $value) {
            $conteudo = $dom->createElement('Conteudo');
            $item = $dom->createAttribute('item');
            $valor = $dom->createAttribute('valor');
            $item->value = $key;
            $valor->value = empty($value) ? '0,00' : str_replace('.', '', \projeto\Util::decimalFormatToBank($value));

            $conteudo->appendChild($item);
            $conteudo->appendChild($valor);

            $indicador->appendChild($conteudo);
        }
        $outorga->appendChild($indicador);


// IPL2
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IPL2';
        $indicador->appendChild($ITEM);

        foreach ($sici->getIPL2() as $key => $value) {
            $conteudo = $dom->createElement('Conteudo');
            $item = $dom->createAttribute('item');
            $valor = $dom->createAttribute('valor');
            $item->value = $key;
            $valor->value = empty($value) ? '0,00' : str_replace('.', '', \projeto\Util::decimalFormatToBank($value));

            $conteudo->appendChild($item);
            $conteudo->appendChild($valor);

            $indicador->appendChild($conteudo);
        }
        $outorga->appendChild($indicador);



// IEM1
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IEM1';
        $indicador->appendChild($ITEM);

        foreach ($sici->getIEM1() as $key => $value) {

            $conteudo = $dom->createElement('Conteudo');
            $item = $dom->createAttribute('item');
            $valor = $dom->createAttribute('valor');
            $item->value = $key;

            $valor->value = empty($value) ? '0,00' : str_replace('.', '', \projeto\Util::decimalFormatToBank($value));

            $conteudo->appendChild($item);
            $conteudo->appendChild($valor);

            $indicador->appendChild($conteudo);
        }

        $outorga->appendChild($indicador);


// IEM2
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IEM2';
        $indicador->appendChild($ITEM);

        foreach ($sici->getIEM2() as $key => $value) {

            $conteudo = $dom->createElement('Conteudo');
            $item = $dom->createAttribute('item');
            $valor = $dom->createAttribute('valor');
            $item->value = $key;

            $valor->value = empty($value) ? '0,00' : str_replace('.', '', \projeto\Util::decimalFormatToBank($value));

            $conteudo->appendChild($item);
            $conteudo->appendChild($valor);

            $indicador->appendChild($conteudo);
        }
        $outorga->appendChild($indicador);

// IEM3
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IEM3';
        $indicador->appendChild($ITEM);

        $conteudo = $dom->createElement('Conteudo');
        $item = $dom->createAttribute('item');
        $valor = $dom->createAttribute('valor');
        $item->value = 'a';
        $valor->value = empty($sici->valor_consolidado) ? '0,00' : str_replace('.', '', \projeto\Util::decimalFormatToBank($sici->valor_consolidado));

        $conteudo->appendChild($item);
        $conteudo->appendChild($valor);

        $indicador->appendChild($conteudo);
        $outorga->appendChild($indicador);

// IEM6
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IEM6';
        $indicador->appendChild($ITEM);

        $conteudo = $dom->createElement('Conteudo');
        $item = $dom->createAttribute('item');
        $valor = $dom->createAttribute('valor');
        $item->value = 'a';
        $valor->value = empty($sici->receita_bruta) ? '0,00' : str_replace('.', '', \projeto\Util::decimalFormatToBank($sici->receita_bruta));

        $conteudo->appendChild($item);
        $conteudo->appendChild($valor);

        $indicador->appendChild($conteudo);
        $outorga->appendChild($indicador);

// IEM7
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IEM7';
        $indicador->appendChild($ITEM);


        $conteudo = $dom->createElement('Conteudo');
        $item = $dom->createAttribute('item');
        $valor = $dom->createAttribute('valor');
        $item->value = 'a';

        $valor->value = empty($sici->receita_liquida) ? '0,00' : str_replace('.', '', $sici->receita_liquida);
        $conteudo->appendChild($item);
        $conteudo->appendChild($valor);

        $indicador->appendChild($conteudo);
        $outorga->appendChild($indicador);

// IEM8
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IEM8';
        $indicador->appendChild($ITEM);

        foreach ($sici->getIEM8() as $key => $value) {
            $conteudo = $dom->createElement('Conteudo');
            $item = $dom->createAttribute('item');
            $valor = $dom->createAttribute('valor');
            $item->value = $key;

            $valor->value = empty($value) ? '0,00' : str_replace('.', '', \projeto\Util::decimalFormatToBank($value));

            $conteudo->appendChild($item);
            $conteudo->appendChild($valor);

            $indicador->appendChild($conteudo);
        }
        $outorga->appendChild($indicador);


        $uploadSICI->appendChild($outorga);
        $root->appendChild($uploadSICI);
        $dom->appendChild($root);

        $nome = 'SICI-' . str_replace('/', '', $sici->mes_ano_referencia) . '-' . str_replace(' ', '_', \projeto\Util::tirarAcentos($cliente->razao_social)) . '-' . $sici->cod_sici . '.xml';



        $url = sys_get_temp_dir() . "/" . $nome;
        $dom->save($url);


        header("Content-Type: application/octet-stream");
        header("Content-Length:" . filesize($url));
        header("Content-Disposition: attachment; filename={$nome}");
        header("Content-Transfer-Encoding: binary");
        header("Expires: 0");
        header("Pragma: no-cache");

        $fp = fopen($url, "r");
        fpassthru($fp);
        fclose($fp);
    }

    /**
     * Creates a new TabSici model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionImportar() {
        $model = new TabSiciSearch();
        $this->titulo = 'Importar planilha do SICI';
        $this->subTitulo = '';
        $importacao = [];
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $dados = \yii\web\UploadedFile::getInstance($model, 'file');

            if (!$dados) {

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
                        $contrato->tipo_contrato_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contrato', 'pos-outorga-flex-scm');
                        $contrato->cod_cliente_fk = $cliente->cod_cliente;
                        $contrato->save();
                        $tipo_contrato = new \app\modules\comercial\models\TabTipoContrato();
                        $tipo_contrato->cod_contrato_fk = $contrato->cod_contrato;
                        $tipo_contrato->tipo_produto_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-produto', 'CM');
                        $tipo_contrato->save();
                        $sici->cod_tipo_contrato_fk = $tipo_contrato->cod_tipo_contrato;
                        $sici->save();

                        if ($cliente->dadosReceita) {
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
                            if ($cliente->dadosReceita->atividade_principal) {
                                foreach ($cliente->dadosReceita->atividade_principal as $value) {
                                    $atividade = new \app\models\TabAtividadeSearch();
                                    $atividade->descricao = $value->text;
                                    $atividade->codigo = $value->code;
                                    $atividade->primario = true;
                                    $atividade->cod_cliente_fk = $cliente->cod_cliente;
                                    $atividade->save();
                                }
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
                            if (!$cliente->fantasia)
                                $cliente->fantasia = $cliente->razao_social;
                        }
                    } else {
                        if (!$cli->fistel) {
                            $cli->fistel = $cliente->fistel;
                        }
                        $cliente = $cli;
                        $cliente->save();
                        $cm = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-produto', 'CM');
                        $cj = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-produto', 'CJ');
                        $contrato = \app\modules\comercial\models\TabContratoSearch::find()->where("ativo is true and cod_cliente_fk = $cliente->cod_cliente")->one();

                        if (!$contrato) {
                            $contrato = new \app\modules\comercial\models\TabContratoSearch();
                            $contrato->tipo_contrato_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contrato', 'pos-outorga-flex-scm');
                            $contrato->cod_cliente_fk = $cliente->cod_cliente;
                            $contrato->save();
                        }

                        $tipo_contrato = \app\modules\comercial\models\TabTipoContrato::find()->where("ativo is true and (tipo_produto_fk in ({$cm}, {$cj})) and cod_contrato_fk = $contrato->cod_contrato")->one();

                        if (!$tipo_contrato) {
                            $tipo_contrato = new \app\modules\comercial\models\TabTipoContrato();
                            $tipo_contrato->cod_contrato_fk = $contrato->cod_contrato;
                            $tipo_contrato->tipo_produto_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-produto', 'CM');
                            $tipo_contrato->save();
                        }
                        $sici->cod_tipo_contrato_fk = $tipo_contrato->cod_tipo_contrato;
                        $sici->save();

                        if ($sici->errors) {
                            $erro = [];
                            foreach ($sici->errors as $value) {

                                foreach ($value as $val) {
                                    if (array_search($val, $erro) === false) {
                                        $erro[] = $val;
                                    }
                                }
                            }
                            $transaction->rollBack();
                            $this->session->setFlash('danger', 'Erro na importação - ' . implode('<br />', $erro));
                            \Yii::$app->session->set('empresasSessao', null);
                            return $this->render('importar', [
                                        'model' => $model,
                                        'importacao' => $importacao
                            ]);
                        }

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
                    if (!$planof->verificarChecks())
                        $check[] = false;

                    $planof_mn->attributes = Yii::$app->request->post()['TabPlanosMenorMaiorF'];
                    $planof_mn->cod_sici_fk = $sici->cod_sici;
                    $planof_mn->save();
                    if (!$planof_mn->verificarChecks())
                        $check[] = false;

                    $planoj->attributes = Yii::$app->request->post()['TabPlanosJ'];
                    $planoj->tipo_tabela_fk = $sici->tableName();
                    $planoj->cod_chave = $sici->cod_sici;
                    $planoj->save();
                    if (!$planoj->verificarChecks())
                        $check[] = false;

                    $planoj_mn->attributes = Yii::$app->request->post()['TabPlanosMenorMaiorJ'];
                    $planoj_mn->cod_sici_fk = $sici->cod_sici;
                    $planoj_mn->save();
                    if (!$planoj_mn->verificarChecks())
                        $check[] = false;

                    $municipios = \Yii::$app->session->get('empresasSessao');
                    if ($municipios) {
                        foreach ($municipios as $municipio) {
                            $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();

                            unset($municipio[0]['cod_empresa_municipio']);
                            $empresa->attributes = $municipio[0];

                            if (!$empresa->cod_municipio_fk) {
                                $erroMunicipio[] = $municipio[0];
                                continue;
                            }
                            $empresa->cod_sici_fk = $sici->cod_sici;
                            $empresa->save();
                            if (!$empresa->verificarChecks())
                                $check[] = false;

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

                    if (!$check) {

                        $sici->verificarChecks();
                        $sici->save();
                    } else {
                        $sici->situacao_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('situacao-sici', 'P');
                        $sici->save();
                    }

                    //$sici->mes_ano_referencia = $dados_sici['mes_ano_referencia'];
                    $transaction->commit();
                    if ($erroMunicipio) {

                        $this->session->setFlash('warning', count($erroMunicipio) . ' Acesso(s) não incluido(s)');
                    }
                    $this->session->setFlashProjeto('success', 'create');

                    return $this->redirect(['update', 'id' => $sici->cod_sici]);
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $this->session->setFlash('danger', 'Erro na importação - ' . $e->getMessage());
                }
//$municipios = \Yii::$app->session->get('dados');
            } else {

                if ($dados->getExtension() == 'xml') {
                    $importacao = $this->importXml($dados->tempName, Yii::$app->request->post()['TabSiciSearch']);
                } else {
                    $importacao = $this->importExcel($dados->tempName, Yii::$app->request->post()['TabSiciSearch']);
                }
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

    public function importXml($inputFiles, $post) {
        ini_set('memory_limit', '512M');

        $xml = simplexml_load_file($inputFiles);
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


//$row is start 2 because first row assigned for heading.         
        $i = 0;
        $sici = new TabSiciSearch();
        $teste = false;
        for ($row = 1; $row <= $highestRow; ++$row) {


            $rowDatas = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

            $rowData[] = $rowDatas;

            if ($row == 600) {
                break;
            }
        }

        $sici = new TabSiciSearch();

        $cliente = new \app\models\TabClienteSearch;
        $contatoC = new \app\models\TabContatoSearch;
        $contatoT = new \app\models\TabContatoSearch;

        $planof = new \app\modules\posoutorga\models\TabPlanos();
        $planof_mn = new \app\modules\posoutorga\models\TabPlanosMenorMaior();

        $planoj = new \app\modules\posoutorga\models\TabPlanos();
        $planoj_mn = new \app\modules\posoutorga\models\TabPlanosMenorMaior();


//INFORMAÇÕES DA EMPRESA

        $rowData = $this->retornaImportacao($rowData, 'INFORMACOES DA EMPRESA');
        $key = 4;
        $cliente->razao_social = trim($rowData[$key][0][2]);
        $cliente->responsavel = trim($rowData[$key][0][9]);
        $contatoT->contato = trim($rowData[$key][0][16]);
        $contatoT->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T');
        $key += 5;
        $cliente->cnpj = \projeto\Util::retiraCaracter(trim($rowData[$key][0][2]));
        $cliente->cnpj = str_pad($cliente->cnpj, 14, '0', 0);
        $dadosCliente = \app\models\TabClienteSearch::find()->where("cnpj = '{$cliente->cnpj}' "
                        . " OR replace(replace(replace(cnpj, '.', ''), '-', ''), '/', '')='{$cliente->cnpj}'")->one();

        if ($dadosCliente) {
            $cliente = $dadosCliente;
            $clienteContrato = \app\modules\posoutorga\models\VisSiciCliente::findOne(['cnpj' => $cliente->cnpj]);
            if ($clienteContrato) {
                $sici->cod_tipo_contrato_fk = $clienteContrato->cod_tipo_contrato;
            }
        }

        $dt_referencia = ( \PHPExcel_Style_NumberFormat::toFormattedString(trim($rowData[$key][0][9]), 'MM/YYYY'));


        $sici->mes_ano_referencia = $dt_referencia;

        $contatoC->contato = trim($rowData[$key][0][16]);
        $contatoC->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C');
        ;


        $rowData = $this->retornaImportacao($rowData, 'BRUTA', true);
        
//INFORMAÇÕES FINANCEIRAS
        $key = 0;
        
        if (!trim($rowData[$key][0][1]))
            $key += 1;
   


        $sici->receita_bruta = trim($rowData[$key][0][9]);
        $sici->despesa_operacao_manutencao = trim($rowData[$key][0][20]);
        $key += 3;
        $mult = ((100 * trim($rowData[$key][0][7])) > 100) ? 1 : 100;

        $sici->aliquota_nacional = ($mult * trim($rowData[$key][0][7]));

        $sici->despesa_publicidade = trim($rowData[$key][0][20]);

        $key += 3;
        $sici->receita_icms = ($mult * trim($rowData[$key][0][7]));
        $sici->despesa_vendas = trim($rowData[$key][0][20]);
        $key += 3;
        $sici->receita_pis = ($mult * trim($rowData[$key][0][7]));
        $sici->despesa_link = trim($rowData[$key][0][20]);

        $key += 3;
        $sici->receita_confins = ($mult * trim($rowData[$key][0][7]));

        $key += 3;
        $key += 5;
        $sici->obs_receita = trim($rowData[$key][0][2]);
        $sici->obs_despesa = trim($rowData[$key][0][13]);

        
        $rowData = $this->retornaImportacao($rowData, 'INVESTIMENTO', TRUE);
        $key = 4;

        
        $tipoSici = 'mensal';
        $sici->tipo_sici_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-sici', 'M');
        if ($rowData) {
            $tipoSici = 'semestral';
            
            
            $sici->valor_consolidado = trim($rowData[$key][0][9]);
            $sici->tipo_sici_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-sici', 'S');

//QUANTITATIVO DE FUNCIONÁRIOS
            $rowDataA = $this->retornaImportacao($rowData, 'QUANTITATIVO', TRUE);

            if ($rowDataA) {
                $key = 3;
                $sici->qtd_funcionarios_fichados = trim($rowDataA[$key][0][7]);
                $sici->qtd_funcionarios_terceirizados = trim($rowDataA[$key][0][19]);

                $key += 3;
                $sici->num_central_atendimento = trim($rowDataA[$key][0][14]);
            }
//INFORMAÇÕES ADICIONAIS - INDICADORES
            $rowDataA = $this->retornaImportacao($rowDataA, 'INDICADORES', TRUE);

            if ($rowDataA) {
                $sici->tipo_sici_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-sici', 'A');
                $tipoSici = 'anual';
                $key = 4;

                $sici->total_fibra_prestadora = trim($rowDataA[$key][0][7]);
                $sici->total_fibra_terceiros = trim($rowDataA[$key][0][19]);

                $key += 3;
                $sici->total_fibra_crescimento_prop_prestadora = trim($rowDataA[$key][0][7]);
                $sici->total_fibra_crescimento_prop_terceiros = trim($rowDataA[$key][0][19]);

                $key += 5;
                $sici->total_fibra_implantada_prestadora = trim($rowDataA[$key][0][7]);
                $sici->total_fibra_implantada_terceiros = trim($rowDataA[$key][0][19]);

                $key += 3;
                $sici->total_crescimento_prestadora = trim($rowDataA[$key][0][7]);
                $sici->total_crescimento_terceiros = trim($rowDataA[$key][0][19]);


                $key += 5;
                $sici->total_marketing_propaganda = trim($rowDataA[$key][0][19]);

                $key += 3;
                $sici->aplicacao_equipamento = trim($rowDataA[$key][0][7]);
                $sici->aplicacao_software = trim($rowDataA[$key][0][19]);

                $key += 3;
                $sici->total_pesquisa_desenvolvimento = trim($rowDataA[$key][0][7]);
                $sici->aplicacao_servico = trim($rowDataA[$key][0][19]);

                $key += 3;
                $sici->aplicacao_callcenter = trim($rowDataA[$key][0][7]);

                $sici->total_planta = \projeto\Util::decimalFormatToBank(\projeto\Util::decimalFormatForBank($sici->total_marketing_propaganda) +
                                \projeto\Util::decimalFormatForBank($sici->aplicacao_equipamento) +
                                \projeto\Util::decimalFormatForBank($sici->aplicacao_software) +
                                \projeto\Util::decimalFormatForBank($sici->total_pesquisa_desenvolvimento) +
                                \projeto\Util::decimalFormatForBank($sici->aplicacao_servico) +
                                \projeto\Util::decimalFormatForBank($sici->aplicacao_callcenter));
//QUANTITATIVO DE FUNCIONÁRIOS

                $key += 5;
                $sici->faturamento_de = trim($rowDataA[$key][0][7]);
                $sici->faturamento_industrial = trim($rowDataA[$key][0][19]);

                $key += 3;
                $sici->faturamento_adicionado = trim($rowDataA[$key][0][7]);
                $rowData = $rowDataA;
            }
        }

        $rowData = $this->retornaImportacao($rowData, 'MENOR OU IGUAL', true);

//INFORMAÇÕES DO PLANO
        $key = 0;
        $planof->valor_512 = trim($rowData[$key][0][9]);
        $planoj->valor_512 = trim($rowData[$key][0][20]);

        $key += 3;
        $planof->valor_512k_2m = trim($rowData[$key][0][9]);
        $planoj->valor_512k_2m = trim($rowData[$key][0][20]);

        $key += 3;
        $planof->valor_2m_12m = trim($rowData[$key][0][9]);
        $planoj->valor_2m_12m = trim($rowData[$key][0][20]);

        $key += 3;
        $planof->valor_12m_34m = trim($rowData[$key][0][9]);
        $planoj->valor_12m_34m = trim($rowData[$key][0][20]);

        $key += 3;
        $planof->valor_34m = trim($rowData[$key][0][9]);
        $planoj->valor_34m = trim($rowData[$key][0][20]);

        $planof->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');
        $planoj->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');

//INFORMAÇÕES DO PLANO Menor Maior
        $key += 5;
        $planof_mn->valor_menos_1m_ded = trim($rowData[$key][0][9]);
        $planoj_mn->valor_menos_1m_ded = trim($rowData[$key][0][20]);

        $key += 2;
        $planof_mn->valor_menos_1m = trim($rowData[$key][0][9]);
        $planoj_mn->valor_menos_1m = trim($rowData[$key][0][20]);

        $key += 2;
        $planof_mn->valor_maior_1m_ded = trim($rowData[$key][0][9]);
        $planoj_mn->valor_maior_1m_ded = trim($rowData[$key][0][20]);

        $key += 2;
        $planof_mn->valor_maior_1m = trim($rowData[$key][0][9]);
        $planoj_mn->valor_maior_1m = trim($rowData[$key][0][20]);

        $planof_mn->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');
        $planoj_mn->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');

        $key += 4;
        $planof->obs = trim($rowData[$key][0][2]);
        $planoj->obs = trim($rowData[$key][0][13]);

        //DISTRIBUIÇÃO DO QUANTITATIVO DE ACESSOS FÍSICOS EM SERVIÇO
        $rowData = $this->retornaImportacao($rowData, 'ACESSO', true);
        $key = 3;

        for ($i = $key; $i < count($rowData); $i++) {


            if (strpos(strtoupper(trim($rowData[$i][0][1])), 'MUNICÍPIO') !== false) {
                $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();

                if (trim($rowData[$i][0][4]) && trim($rowData[$i][0][17])) {
                    $empresa->municipio = trim($rowData[$i][0][4]);

                    $empresa->tecnologia_fk = strtoupper(str_replace(' ', '', trim(\projeto\Util::retiraAcento(\projeto\Util::tirarAcentos(trim($rowData[$i][0][17]))))));
                    if ($empresa->tecnologia_fk) {
                        $empresa->tecnologia_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tecnologia', $empresa->tecnologia_fk, true);
                    }

                    $i += 3;
                    $empresa->uf = trim($rowData[$i][0][4]);
                    $empresa->cod_municipio_fk = substr(trim($rowData[$i][0][10]), 0, 6);

                    if (!$empresa->cod_municipio_fk) {
                        $nome = str_replace("'", ' ', $empresa->municipio);
                        $nome = strtoupper(\projeto\Util::tirarAcentos($nome));
                        //$nome = strtoupper(\projeto\Util::tirarAcentos($empresa->municipio));
                        $uf = null;
                        if ($empresa->uf) {
                            $uf = "AND sgl_estado_fk ilike '{$empresa->uf}'";
                        }

                        $municipio = \app\models\TabMunicipiosSearch::find()->where("(upper(txt_nome_sem_acento) ilike $$%" . $nome . "%$$ or upper(txt_nome) ilike $$%" . strtoupper($empresa->municipio) . "%$$) $uf")->asArray()->one();

                        if ($municipio) {
                            $empresa->cod_municipio_fk = $municipio['cod_municipio'];
                        }
                    }
                    $i += 5;
                    $planof_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                    $planof_municipio->valor_512 = trim($rowData[$i][0][4]);
                    $planof_municipio->valor_512k_2m = trim($rowData[$i][0][7]);
                    $planof_municipio->valor_2m_12m = trim($rowData[$i][0][10]);
                    $planof_municipio->valor_12m_34m = trim($rowData[$i][0][13]);
                    $planof_municipio->valor_34m = trim($rowData[$i][0][16]);

                    $planof_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');
                    $arrayF = $planof_municipio->attributes;
                    $arrayF['tipo_pessoa'] = 'Física';

                    $i += 2;
                    $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                    $planoj_municipio->valor_512 = trim($rowData[$i][0][4]);
                    $planoj_municipio->valor_512k_2m = trim($rowData[$i][0][7]);
                    $planoj_municipio->valor_2m_12m = trim($rowData[$i][0][10]);
                    $planoj_municipio->valor_12m_34m = trim($rowData[$i][0][13]);
                    $planoj_municipio->valor_34m = trim($rowData[$i][0][16]);
                    $planoj_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');
                    $arrayJ = $planoj_municipio->attributes;
                    $arrayJ['tipo_pessoa'] = 'Juridica';

                    $totais = $empresa->calculaTotais($planof_municipio, $planoj_municipio);

                    $totais['tipo_pessoa'] = 'Totais';
                    $arrayF['total'] = $empresa->total_fisica;
                    $arrayJ['total'] = $empresa->total_juridica;

                    $i += 5;
                    $empresa->capacidade_municipio = (int) trim($rowData[$i][0][7]);
                    $empresa->capacidade_servico = (int) trim($rowData[$i][0][20]);
                    //$i += 4;

                    $empresa->gridMunicipios[] = $arrayF;
                    $empresa->gridMunicipios[] = $arrayJ;
                    $empresa->gridMunicipios[] = $totais;

                    $empresa->gridMunicipios = new \yii\data\ArrayDataProvider([
                        'id' => 'grid_lista_acesso-' . $key,
                        'allModels' => $empresa->gridMunicipios,
                        'sort' => false,
                        'pagination' => ['pageSize' => 10],
                    ]);

                    $empresa->cod_empresa_municipio = 'N_' . rand(100000000, 999999999);

                    $empresas[] = $empresa;

                    $empresasSessao[$empresa->cod_empresa_municipio] = [$empresa->attributes, $planof_municipio->attributes, $planoj_municipio->attributes];
                }
            }
        }

        \Yii::$app->session->set('empresasSessao', $empresasSessao);

        $cliente->validate();
        $sici->tipo_entrada_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-entrada', 'E');
        $sici->calculaTotais();

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

    /**
     * Deletes an existing TabSici model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {

        $sici = $this->findModel($id);

        $transaction = Yii::$app->db->beginTransaction();
        try {

            $planof = \app\modules\posoutorga\models\TabPlanosSearch::deleteAll(['cod_chave' => $sici->cod_sici, 'tipo_tabela_fk' => $sici->tableName()]);

            $planof_mn = \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch::deleteAll(['cod_sici_fk' => $sici->cod_sici]);

            $empresas = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::findAll(['cod_sici_fk' => $sici->cod_sici]);

            foreach ($empresas as $key => $empresa) {
                \app\modules\posoutorga\models\TabPlanosSearch::deleteAll(['cod_chave' => $empresa->cod_empresa_municipio, 'tipo_tabela_fk' => $empresa->tableName()]);

                $empresa->delete();
            }


            if ($sici->delete()) {
                $transaction->commit();
                $this->session->setFlashProjeto('success', 'delete');
            } else {
                $transaction->rollBack();
                $this->session->setFlashProjeto('danger', 'delete');
            }
        } catch (Exception $e) {

            $transaction->rollBack();
            $this->session->setFlash('danger', 'Erro na importação - ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the TabSici model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabSici the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabSiciSearch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIncluirAcesso() {
        $this->module->module->layout = null;
        $empresasSessao = (\Yii::$app->session->get('empresasSessao')) ? \Yii::$app->session->get('empresasSessao') : [];
        $post = Yii::$app->request->post();
        $sici = new \app\modules\posoutorga\models\TabSiciSearch();

        $sici->load($post);

        if ($post['TabSiciSearch']['cod_sici']) {
            $transaction = Yii::$app->db->beginTransaction();
            try {

                if ($post['TabEmpresaMunicipioSearch'][0]['cod_empresa_municipio'] && strpos($post['TabEmpresaMunicipioSearch'][0]['cod_empresa_municipio'], 'N') === false) {
                    $empresa = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()->where(['cod_empresa_municipio' => $post['TabEmpresaMunicipioSearch'][0]['cod_empresa_municipio']])->one();
                    if ($post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMF']['cod_plano']) {
                        $planof_municipio = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['cod_plano' => $post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMF']['cod_plano']])->one();
                    } else {

                        $planof_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                    }
                    if ($post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMJ']['cod_plano']) {

                        $planoj_municipio = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['cod_plano' => $post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMJ']['cod_plano']])->one();
                    } else {

                        $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                    }
                } else {

                    $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
                    $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                    $planof_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                }
                $empresa->attributes = $post['TabEmpresaMunicipioSearch'][0];
                $empresa->cod_sici_fk = $post['TabSiciSearch']['cod_sici'];
                $empresa->save();
                unset($post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMF']['cod_plano']);

                $planof_municipio->attributes = $post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMF'];
                $planof_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');
                $planof_municipio->tipo_tabela_fk = $empresa->tableName();
                $planof_municipio->cod_chave = $empresa->cod_empresa_municipio;
                $planof_municipio->save();

                unset($post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMJ']['cod_plano']);

                $planoj_municipio->attributes = $post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMJ'];
                $planoj_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');
                $planoj_municipio->tipo_tabela_fk = $empresa->tableName();
                $planoj_municipio->cod_chave = $empresa->cod_empresa_municipio;
                $planoj_municipio->save();


                $transaction->commit();
            } catch (Exception $e) {

                $transaction->rollBack();
                $this->session->setFlash('danger', 'Erro na importação - ' . $e->getMessage());
            }
            $empresasDados = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()->where(['cod_sici_fk' => $post['TabSiciSearch']['cod_sici']])->orderBy('uf, cod_municipio_fk')->all();

            foreach ($empresasDados as $key => $empresa) {

                $planof_municipio = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $empresa->tableName(), 'cod_chave' => $empresa->cod_empresa_municipio, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F')])->one();
                $arrayF = $planof_municipio->attributes;
                $arrayF['tipo_pessoa'] = 'Física';

                $planoj_municipio = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $empresa->tableName(), 'cod_chave' => $empresa->cod_empresa_municipio, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J')])->one();
                $arrayJ = $planoj_municipio->attributes;
                $arrayJ['tipo_pessoa'] = 'Juridica';

                $totais = $empresa->calculaTotais($planof_municipio, $planoj_municipio);

                $totais['tipo_pessoa'] = 'Totais';
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

                $empresas[] = $empresa;
                $empresasSessao[$empresa->cod_empresa_municipio] = [$empresa->attributes, $planof_municipio->attributes, $planoj_municipio->attributes];
            }
        } else {

            if ($post['TabEmpresaMunicipioSearch'][0]['cod_empresa_municipio']) {

                foreach ($empresasSessao as $key => $value) {
                    if ($value[0]['cod_empresa_municipio'] == $post['TabEmpresaMunicipioSearch'][0]['cod_empresa_municipio']) {
                        $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
                        $empresa->attributes = $post['TabEmpresaMunicipioSearch'][0];
                        $empresa->cod_empresa_municipio = $empresa->cod_empresa_municipio = 'N_' . rand(100000000, 999999999);

                        $planof_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                        $planof_municipio->attributes = $post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMF'];
                        $planof_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');

                        $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                        $planoj_municipio->attributes = $post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMJ'];
                        $planoj_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');
                        $a = true;
                    } else {
                        $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
                        $empresa->attributes = $value[0];
                        $empresa->cod_empresa_municipio = $value[0]['cod_empresa_municipio'];

                        $planof_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                        $planof_municipio->attributes = $value[1];
                        $planof_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');

                        $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                        $planoj_municipio->attributes = $value[2];
                        $planoj_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');
                        $a = false;
                    }


                    $empresasDados[] = [$empresa, $planof_municipio, $planoj_municipio, $a];
                }

                $empresasSessao = NULL;
            } else {

                $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
                $empresa->attributes = $post['TabEmpresaMunicipioSearch'][0];
                $empresa->cod_empresa_municipio = $post['TabEmpresaMunicipioSearch'][0]['cod_empresa_municipio'];

                $planof_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                $planof_municipio->attributes = $post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMF'];
                $planof_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');

                $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                $planoj_municipio->attributes = $post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMJ'];
                $planoj_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');

                $empresasDados[] = [$empresa, $planof_municipio, $planoj_municipio, true];

                foreach ($empresasSessao as $key => $value) {


                    $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
                    $empresa->attributes = $value[0];
                    $empresa->cod_empresa_municipio = $value[0]['cod_empresa_municipio'];

                    $planof_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                    $planof_municipio->attributes = $value[1];
                    $planof_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');

                    $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                    $planoj_municipio->attributes = $value[2];
                    $planoj_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');


                    $empresasDados[] = [$empresa, $planof_municipio, $planoj_municipio, false];
                }
                $empresasSessao = NULL;
            }

            foreach ($empresasDados as $key => $emp) {

                $empresa = $emp[0];

                $planof_municipio = $emp[1];
                $planoj_municipio = $emp[2];
                $arrayF = $planof_municipio->attributes;
                $arrayF['tipo_pessoa'] = 'Física';

                $arrayJ = $planoj_municipio->attributes;
                $arrayJ['tipo_pessoa'] = 'Juridica';

                $totais = $empresa->calculaTotais($planof_municipio, $planoj_municipio, $emp[3]);

                $totais['tipo_pessoa'] = 'Totais';
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

                $empresas[] = $empresa;
                $empresasSessao[$empresa->cod_empresa_municipio] = [$empresa->attributes, $planof_municipio->attributes, $planoj_municipio->attributes];
            }
        }

        \Yii::$app->session->set('empresasSessao', $empresasSessao);
        $form = \yii\widgets\ActiveForm::begin();

        $dados = $this->render('_form_distribuicao', compact('form', 'empresas'));

        return \yii\helpers\Json::encode($dados);
    }

    public function actionCarregarAcesso() {
        $this->module->module->layout = null;
        $empresasSessao = \Yii::$app->session->get('empresasSessao');

        return \yii\helpers\Json::encode($empresasSessao[Yii::$app->request->post()['cod']]);
    }

    public function actionExcluirAcesso() {
        $this->module->module->layout = null;

        $post = Yii::$app->request->post();

        try {
            $transaction = Yii::$app->db->beginTransaction();

            $empresa = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()->where(['cod_empresa_municipio' => $post['cod']])->one();
            $cod_sici = $empresa->cod_sici_fk;

            \app\modules\posoutorga\models\TabPlanosSearch::deleteAll(['tipo_tabela_fk' => $empresa->tableName(), 'cod_chave' => $empresa->cod_empresa_municipio]);

            $empresa->delete();


            $transaction->commit();
        } catch (Exception $e) {

            $transaction->rollBack();
            $this->session->setFlash('danger', 'Erro na importação - ' . $e->getMessage());
        }
        $empresasDados = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()->where(['cod_sici_fk' => $cod_sici])->orderBy('uf, cod_municipio_fk')->all();
        $empresasSessao = [];
        $empresas = [];
        if ($empresasDados) {
            foreach ($empresasDados as $key => $empresa) {

                $planof_municipio = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $empresa->tableName(), 'cod_chave' => $empresa->cod_empresa_municipio, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F')])->one();
                $arrayF = $planof_municipio->attributes;
                $arrayF['tipo_pessoa'] = 'Física';

                $planoj_municipio = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $empresa->tableName(), 'cod_chave' => $empresa->cod_empresa_municipio, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J')])->one();
                $arrayJ = $planoj_municipio->attributes;
                $arrayJ['tipo_pessoa'] = 'Juridica';

                $totais = $empresa->calculaTotais($planof_municipio, $planoj_municipio);

                $totais['tipo_pessoa'] = 'Totais';
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

                $empresas[] = $empresa;
                $empresasSessao[$empresa->cod_empresa_municipio] = [$empresa->attributes, $arrayF, $arrayJ];
            }
        }

        \Yii::$app->session->set('empresasSessao', $empresasSessao);


        $form = \yii\widgets\ActiveForm::begin();

        $dados = $this->render('_form_distribuicao', compact('form', 'empresas'));

        return \yii\helpers\Json::encode($dados);
    }

    public function retornaImportacao($rowData, $nome, $pos = false) {
        $i = 0;
        foreach ($rowData as $key => $value) {

            if ($pos) {
                if (strpos(strtoupper(trim(\projeto\Util::tirarAcentos($value[0][4]))), $nome) !== false ||
                        strpos(strtoupper(trim(\projeto\Util::tirarAcentos($value[0][1]))), $nome) !== false) {

                    $output = array_slice($rowData, $i);

                    return $output;
                }
            } else {
                if (strtoupper(trim(\projeto\Util::tirarAcentos($value[0][1]))) == $nome) {
                    $output = array_slice($rowData, $i);
                    return $output;
                }
            }
            $i++;
        }
    }

    public function actionVerificaCnpj() {

        $this->module->module->layout = null;
        $post = Yii::$app->request->post();

        $cliente = \app\models\TabClienteSearch::findOne(['cnpj' => $post['dados']]);

        if ($cliente) {
            $dados = $cliente->attributes;

            $contatoT = \app\models\TabContatoSearch::find()
                    ->where(['ativo' => true, 'tipo_tabela_fk' => $cliente->tableName(), 'chave_fk' => $cliente->cod_cliente, 'tipo' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T')])
                    ->orderBy('cod_contato desc')
                    ->one();

            $dados['contatoT'] = $contatoT->contato;

            $contatoC = \app\models\TabContatoSearch::find()
                    ->where(['ativo' => true, 'tipo_tabela_fk' => $cliente->tableName(), 'chave_fk' => $cliente->cod_cliente, 'tipo' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C')])
                    ->orderBy('cod_contato desc')
                    ->one();

            $dados['contatoC'] = $contatoC->contato;
        } else {
            $cliente = new \app\models\TabClienteSearch();
            $cliente->cnpj = $post['dados'];
            $cliente->buscaCliente();
            $dados = $cliente->attributes;
            $tel = explode('/', $cliente->dadosReceita->telefone);
            if ($tel[0]) {
                $dados['contatoT'] = trim($tel[0]);
            }
        }

        return \yii\helpers\Json::encode($dados);
    }

}
