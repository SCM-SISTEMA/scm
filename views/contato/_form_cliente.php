<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TabContato */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'header' => '<h3><div id="tituloInfra">Incluir Contato</div><h3>',
    'id' => 'modalContato',
    'closeButton' => false,
    'size' => 'modal-sm',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Incluir registro', [
        'id' => 'botaoSalvarContato',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);


$model = new app\models\TabContatoSearch();

?>

<div id="formEndereco">
     <?= $form->field($model, 'cod_contato')->hiddenInput(['maxlength' => true])->label(false); ?>
    <div class='row'>
        <div class='col-sm-12'>
            <?=
            $form->field($model, 'tipo')->dropDownList(
                    ArrayHelper::map(
                            app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                                app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-contato'])->one()['cod_atributos']
                            ])->all(), 'cod_atributos_valores', 'dsc_descricao'
                    ), ['prompt' => $this->app->params['txt-prompt-select'],
            ]);
            ?>
        </div>
    </div>
    <div class='row' style="display:none" id="divContatoEmail">
        <div class='col-sm-12'>
            <?= $form->field($model, 'contato_email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='row' style="display:block" id="divContatoTelefone">
        <div class='col-sm-12'>
            <?=
            $form->field($model, 'contato')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
                'options' => [
                    'class' => 'form-control',
                ],
            ])->textInput(['maxlength' => true])
            ?>
        </div>
    </div>
    <div class='row' style="display:none" id="divContatoRamal">
        <div class='col-sm-12'>
            <?= $form->field($model, 'ramal')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='row' id="divContatoAtivo">
        <div class='col-sm-12'>
            
            <?= $form->field($model, 'ativo')->checkbox() ?>
        </div>
    </div>

</div>

<?php Modal::end(); ?>