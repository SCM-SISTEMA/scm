<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\TabContato */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'header' => '<h3><div id="tituloAndamento">Incluir Andamento</div></h3>',
    'id' => 'modalAndamento',
    'closeButton' => false,
    'size' => 'modal-md',
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
            $form->field($model, 'cod_assunto_fk')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                            app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                                app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-assunto-notificacao'])->one()['cod_atributos']
                            ])->orderBy('dsc_descricao')->all(), 'cod_atributos_valores', 'dsc_descricao'
                    ), ['prompt' => $this->app->params['txt-prompt-select']
            ]);
            ?>
        </div>
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

    <?= $form->field($model, 'cod_modulo_fk')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'cod_contrato_fk')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'cod_tipo_contrato_fk')->hiddenInput()->label(false); ?>

</div>
<?php Modal::end(); ?>