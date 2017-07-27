
<div class='row'>
    <div class='col-lg-3'>
        <?=
        $form->field($model, 'cnpj')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => ['99.999.999/9999-99'],
            'options' => [
                'class' => 'form-control'
            ],
        ])->textInput(['maxlength' => true])
        ?>
    </div>
    <div class='col-lg-3'>
        <?= $form->field($model, 'fistel')->textInput(['maxlength' => true, 'class' => 'form-control somenteNumero']) ?>
    </div>
    <div class='col-lg-3'>
        <?= $form->field($model, 'ie')->textInput(['maxlength' => true, 'class' => 'form-control somenteNumero']) ?>
   
    </div>
        <div class='col-lg-3'>
        <?= $form->field($model, 'responsavel')->textInput(['maxlength' => true]) ?>
   
    </div>
</div>
<div class='row'>
    <div class='col-lg-6'>
        <?= $form->field($model, 'fantasia')->textInput(['maxlength' => true]) ?>
    </div>
    <div class='col-lg-6'>
        <?= $form->field($model, 'razao_social')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-6' id='situacaoCliente' style="display: <?= ($model->isNewRecord) ? 'none' : 'block' ?>">
        <?= $form->field($model, 'situacao')->checkbox() ?>
    </div>
</div>