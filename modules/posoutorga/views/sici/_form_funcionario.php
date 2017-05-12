
<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'qtd_funcionarios_fichados')->textInput();
        ?>
    </div>

    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'qtd_funcionarios_terceirizados')->textInput();
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'num_central_atendimento')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => ['(99) 9999-9999', '(99) 99999-9999' , '9999-999-9999', '99-999', '9999'],
            
        ])->textInput();
        ?>
    </div>
</div>
