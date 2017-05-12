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
     * Updates an existing TabSici model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $sici = $this->findModel($id);
        $sici->calculaTotais();
        $tc = \app\modules\comercial\models\TabTipoContratoSearch::findOne($sici->cod_tipo_contrato_fk);
        $c = \app\modules\comercial\models\TabContratoSearch::findOne($tc->cod_contrato_fk);
        $cliente = \app\models\TabClienteSearch::findOne($c->cod_cliente_fk);

        $contatoT = \app\models\TabContatoSearch::find()
                ->where(['ativo' => true, 'tipo_tabela_fk' => $cliente->tableName(), 'chave_fk' => $cliente->cod_cliente, 'tipo' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T')])
                ->orderBy('cod_contato desc')
                ->one();

        $contatoC = \app\models\TabContatoSearch::find()
                ->where(['ativo' => true, 'tipo_tabela_fk' => $cliente->tableName(), 'chave_fk' => $cliente->cod_cliente, 'tipo' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C')])
                ->orderBy('cod_contato desc')
                ->one();

        $planof = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $sici->tableName(), 'cod_chave' => $sici->cod_sici, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F')])->one();
        $planoj = \app\modules\posoutorga\models\TabPlanosSearch::find()->where(['tipo_tabela_fk' => $sici->tableName(), 'cod_chave' => $sici->cod_sici, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J')])->one();

        $planof_mn = \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch::find()->where(['cod_sici_fk' => $sici->cod_sici, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F')])->one();
        $planoj_mn = \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch::find()->where(['cod_sici_fk' => $sici->cod_sici, 'tipo_plano_fk' => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J')])->one();

        $empresasDados = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()->where(['cod_sici_fk' => $sici->cod_sici])->orderBy('uf')->all();

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

        \Yii::$app->session->set('empresasSessao', $empresasSessao);

        $sici->qntAcesso = count($empresas);

        $this->titulo = 'Alterar Sici';
        $this->subTitulo = '';

        if (Yii::$app->request->post()) {

            $this->session->setFlashProjeto('success', 'update');

            return $this->redirect(['view', 'id' => $model->cod_sici]);
        } else {


            $importacao = compact('sici', 'cliente', 'contatoC', 'contatoT', 'planof', 'planof_mn', 'planoj', 'planoj_mn', 'empresas');

            return $this->render('update', [
                        'importacao' => $importacao
                            ]
            );
        }
    }

    public function actionGerar($cod_sici) {


        $dom = new \DOMDocument('1.0', "UTF-8");

        $root = $dom->createElement('root');

        $sici = TabSiciSearch::find($cod_sici)->one();
        $contrato = $sici->tabTipoContrato->tabContrato;
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
        $ITEM4->value = 'ITEM4';
        $indicador->appendChild($ITEM4);

        $conteudo = $dom->createElement('Conteudo');
        $uf = $dom->createAttribute('uf');
        $item = $dom->createAttribute('item');
        $valor = $dom->createAttribute('valor');
        $uf->value = $endereco->tabMunicipios->sgl_estado_fk;
        $item->value = 'a';
        $valor->value = empty($sici->qtd_funcionarios_fichados) ? '0,00' : \projeto\Util::decimalFormatToBank($sici->qtd_funcionarios_fichados);
        $conteudo->appendChild($uf);
        $conteudo->appendChild($item);
        $conteudo->appendChild($valor);
        $indicador->appendChild($conteudo);

        $outorga->appendChild($indicador);


        // ITEM5
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'ITEM5';
        $indicador->appendChild($ITEM);


        $conteudo = $dom->createElement('Conteudo');
        $uf = $dom->createAttribute('uf');
        $item = $dom->createAttribute('item');
        $valor = $dom->createAttribute('valor');
        $uf->value = $endereco->tabMunicipios->sgl_estado_fk;
        $item->value = 'a';
        $valor->value = empty($sici->qtd_funcionarios_terceirizados) ? '0,00' : \projeto\Util::decimalFormatToBank($sici->qtd_funcionarios_terceirizados);
        $conteudo->appendChild($uf);
        $conteudo->appendChild($item);
        $conteudo->appendChild($valor);
        $indicador->appendChild($conteudo);

        $outorga->appendChild($indicador);


        // ITEM9
        $planos = \app\modules\posoutorga\models\TabPlanosSearch::getITEM9($sici->cod_sici, $sici->tableName());
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'ITEM9';
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
        $planosMM = \app\modules\posoutorga\models\TabPlanosMenorMaiorSearch::getITEM10($sici->cod_sici);
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'ITEM10';
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
                $valor->value = empty($faixa) ? '0,00' : \projeto\Util::decimalFormatToBank($faixa);

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



        // QAIPL4SM
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'QAIPL4SM';
        $indicador->appendChild($ITEM);

        $empresa_municipio = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::getQAIPL4SM($cod_sici);
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
                $valor->value = empty($tecno['total']) ? '0,00' : \projeto\Util::decimalFormatToBank($tecno['total']);

                $conteudo->appendChild($nome);
                $conteudo->appendChild($valor);

                $tecnologia->appendChild($tItem);

                foreach ($tecno as $i => $val) {

                    if ($i == 'total') {
                        $conteudo = $dom->createElement('Conteudo');
                        $nome = $dom->createAttribute('nome');
                        $valor = $dom->createAttribute('valor');
                        $nome->value = $i;
                        $valor->value = empty($val) ? '0,00' : \projeto\Util::decimalFormatToBank($val);

                        $conteudo->appendChild($nome);
                        $conteudo->appendChild($valor);
                    } else {

                        $conteudo = $dom->createElement('Conteudo');
                        $faixa = $dom->createAttribute('faixa');
                        $valor = $dom->createAttribute('valor');
                        $faixa->value = $i;
                        $valor->value = empty($val) ? '0,00' : \projeto\Util::decimalFormatToBank($val);

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



        // IPL6IM
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IPL6IM';
        $indicador->appendChild($ITEM);

        $empresa_municipio = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::getIPL6IM($cod_sici);

        foreach ($empresa_municipio as $key => $value) {

            $conteudo = $dom->createElement('Conteudo');
            $codmunicipio = $dom->createAttribute('codmunicipio');
            $valor = $dom->createAttribute('valor');
            $codmunicipio->value = $key;
            $valor->value = empty($value['capacidade_municipio']) ? '0,00' : \projeto\Util::decimalFormatToBank($value['capacidade_municipio']);

            $conteudo->appendChild($codmunicipio);
            $conteudo->appendChild($valor);
            $indicador->appendChild($conteudo);
        }


        $outorga->appendChild($indicador);


        // IAU1
        $indicador = $dom->createElement('Indicador');
        $ITEM = $dom->createAttribute('Sigla');
        $ITEM->value = 'IAU1';
        $indicador->appendChild($ITEM);

        $conteudo = $dom->createElement('Conteudo');
        $valor = $dom->createAttribute('valor');
        $valor->value = empty($sici->num_central_atendimento) ? '0,00' : $sici->num_central_atendimento;

        $conteudo->appendChild($valor);
        $indicador->appendChild($conteudo);


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
            $valor->value = empty($value) ? '0,00' : \projeto\Util::decimalFormatToBank($value);

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
            $valor->value = empty($value) ? '0,00' : \projeto\Util::decimalFormatToBank($value);

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

            $valor->value = empty($value) ? '0,00' : \projeto\Util::decimalFormatToBank($value);

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

            $valor->value = empty($value) ? '0,00' : \projeto\Util::decimalFormatToBank($value);

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
        $valor->value = empty($sici->valor_consolidado) ? '0,00' : \projeto\Util::decimalFormatToBank($sici->valor_consolidado);

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
        $valor->value = empty($sici->receita_bruta) ? '0,00' : \projeto\Util::decimalFormatToBank($sici->receita_bruta);

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
        $valor->value = empty($sici->receita_liquida) ? '0,00' : \projeto\Util::decimalFormatToBank($sici->receita_liquida);

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

            $valor->value = empty($value) ? '0,00' : \projeto\Util::decimalFormatToBank($value);

            $conteudo->appendChild($item);
            $conteudo->appendChild($valor);

            $indicador->appendChild($conteudo);
        }
        $outorga->appendChild($indicador);


        $uploadSICI->appendChild($outorga);
        $root->appendChild($uploadSICI);
        $dom->appendChild($root);

        $nome = \projeto\Util::retiraCaracter($cliente->cnpj) . '_' . $sici->cod_sici . '_' . str_replace('/', '', $sici->mes_ano_referencia) . '.xml';
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
    public function actionCreate() {
        $model = new TabSiciSearch();

        $this->titulo = 'Incluir Sici';
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

                    $cliente->load($post);
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
                    } else {
                        $cliente = $cli;


                        $contrato = \app\modules\comercial\models\TabContratoSearch::find()->where(['cod_cliente_fk' => $cliente->cod_cliente])->one();

                        $tipo_contrato = \app\modules\comercial\models\TabTipoContrato::find()->where(['cod_contrato_fk' => $contrato->cod_contrato])->one();

                        $sici->cod_tipo_contrato_fk = $tipo_contrato->cod_tipo_contrato;
                        $sici->save();


                        if (!$contato) {
                            $contatoT->tipo_tabela_fk = $cliente->tableName();
                            $contatoT->chave_fk = $cliente->cod_cliente;
                            $contatoT->save();
                        }

                        $contato_numero = str_replace(' ', '', $contatoC->contato);

                        $contato = \app\models\TabContatoSearch()->find()->where(['contato' => $contato_numero, 'tipo_tabela_fk' => $cliente->tableName(), 'chave_fk' => $cliente->cod_cliente]);

                        if (!$contato && \projeto\Util::retiraCaracter($contatoT->contato) != \projeto\Util::retiraCaracter($contatoC->contato)) {

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
                    $planoj_mn->cod_sici = $sici->cod_sici;
                    $planoj_mn->save();

                    foreach (Yii::$app->request->post()['TabEmpresaMunicipioSearch'] as $municipio) {
                        $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
                        $empresa->attributes = $municipio;
                        $empresa->cod_sici_fk = $sici->cod_sici;
                        $empresa->save();

                        $planof_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                        $planof_municipio->attributes = $municipio['TabEmpresaMunicipioSearchMF'];
                        $planof_municipio->tipo_tabela_fk = $empresa->tableName();
                        $planof_municipio->cod_chave = $empresa->cod_empresa_municipio;
                        $planof_municipio->save();

                        $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                        $planoj_municipio->attributes = $municipio['TabEmpresaMunicipioSearchMJ'];
                        $planoj_municipio->tipo_tabela_fk = $empresa->tableName();
                        $planoj_municipio->cod_chave = $empresa->cod_empresa_municipio;
                        $planoj_municipio->save();
                    }
                    //$sici->mes_ano_referencia = $dados_sici['mes_ano_referencia'];
                    $transaction->commit();

                    $this->session->setFlashProjeto('success', 'update');

                    return $this->redirect(['view', 'id' => $sici->cod_sici]);
                } catch (Exception $e) {

                    $transaction->rollBack();
                    $this->session->setFlash('danger', 'Erro na importação - ' . $e->getMessage());
                }
                //$municipios = \Yii::$app->session->get('dados');
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

            /*
              if ($teste==false && strtoupper(trim(\projeto\Util::tirarAcentos($rowDatas[0][1]))) != 'INFORMACOES DA EMPRESA') {
              continue;
              }
              $teste = true; */
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
        $cliente->razao_social = $rowData[$key][0][2];
        $sici->responsavel = $rowData[$key][0][9];
        $contatoT->contato = $rowData[$key][0][16];
        $contatoT->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'T');
        $key += 5;
        $cliente->cnpj = $rowData[$key][0][2];
        
        $dt_referencia  =(  \PHPExcel_Style_NumberFormat::toFormattedString($rowData[$key][0][9],'MM/YYYY' ));
 
      
        $sici->mes_ano_referencia = $dt_referencia;

        $contatoC->contato = $rowData[$key][0][16];
        $contatoC->tipo = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contato', 'C');
        ;


        $rowData = $this->retornaImportacao($rowData, 'RECEITA');
        //INFORMAÇÕES FINANCEIRAS
        $key = 2;
        $sici->legenda = $rowData[$key][0][9];

        $key += 3;
        $anual = false;

        if (strpos(strtoupper($rowData[$key][0][1]), 'BRUTA') === false) {
            $anual = true;
            $sici->valor_consolidado = $rowData[$key][0][9];

            $key += 3;
        }
        

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

        if ($anual) {
            //QUANTITATIVO DE FUNCIONÁRIOS
            $rowDataA = $this->retornaImportacao($rowData, 'QUANTITATIVO', TRUE);

            if ($rowDataA) {
                $key = 3;
                $sici->qtd_funcionarios_fichados = $rowDataA[$key][0][7];
                $sici->qtd_funcionarios_terceirizados = $rowDataA[$key][0][19];

                $key += 3;
                $sici->num_central_atendimento = $rowDataA[$key][0][14];
            }
            //INFORMAÇÕES ADICIONAIS - INDICADORES
            $rowDataA = $this->retornaImportacao($rowDataA, 'INDICADORES', TRUE);

            $indicadores = false;
            if ($rowDataA) {
                $indicadores = true;
                $key = 4;

                $sici->total_fibra_prestadora = $rowDataA[$key][0][7];
                $sici->total_fibra_terceiros = $rowDataA[$key][0][19];

                $key += 3;
                $sici->total_fibra_crescimento_prop_prestadora = $rowDataA[$key][0][7];
                $sici->total_fibra_crescimento_prop_terceiros = $rowDataA[$key][0][19];

                $key += 5;
                $sici->total_fibra_implantada_prestadora = $rowDataA[$key][0][7];
                $sici->total_fibra_implantada_terceiros = $rowDataA[$key][0][19];

                $key += 3;
                $sici->total_crescimento_prestadora = $rowDataA[$key][0][7];
                $sici->total_crescimento_terceiros = $rowDataA[$key][0][19];


                $key += 5;
                $sici->total_marketing_propaganda = $rowDataA[$key][0][19];

                $key += 3;
                $sici->aplicacao_equipamento = $rowDataA[$key][0][7];
                $sici->aplicacao_software = $rowDataA[$key][0][19];

                $key += 3;
                $sici->total_pesquisa_desenvolvimento = $rowDataA[$key][0][7];
                $sici->aplicacao_servico = $rowDataA[$key][0][19];

                $key += 3;
                $sici->aplicacao_callcenter = $rowDataA[$key][0][7];

                $sici->total_planta = \projeto\Util::decimalFormatToBank(\projeto\Util::decimalFormatForBank($sici->total_marketing_propaganda) +
                                \projeto\Util::decimalFormatForBank($sici->aplicacao_equipamento) +
                                \projeto\Util::decimalFormatForBank($sici->aplicacao_software) +
                                \projeto\Util::decimalFormatForBank($sici->total_pesquisa_desenvolvimento) +
                                \projeto\Util::decimalFormatForBank($sici->aplicacao_servico) +
                                \projeto\Util::decimalFormatForBank($sici->aplicacao_callcenter));
                //QUANTITATIVO DE FUNCIONÁRIOS

                $key += 5;
                $sici->faturamento_de = $rowDataA[$key][0][7];
                $sici->faturamento_industrial = $rowDataA[$key][0][19];

                $key += 3;
                $sici->faturamento_adicionado = $rowDataA[$key][0][7];
                $rowData = $rowDataA;
            }
        }

        $rowData = $this->retornaImportacao($rowData, 'MENOR OU IGUAL', true);

        //INFORMAÇÕES DO PLANO
        $key = 0;
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

        $planof_mn->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');
        $planoj_mn->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');

        $key += 4;
        $planof->obs = $rowData[$key][0][2];
        $planoj->obs = $rowData[$key][0][13];

        //DISTRIBUIÇÃO DO QUANTITATIVO DE ACESSOS FÍSICOS EM SERVIÇO
        $rowData = $this->retornaImportacao($rowData, 'ACESSO', true);
        $key = 3;

        for ($i = $key; $i < count($rowData); $i++) {


            if (strpos(strtoupper($rowData[$i][0][1]), 'MUNICÍPIO') !== false) {
                $empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();

                if ($rowData[$i][0][4] && $rowData[$i][0][17]) {
                    $empresa->municipio = $rowData[$i][0][4];
                    $empresa->tecnologia_fk = strtoupper(str_replace(' ', '', trim(\projeto\Util::retiraAcento(\projeto\Util::tirarAcentos($rowData[$i][0][17])))));
                    if ($empresa->tecnologia_fk) {
                        $empresa->tecnologia_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tecnologia', $empresa->tecnologia_fk, true);
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

                        $municipio = \app\models\TabMunicipiosSearch::find()->where("(upper(txt_nome_sem_acento) ilike '%" . $nome . "%' or upper(txt_nome) ilike '%" . strtoupper($empresa->municipio) . "%') $uf")->asArray()->one();

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
                    $arrayF = $planof_municipio->attributes;
                    $arrayF['tipo_pessoa'] = 'Física';

                    $i += 2;
                    $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                    $planoj_municipio->valor_512 = $rowData[$i][0][4];
                    $planoj_municipio->valor_512k_2m = $rowData[$i][0][7];
                    $planoj_municipio->valor_2m_12m = $rowData[$i][0][10];
                    $planoj_municipio->valor_12m_34m = $rowData[$i][0][13];
                    $planoj_municipio->valor_34m = $rowData[$i][0][16];
                    $planoj_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');
                    $arrayJ = $planoj_municipio->attributes;
                    $arrayJ['tipo_pessoa'] = 'Juridica';

                    $totais = $empresa->calculaTotais($planof_municipio, $planoj_municipio);

                    $totais['tipo_pessoa'] = 'Totais';
                    $arrayF['total'] = $empresa->total_fisica;
                    $arrayJ['total'] = $empresa->total_juridica;

                    $i += 5;
                    $empresa->capacidade_municipio = $rowData[$i][0][7];
                    $empresa->capacidade_servico = $rowData[$i][0][20];
                    $i += 4;

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
        \Yii::$app->session->set('empresasSessao', $empresasSessao);

        return compact('sici', 'cliente', 'contatoC', 'contatoT', 'planof', 'planof_mn', 'planoj', 'planoj_mn', 'empresas', 'anual', 'indicadores');
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
        if (($model = TabSiciSearch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIncluirAcesso() {
        $this->module->module->layout = null;
        $empresasSessao = \Yii::$app->session->get('empresasSessao');
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
            $empresasDados = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()->where(['cod_sici_fk' => $post['TabSiciSearch']['cod_sici']])->orderBy('uf')->all();

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
                        $empresa->cod_empresa_municipio = $post['TabEmpresaMunicipioSearch'][0]['cod_empresa_municipio'];

                        $planof_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                        $planof_municipio->attributes = $post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMF'];
                        $planof_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'F');

                        $planoj_municipio = new \app\modules\posoutorga\models\TabPlanosSearch();
                        $planoj_municipio->attributes = $post['TabEmpresaMunicipioSearch'][0]['TabEmpresaMunicipioSearchMJ'];
                        $planoj_municipio->tipo_plano_fk = \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-pessoa-plano', 'J');
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
                    }

                    $empresasDados[] = [$empresa, $planof_municipio, $planoj_municipio];
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

                $empresasDados[] = [$empresa, $planof_municipio, $planoj_municipio];

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


                    $empresasDados[] = [$empresa, $planof_municipio, $planoj_municipio];
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
        $empresasDados = \app\modules\posoutorga\models\TabEmpresaMunicipioSearch::find()->where(['cod_sici_fk' => $cod_sici])->orderBy('uf')->all();
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

}
