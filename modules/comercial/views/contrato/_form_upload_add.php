<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TabContato */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'header' => '<h3><div id="tituloTipoAnexo">Anexar arquivo</div></h3>',
    'id' => 'modalAnexo',
    'closeButton' => false,
    'size' => 'modal-md',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Incluir Anexo', [
        'id' => 'botaoSalvarAnexo',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);



$contrato = new \app\modules\comercial\models\TabContratoSearch();
?>

<div id="formAnexoAdd">
    <div class='row'>
        <div class='col-lg-12'>
            <?= $form->field($contrato, 'file')->fileInput(  ['id' => 'tabanexosearch-file', 'name' => 'TabAnexoSearch[file]']) ?>
        </div>

    </div>
    <div class='row'>
        <div class='col-lg-12' id="listaAnexo">
            
        </div>

    </div>
    <?= $form->field($contrato, 'cod_contrato')->hiddenInput(  ['id' => 'tabanexosearch-cod_contrato', 'name' => 'TabAnexoSearch[cod_contrato]'])->label(false); ?>

</div>

<?php Modal::end(); ?>