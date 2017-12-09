<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'header' => '<h3><div id="tituloSocios">Incluir Sócio</div></h3>',
    'id' => 'modalSocios',
    'closeButton' => false,
    'size' => 'modal-md',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Incluir registro', [
        'id' => 'botaoSalvarSocios',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);

$model = new app\modules\comercial\models\TabSociosSearch();
$end = new \app\models\TabEnderecoSearch();
?>

<div id="formSocios">
    <?= $form->field($model, 'cod_socio')->hiddenInput(['maxlength' => true])->label(false); ?>
    <?= $form->field($model, 'cod_cliente_fk')->hiddenInput(['maxlength' => true])->label(false); ?>

    <div class='row'>
        <div class='col-lg-6'>
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
        </div>

        <div class='col-lg-6'>
            <?= $form->field($model, 'nacionalidade')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg-6'>
            <?=
            $form->field($model, 'estado_civil_fk')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                            \app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                                app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'estado-civil'])->one()['cod_atributos']
                            ])->orderBy('dsc_descricao')->all(), 'cod_atributos_valores', 'dsc_descricao'
                    ), ['prompt' => $this->app->params['txt-prompt-select']
            ]);
            ?>

        </div>

        <div class='col-lg-6'>
            <?= $form->field($model, 'profissao')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg-6'>
            <?= $form->field($model, 'rg')->textInput(['maxlength' => true, 'class' => 'form-control somenteNumero']) ?>
        </div>
        <div class='col-lg-6'>
            <?=
            $form->field($model, 'orgao_uf')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                            \app\models\TabEstadosSearch::find()->orderBy('sgl_estado')->all(), 'sgl_estado', 'sgl_estado'
                    ), ['prompt' => $this->app->params['txt-prompt-select']
            ]);
            ?>


        </div>
    </div>
    <div class='row'>
        <div class='col-lg-6'>
            <?=
            $form->field($model, 'cpf')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => ['999.999.999-99'],
                'options' => [
                    'class' => 'form-control'
                ],
            ])->textInput(['maxlength' => true])
            ?>
        </div>
        <div class='col-lg-6'>
            <?=
            $form->field($model, 'nacimento')->widget(
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
        <div class='col-lg-6'>
            <?=
            $form->field($model, 'telefone')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
                'options' => [
                    'class' => 'form-control',
                ],
            ])->textInput(['maxlength' => true])
            ?>

        </div>
        <div class='col-lg-6'>
            
                <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>
            
        </div>
    </div>

    <div class='row'>
        <div class='col-lg-6'>
            
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            
        </div>
        <div class='col-lg-6'>
             <?=
        $form->field($model, 'representante_comercial')->dropDownList(
                yii\helpers\ArrayHelper::map(
                        app\models\TabAtributosValores::find()->where(['fk_atributos_valores_atributos_id' =>
                            app\models\TabAtributos::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos]
                        )->asArray()->all(), 'cod_atributos_valores', 'dsc_descricao'
        ));
        ?>
           
        </div>
        
    </div>
   <?php echo $this->render('@app/views/endereco/_form', ['form' => $form, 'model'=>$end]); ?> 

</div>

<?php Modal::end(); ?>