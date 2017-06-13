<?php

$addon = (Yii::$app->request->get() || $this->context->module->module->controller->action->id=='importar') ? ["template" => "{label}\n
                <div class='input-group'>
                  <span class='input-group-addon checado_vermelho'>
                   
        <a href='#' class='addonlink dropdown-toggle' data-toggle='dropdown'>
                   
                        <i class='fa fa-check-circle'></i>
                   
                  
                  </a>
                  </span>
                {input}
            </div>
            \n{hint}
            \n{error}"] 
        : ["template" => "{label}\n{input}\n{hint}\n{error}"];

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
$tipo_sici = \app\models\TabAtributosValoresSearch::find()->where(['cod_atributos_valores' => $sici->tipo_sici_fk])->one()->sgl_valor;

$anual = ($tipo_sici == 'S' || $tipo_sici == 'A') ? true : false;
?>
<?php

$this->registerJsFile("@web/js/app/posoutorga.distribuicao.js?{$this->app->version}", ['position' => $this::POS_END, 'depends' => [\app\assets\ProjetoAsset::className()]]);
?>
<?php echo $this->render('_form_distribuicao_add', ['form' => $form, 'anual' => $anual]); ?> 

<?=

kartik\tabs\TabsX::widget([
    'id' => 'siciTab',
    'items' => [
        [
            'label' => "<b style=\"color:#337ab7\">Empresa</b>",
            'content' => $this->render('_form_empresa', compact('sici', 'form', 'cliente', 'contatoT', 'contatoC', 'addon')),
            'active' => true,
            'options' => ['id' => 'empresa'],
        ],
        [
            'label' => "<b style=\"color:#337ab7\">Financeiro</b>",
            'content' => $this->render('_form_financeiro', compact('sici', 'form', 'addon')),
            'active' => false,
            'options' => ['id' => 'financeiro'],
        ],
        [
            'label' => "<b style=\"color:#337ab7\">Funcionários</b>",
            'content' => $this->render('_form_funcionario', compact('sici', 'form', 'addon')),
            'active' => false,
            'options' => ['id' => 'funcionarios'],
        ],
        [
            'label' => "<b style=\"color:#337ab7\">Informações Adicionais</b>",
            'content' => $this->render('_form_adicionais', compact('sici', 'form', 'addon')),
            'active' => false,
            'options' => ['id' => 'informacoes-adicionais'],
        ],
        [
            'label' => "<b style=\"color:#337ab7\">Planos</b>",
            'options' => ['id' => 'planos'],
            'content' => $this->render('_form_planos', compact('planoj', 'planof', 'planof_mn', 'planoj_mn', 'form', 'addon')),
            'active' => false,
        ]
        ,
        [
            'label' => "<b style=\"color:#337ab7\">Acessos Físicos</b>",
            'options' => ['id' => 'acessos-fisicos'],
            'content' => '<div id="acessoFisicoAll">' . $this->render('_form_distribuicao', compact('empresas', 'sici', 'form', 'addon')) . '</div>',
            'active' => false,
        ]
    ],
    'position' => kartik\tabs\TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false,
])
?>
<?php

if ($tipo_sici == 'S' || $tipo_sici == 'A') {


    if ($tipo_sici == 'A') {
        $js = "$('#siciTab a[href=\"#informacoes-adicionais\"]').show();";
    }
    $js .= "$('#siciTab a[href=\"#funcionarios\"]').show();";
}


$this->registerJs("
            $('#siciTab a[href=\"#informacoes-adicionais\"]').hide();
            $('#siciTab a[href=\"#funcionarios\"]').hide();
            {$js}    
                
                
                ", \projeto\web\View::POS_READY, 'jsTipoSici'
);
?>