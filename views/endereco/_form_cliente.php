<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TabEndereco */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'header' => '<h3><div id="tituloEndereco">Incluir Endereço</div></h3>',
    'id' => 'modalEndereco',
    'closeButton' => false,
    'size' => 'modal-md',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Incluir registro', [
        'id' => 'botaoSalvarEndereco',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);

$model = new app\models\TabEnderecoSearch();
?>

<div id="formEndereco">
    <?= $form->field($model, 'cod_endereco')->hiddenInput(['maxlength' => true])->label(false); ?>
    <div class='row'>
        <div class='col-lg-4'>
            <?=
            $form->field($model, 'cep')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '99.999-999',
            ])->textInput(['class' => 'form-control', 'maxlength' => true]);
            ?>

        </div>

        <div class='col-lg-4'>
            <?=
            $form->field($model, 'uf')->dropDownList(
                    ArrayHelper::map(
                            app\models\TabEstadosSearch::find()->all(), 'sgl_estado', 'txt_nome'
                    ), ['prompt' => $this->app->params['txt-prompt-select'],
                    //'class' => 'chosen-select'
            ]);
            ?>
        </div>
        <div class='col-lg-4'>
            <?=
            $form->field($model, 'cod_municipio_fk')->dropDownList(
                    [], ['prompt' => $this->app->params['txt-prompt-select'],
                    //'class' => 'chosen-select'
            ]);
            ?>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg-6'>
            <?= $form->field($model, 'logradouro')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-lg-6'>
            <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='row'>


        <div class='col-lg-6'>
            <?= $form->field($model, 'complemento')->textInput(['maxlength' => true]) ?>
        </div>

        <div class='col-lg-6'>
            <?= $form->field($model, 'bairro')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='row'>
        <div class='col-lg-6'>
            <?= $form->field($model, 'correspondencia')->checkbox() ?>
        </div>
    </div>
    <div class='row' id="ativo-check">
        <div class='col-lg-6'>
            <?= $form->field($model, 'ativo')->checkbox() ?>
        </div>
    </div>


</div>

<?php Modal::end(); ?>