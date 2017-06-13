
<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'qtd_funcionarios_fichados', $addon)->textInput();
        ?>
        <?= $form->field($sici, 'qtd_funcionarios_fichados_check')->hiddenInput()->label(false); ?>
    </div>

    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'qtd_funcionarios_terceirizados', $addon)->textInput();
        ?>
          <?= $form->field($sici, 'qtd_funcionarios_terceirizados_check')->hiddenInput()->label(false); ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'num_central_atendimento', $addon)->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => ['(99) 9999-9999', '(99) 99999-9999' , '9999-999-9999', '99-999', '9999'],
            
        ])->textInput();
        ?>
        <?= $form->field($sici, 'num_central_atendimento_check')->hiddenInput()->label(false); ?>
    </div>
</div>
