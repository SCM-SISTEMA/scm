<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_fibra_prestadora', $addon)->textInput();
        ?>
        <?= $form->field($sici, 'total_fibra_prestadora_check')->hiddenInput()->label(false); ?>
    </div>

    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_fibra_terceiros', $addon)->textInput();
        ?>
        <?= $form->field($sici, 'total_fibra_terceiros_check')->hiddenInput()->label(false); ?>
    </div>
</div>

<div class='row'>

    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_fibra_crescimento_prop_prestadora', $addon)->textInput();
        ?>
      
        <?= $form->field($sici, 'total_fibra_crescimento_prop_prestadora_check')->hiddenInput()->label(false); ?>
    </div>

    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_fibra_crescimento_prop_terceiros', $addon)->textInput();
        ?>
        
        <?= $form->field($sici, 'total_fibra_crescimento_prop_terceiros_check')->hiddenInput()->label(false); ?>
    </div>

</div>