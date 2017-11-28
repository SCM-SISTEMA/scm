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
    'header' => '<h3><div id="tituloContratoProposta">Fechar Proposta</div></h3>',
    'id' => 'modalContratoProposta',
    'closeButton' => false,
    'size' => 'modal-sm',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Gerar Contrato', [
        'id' => 'botaoSalvarContratoProposta',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);



$contrato = new \app\modules\comercial\models\ViewClienteContratoSearch();

?>

<div id="formContratoProposta">
    <div class='row'>
        <div class='col-lg-12'>
            <?=
            $form->field($contrato, 'cod_tipo_contrato')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                            app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                                app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-contrato'])->one()['cod_atributos']
                            ])->orderBy('dsc_descricao')->all(), 'cod_atributos_valores', 'dsc_descricao'
                    ), ['prompt' => $this->app->params['txt-prompt-select']
            ]);
            ?>
        </div>
    </div>
   
    <?= $form->field($contrato, 'cod_contrato')->hiddenInput()->label(false); ?>
    <?= $form->field($contrato, 'cod_setor')->hiddenInput()->label(false); ?>

</div>

<?php Modal::end(); ?>