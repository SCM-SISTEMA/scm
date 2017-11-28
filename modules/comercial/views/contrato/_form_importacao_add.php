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
    'header' => '<h3><div id="tituloTipoImportacao">Incluir Importacao</div></h3>',
    'id' => 'modalImportacao',
    'closeButton' => false,
    'size' => 'modal-md',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Incluir Importacao', [
        'id' => 'botaoSalvarImportacao',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);



$contrato = new \app\modules\comercial\models\TabContratoSearch();
?>

<div id="formImportacaoAdd">
    <div class='row'>
        <div class='col-lg-12'>
            <?= $form->field($contrato, 'file')->fileInput(  ['id' => 'tabimportacaosearch-file', 'name' => 'TabImportacaoSearch[file]']) ?>
        </div>

    </div>
    <?= $form->field($contrato, 'cod_contrato')->hiddenInput(  ['id' => 'tabimportacaosearch-cod_contrato', 'name' => 'TabImportacaoSearch[cod_contrato]'])->label(false); ?>

</div>

<?php Modal::end(); ?>