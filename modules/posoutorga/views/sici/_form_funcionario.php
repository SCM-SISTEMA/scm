
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
        $form->field($sici, 'num_central_atendimento', $addon)->textInput();
        ?>
        <?= $form->field($sici, 'num_central_atendimento_check')->hiddenInput()->label(false); ?>
    </div>
</div>
