<?php



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
        ],
        [
            'label' => "<b style=\"color:#337ab7\">Informações Adicionais</b>",
            'content' => $this->render('_form_adicionais', compact('sici', 'form')),
            'active' => false,
        ],
         [
            'label' => "<b style=\"color:#337ab7\">Planos</b>",
            'content' => $this->render('_form_planos', compact('planoj', 'planof', 'planof_mn', 'planoj_mn', 'form')),
            'active' => false,
        ]
        ,
        [
            'label' => "<b style=\"color:#337ab7\">Empresa/Região</b>",
            'content' => $this->render('_form_distribuicao', compact('empresas', 'sici', 'form')),
            'active' => false,
        ]
    ],
    'position' => kartik\tabs\TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false,
])
?>
