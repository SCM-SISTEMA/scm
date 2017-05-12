<?php
$this->registerJsFile("@web/js/app/posoutorga.sici.js?{$this->app->version}", ['position' => $this::POS_END, 'depends' => [\app\assets\ProjetoAsset::className()]]);


/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

$sici = $importacao['sici'];

$cliente = $importacao['cliente'];

$contatoT = $importacao['contatoT'];
$contatoC = $importacao['contatoC'];

$planof = $importacao['planof'];
$planoj = $importacao['planoj'];

$planof_mn = $importacao['planof_mn'];
$planoj_mn = $importacao['planoj_mn'];

$empresas = $importacao['empresas'];
?>
<?php
$this->registerJsFile("@web/js/app/posoutorga.distribuicao.js?{$this->app->version}", ['position' => $this::POS_END, 'depends' => [\app\assets\ProjetoAsset::className()]]);
?>
<?php echo $this->render('_form_distribuicao_add', ['form'=>$form, 'anual' => $importacao['anual']]); ?> 

<?=
kartik\tabs\TabsX::widget([
    'items' => [
        [
            'label' => "<b style=\"color:#337ab7\">Empresa</b>",
            'content' => $this->render('_form_empresa', compact('sici', 'form', 'cliente', 'contatoT', 'contatoC')),
            'active' => true,
        ],
        [
            'label' => "<b style=\"color:#337ab7\">Financeiro</b>",
            'content' => $this->render('_form_financeiro', compact('sici', 'form')),
            'active' => false,
        ],
        [
            'label' => "<b style=\"color:#337ab7\">Funcionários</b>",
            'content' => $this->render('_form_funcionario', compact('sici', 'form')),
            'active' => false,
            'visible' => ($importacao['anual']) ? true : false,
        ],
        [
            'label' => "<b style=\"color:#337ab7\">Informações Adicionais</b>",
            'content' => $this->render('_form_adicionais', compact('sici', 'form')),
            'active' => false,
            'visible' => ($importacao['indicadores']) ? true : false,
        ],
         [
            'label' => "<b style=\"color:#337ab7\">Planos</b>",
            'content' => $this->render('_form_planos', compact('planoj', 'planof', 'planof_mn', 'planoj_mn', 'form')),
            'active' => false,
        ]
        ,
        [
            'label' => "<b style=\"color:#337ab7\">Acessos Físicos</b>",
            'content' => '<div id="acessoFisicoAll">'.$this->render('_form_distribuicao', compact('empresas', 'sici', 'form')).'</div>',
            'active' => false,
        ]
    ],
    'position' => kartik\tabs\TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false,
])
?>
