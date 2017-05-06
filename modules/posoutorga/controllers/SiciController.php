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
        $searchModel = new TabSiciSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->titulo = 'Gerenciar Sici';
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
        $this->titulo = 'Detalhar Sici';
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
     * Creates a new TabSici model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabSiciSearch();

        $this->titulo = 'Incluir Sici';
        $this->subTitulo = '';
        $importacao = [];
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $dados = \yii\web\UploadedFile::getInstance($model, 'file');

            if (array_key_exists('importar', Yii::$app->request->post())) {
                print_r(Yii::$app->request->post()); exit;
                $transaction = Yii::$app->db->beginTransaction();
                //$municipios = \Yii::$app->session->get('dados');
                $this->session->setFlashProjeto('success', 'update');

                return $this->redirect(['view', 'id' => $model->cod_sici]);
            } else {

                $importacao = $this->importExcel($dados->tempName, Yii::$app->request->post()['TabSiciSearch']);
                ;
            }
        }
        return $this->render('create', [
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


        //$row is start 2 because first row assigned for heading.         
        $i = 0;
        $sici = new TabSiciSearch();
        $teste = false;
        for ($row = 1; $row <= $highestRow; ++$row) {


            $rowDatas = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

            if ($teste == false && strtoupper($rowDatas[0][2]) == 'INFORMAÇÕES DA EMPRESA') {
                continue;
                $teste = true;
            }
            $rowData[] = $rowDatas;
            if ($i > 500) {
                break;
            }
            $i++;
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
        $key = 4;
        $cliente->razao_social = $rowData[$key][0][2];
        $sici->responsavel = $rowData[$key][0][9];
        $contatoT->contato = $rowData[$key][0][16];
        $contatoT->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T');

        $key += 5;
        $cliente->cnpj = $rowData[$key][0][2];
        $sici->mes_ano_referencia = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('mes', (int) $rowData[$key][0][9]);
        $contatoC->contato = $rowData[$key][0][16];
        $contatoC->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C');
        ;

        //INFORMAÇÕES FINANCEIRAS
        $key += 9;
        $sici->fust = $rowData[$key][0][9];

        $key += 3;
        $sici->valor_consolidado = $rowData[$key][0][9];

        $key += 3;
        $sici->receita_bruta = $rowData[$key][0][9];
        $sici->despesa_operacao_manutencao = $rowData[$key][0][20];

        $key += 3;
        $sici->aliquota_nacional = (100 * $rowData[$key][0][7]);
        $sici->despesa_publicidade = $rowData[$key][0][20];

        $key += 3;
        $sici->receita_icms = (100 * $rowData[$key][0][7]);
        $sici->despesa_vendas = $rowData[$key][0][20];
        $key += 3;
        $sici->receita_pis = (100 * $rowData[$key][0][7]);
        $sici->despesa_link = $rowData[$key][0][20];

        $key += 3;
        $sici->receita_confins = (100 * $rowData[$key][0][7]);

        $key += 3;
        $sici->receita_liquida = $rowData[$key][0][9];

        $key += 5;
        $sici->obs_receita = $rowData[$key][0][2];
        $sici->obs_despesa = $rowData[$key][0][13];
        $renda_bruta = \projeto\Util::decimalFormatForBank($sici->receita_bruta);
        $sici->total_aliquota = \projeto\Util::decimalFormatToBank($renda_bruta * \projeto\Util::decimalFormatForBank($sici->aliquota_nacional) / 100);
        $sici->total_icms = \projeto\Util::decimalFormatToBank($renda_bruta * ( \projeto\Util::decimalFormatForBank($sici->receita_icms) / 100) / 100);
        $sici->total_pis = \projeto\Util::decimalFormatToBank($renda_bruta * ( \projeto\Util::decimalFormatForBank($sici->receita_pis) / 100) / 100);
        $sici->total_confins = \projeto\Util::decimalFormatToBank($renda_bruta * ( \projeto\Util::decimalFormatForBank($sici->receita_confins) / 100) / 100);

        $sici->receita_liquida = \projeto\Util::decimalFormatToBank($renda_bruta - (\projeto\Util::decimalFormatForBank($sici->total_aliquota) ));
        $sici->total_despesa = \projeto\Util::decimalFormatToBank(\projeto\Util::decimalFormatForBank($sici->despesa_publicidade) +
                        \projeto\Util::decimalFormatForBank($sici->despesa_operacao_manutencao) +
                        \projeto\Util::decimalFormatForBank($sici->despesa_vendas) +
                        \projeto\Util::decimalFormatForBank($sici->despesa_link));
        //QUANTITATIVO DE FUNCIONÁRIOS
        $key += 13;
        $sici->qtd_funcionarios_fichados = $rowData[$key][0][7];
        $sici->qtd_funcionarios_terceirizados = $rowData[$key][0][19];

        $key += 3;
        $sici->num_central_atendimento = $rowData[$key][0][14];

        //INFORMAÇÕES ADICIONAIS - INDICADORES
        $key += 8;
        $sici->total_fibra_prestadora = $rowData[$key][0][7];
        $sici->total_fibra_terceiros = $rowData[$key][0][19];

        $key += 3;
        $sici->total_fibra_crescimento_prop_prestadora = $rowData[$key][0][7];
        $sici->total_fibra_crescimento_prop_terceiros = $rowData[$key][0][19];

        $key += 5;
        $sici->total_fibra_implantada_prestadora = $rowData[$key][0][7];
        $sici->total_fibra_implantada_terceiros = $rowData[$key][0][19];

        $key += 3;
        $sici->total_crescimento_prestadora = $rowData[$key][0][7];
        $sici->total_crescimento_terceiros = $rowData[$key][0][19];


        $key += 5;
        $sici->total_marketing_propaganda = $rowData[$key][0][19];

        $key += 3;
        $sici->aplicacao_equipamento = $rowData[$key][0][7];
        $sici->aplicacao_software = $rowData[$key][0][19];

        $key += 3;
        $sici->total_pesquisa_desenvolvimento = $rowData[$key][0][7];
        $sici->aplicacao_servico = $rowData[$key][0][19];

        $key += 3;
        $sici->aplicacao_callcenter = $rowData[$key][0][7];

        $sici->total_planta = \projeto\Util::decimalFormatToBank(\projeto\Util::decimalFormatForBank($sici->total_marketing_propaganda) +
                        \projeto\Util::decimalFormatForBank($sici->aplicacao_equipamento) +
                        \projeto\Util::decimalFormatForBank($sici->aplicacao_software) +
                        \projeto\Util::decimalFormatForBank($sici->total_pesquisa_desenvolvimento) +
                        \projeto\Util::decimalFormatForBank($sici->aplicacao_servico) +
                        \projeto\Util::decimalFormatForBank($sici->aplicacao_callcenter));
        //QUANTITATIVO DE FUNCIONÁRIOS

        $key += 5;
        $sici->faturamento_de = $rowData[$key][0][7];
        $sici->faturamento_industrial = $rowData[$key][0][19];

        $key += 3;
        $sici->faturamento_adicionado = $rowData[$key][0][7];

        //INFORMAÇÕES DO PLANO
        $key += 14;
        $planof->valor_512 = $rowData[$key][0][9];
        $planoj->valor_512 = $rowData[$key][0][20];

        $key += 3;
        $planof->valor_512k_2m = $rowData[$key][0][9];
        $planoj->valor_512k_2m = $rowData[$key][0][20];

        $key += 3;
        $planof->valor_2m_12m = $rowData[$key][0][9];
        $planoj->valor_2m_12m = $rowData[$key][0][20];

        $key += 3;
        $planof->valor_12m_34m = $rowData[$key][0][9];
        $planoj->valor_12m_34m = $rowData[$key][0][20];

        $key += 3;
        $planof->valor_34m = $rowData[$key][0][9];
        $planoj->valor_34m = $rowData[$key][0][20];

        $planof->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');
        $planoj->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');

        //INFORMAÇÕES DO PLANO Menor Maior
        $key += 5;
        $planof_mn->valor_menos_1m_ded = $rowData[$key][0][9];
        $planoj_mn->valor_menos_1m_ded = $rowData[$key][0][20];

        $key += 2;
        $planof_mn->valor_menos_1m = $rowData[$key][0][9];
        $planoj_mn->valor_menos_1m = $rowData[$key][0][20];

        $key += 2;
        $planof_mn->valor_maior_1m_ded = $rowData[$key][0][9];
        $planoj_mn->valor_maior_1m_ded = $rowData[$key][0][20];

        $key += 2;
        $planof_mn->valor_maior_1m = $rowData[$key][0][9];
        $planoj_mn->valor_maior_1m = $rowData[$key][0][20];


        $key += 4;
        $planof->obs = $rowData[$key][0][2];
        $planoj->obs = $rowData[$key][0][13];

        //DISTRIBUIÇÃO DO QUANTITATIVO DE ACESSOS FÍSICOS EM SERVIÇO
        $key += 11;

        for ($i = $key; $i < count($rowData); $i++) {


            if (strpos(strtoupper($rowData[$i][0][1]), 'MUNICÍPIO') !== false) {
                $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();

                if ($rowData[$i][0][4] && $rowData[$i][0][17]) {
                    $empresa->municipio = $rowData[$i][0][4];
                    $empresa->tecnologia = strtoupper(str_replace(' ', '', trim(\projeto\Util::retiraAcento(\projeto\Util::tirarAcentos($rowData[$i][0][17])))));
                
                    if ($empresa->tecnologia) {
                        $empresa->tecnologia = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tecnologia', $empresa->tecnologia);
                    }
                    $i += 3;
                    $empresa->uf = $rowData[$i][0][4];
                    $empresa->cod_municipio_fk = substr($rowData[$i][0][10], 0, 6);

                    if (!$empresa->cod_municipio_fk) {
                        $nome = strtoupper(\projeto\Util::tirarAcentos($empresa->municipio));

                        $uf = null;
                        if ($empresa->uf) {
                            $uf = "AND sgl_estado_fk='{$empresa->uf}'";
                        }

                        $municipio = \app\models\TabMunicipiosSearch::find()->where("(upper(txt_nome) ilike '%" . strtoupper($empresa->municipio) . "%' or upper(txt_nome) ilike '%" . $nome . "%') $uf")->asArray()->one();
                        if ($municipio) {
                            $empresa->cod_municipio_fk = $municipio['cod_municipio'];
                        }
                    }
                    $i += 5;
                    $planof_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                    $planof_municipio->valor_512 = $rowData[$i][0][4];
                    $planof_municipio->valor_512k_2m = $rowData[$i][0][7];
                    $planof_municipio->valor_2m_12m = $rowData[$i][0][10];
                    $planof_municipio->valor_12m_34m = $rowData[$i][0][13];
                    $planof_municipio->valor_34m = $rowData[$i][0][16];
                    $planof_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');


                    $i += 2;
                    $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                    $planoj_municipio->valor_512 = $rowData[$i][0][4];
                    $planoj_municipio->valor_512k_2m = $rowData[$i][0][7];
                    $planoj_municipio->valor_2m_12m = $rowData[$i][0][10];
                    $planoj_municipio->valor_12m_34m = $rowData[$i][0][13];
                    $planoj_municipio->valor_34m = $rowData[$i][0][16];
                    $planoj_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');

                    $planof_municipio->total_512 = \projeto\Util::decimalFormatToBank(
                                    \projeto\Util::decimalFormatForBank($planof_municipio->valor_512) +
                                    \projeto\Util::decimalFormatForBank($planoj_municipio->valor_512)
                    );

                    $planof_municipio->total_512k_2m = \projeto\Util::decimalFormatToBank(
                                    \projeto\Util::decimalFormatForBank($planof_municipio->valor_512k_2m) +
                                    \projeto\Util::decimalFormatForBank($planoj_municipio->valor_512k_2m)
                    );
                    $planof_municipio->total_2m_12m = \projeto\Util::decimalFormatToBank(
                                    \projeto\Util::decimalFormatForBank($planof_municipio->valor_2m_12m) +
                                    \projeto\Util::decimalFormatForBank($planoj_municipio->valor_2m_12m)
                    );
                    $planof_municipio->total_12m_34m = \projeto\Util::decimalFormatToBank(
                                    \projeto\Util::decimalFormatForBank($planof_municipio->valor_12m_34m) +
                                    \projeto\Util::decimalFormatForBank($planoj_municipio->valor_12m_34m)
                    );
                    $planof_municipio->total_34m = \projeto\Util::decimalFormatToBank(
                                    \projeto\Util::decimalFormatForBank($planof_municipio->valor_34m) +
                                    \projeto\Util::decimalFormatForBank($planoj_municipio->valor_34m)
                    );

                    $planof_municipio->total_fisica = \projeto\Util::decimalFormatToBank(
                                    \projeto\Util::decimalFormatForBank($planof_municipio->valor_512) +
                                    \projeto\Util::decimalFormatForBank($planof_municipio->valor_512k_2m) +
                                    \projeto\Util::decimalFormatForBank($planof_municipio->valor_2m_12m) +
                                    \projeto\Util::decimalFormatForBank($planof_municipio->valor_12m_34m) +
                                    \projeto\Util::decimalFormatForBank($planof_municipio->valor_34m)
                    );

                    $planoj_municipio->total_juridica = \projeto\Util::decimalFormatToBank(
                                    \projeto\Util::decimalFormatForBank($planoj_municipio->valor_512) +
                                    \projeto\Util::decimalFormatForBank($planoj_municipio->valor_512k_2m) +
                                    \projeto\Util::decimalFormatForBank($planoj_municipio->valor_2m_12m) +
                                    \projeto\Util::decimalFormatForBank($planoj_municipio->valor_12m_34m) +
                                    \projeto\Util::decimalFormatForBank($planoj_municipio->valor_34m)
                    );

                    $planof_municipio->total = \projeto\Util::decimalFormatToBank(
                                    \projeto\Util::decimalFormatForBank($planof_municipio->total_juridica) +
                                    \projeto\Util::decimalFormatForBank($planof_municipio->total_fisica)
                    );

                    $i += 5;
                    $empresa->capacidade_municipio = $rowData[$i][0][7];
                    $empresa->capacidade_servico = $rowData[$i][0][20];
                    $i += 4;

                    $empresas[] = [$empresa, $planof_municipio, $planoj_municipio];
                } else {
                    //só de sacanagem..rsrs
                    $i += 3;
                    $i += 5;
                    $i += 2;
                    $i += 5;
                    $i += 5;
                }
            }
        }

        return compact('sici', 'cliente', 'contatoC', 'contatoT', 'planof', 'planof_mn', 'planoj', 'planoj_mn', 'empresas');
    }

    /**
     * Updates an existing TabSici model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $this->titulo = 'Alterar Sici';
        $this->subTitulo = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_sici]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TabSici model.
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
     * Finds the TabSici model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabSici the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabSici::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
