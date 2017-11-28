<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\TabContato */
/* @var $form yii\widgets\ActiveForm */
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

Modal::begin([
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'header' => '<h3><div id="tituloAndamento">Incluir Andamento</div></h3>',
    'id' => 'modalAndamento',
    'closeButton' => false,
    'size' => 'modal-lg',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Incluir Andamento', [
        'id' => 'botaoSalvarAndamento',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);



$model = new \app\models\TabAndamentoSearch();

?>

<div id="formAndamento">


    <div class='row'>
        <div class='col-lg-6'>
            <?=
            $form->field($model, 'dt_retorno')->widget(
                    \dosamigos\datepicker\DatePicker::className(), [
                'language' => 'pt-BR',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy'
                ]
            ]);
            ?>
        </div>
    </div>

    <div class='row'>
        <div class='col-lg-12'>
            <?= $form->field($model, 'txt_notificacao')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <?= $form->field($model, 'cod_setor_fk')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'cod_contrato')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'tipo_andamento')->hiddenInput()->label(false); ?>


    <div id="gridModalAndamento">

    </div>

</div>

<?php Modal::end(); ?>