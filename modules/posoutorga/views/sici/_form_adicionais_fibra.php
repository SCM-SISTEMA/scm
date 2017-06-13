<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_fibra_implantada_prestadora', $addon)->textInput();
        ?>

        <?= $form->field($sici, 'total_fibra_implantada_prestadora_check')->hiddenInput()->label(false); ?>
    </div>

    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_fibra_implantada_terceiros', $addon)->textInput();
        ?>
        
        <?= $form->field($sici, 'total_fibra_implantada_terceiros_check')->hiddenInput()->label(false); ?>
    </div>

</div>
<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_crescimento_prestadora', $addon)->textInput();
        ?> 
        <?= $form->field($sici, 'total_crescimento_prestadora_check')->hiddenInput()->label(false); ?>
    </div>

    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_crescimento_terceiros', $addon)->textInput();
        ?>
        <?= $form->field($sici, 'total_crescimento_terceiros_check')->hiddenInput()->label(false); ?>
    </div>

</div>