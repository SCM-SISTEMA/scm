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
    'header' => '<h3><div id="tituloTipoModelo">Editar impressão do contrato</div></h3>',
    'id' => 'modalModelo',
    'closeButton' => false,
    'size' => 'modal-lg',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Gerar PDF', [
        'id' => 'botaoSalvarModelo',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);



$model = new \app\modules\comercial\models\TabModeloContratoSearch();
?>

<div id="formModelo">
    <div class='row'>
        <div class='col-lg-12'>
            <?=
            $form->field($model, 'txt_modelo')->widget(\dosamigos\tinymce\TinyMce::className(), [
                
                'options' => ['rows' => 12],
                'language' => 'pt_BR',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link charmap print preview anchor textcolor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor"
                ]
            ])
            ?>

        </div>
    </div>

    <?= $form->field($model, 'cod_modelo_contrato')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'cod_contrato_fk')->hiddenInput()->label(false); ?>
</div>
<?php Modal::end(); ?>