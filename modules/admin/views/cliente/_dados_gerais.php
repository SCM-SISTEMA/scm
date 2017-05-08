<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($model, 'cnpj')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '99.99.999/9999-99',
        ])->textInput(['class' => 'form-control']);
        ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($model, 'ie')->textInput();
        ?>
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
    <div class='col-lg-6' id='situacaoCliente' style="display: <?= ($model->isNewRecord) ? 'none' : 'block'  ?>">
        <?= $form->field($model, 'situacao')->checkbox() ?>
    </div>
</div>