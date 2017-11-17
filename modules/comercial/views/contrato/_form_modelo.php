<?php

use yii\helpers\Html;
use dosamigos\ckeditor\CKEditor;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\TabContato */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'header' => '<h3><div id="tituloTipoModelo">Incluir Modelo</div></h3>',
    'id' => 'modalModelo',
    'closeButton' => false,
    'size' => 'modal-lg',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Incluir Modelo', [
        'id' => 'botaoSalvarModelo',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);



$model = new \app\modules\comercial\models\TabModeloContrato();


?>

<div id="formModelo">
    <div class='row'>
        <div class='col-lg-12'>
            <?= $form->field($model, 'txt_modelo')->widget(CKEditor::className(), [
					'options' => ['rows' => 6],
					'preset' => 'full'
				]) ?>
    
        </div>
    </div>
   
    <?= $form->field($model, 'cod_modelo_contrato')->hiddenInput()->label(false); ?>
</div>
<?php Modal::end(); ?>