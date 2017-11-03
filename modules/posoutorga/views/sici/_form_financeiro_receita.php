

<div class='row'>
    <div class='col-lg-12'>
        <?=
                $form->field($sici, 'valor_consolidado', $addon)
                ->textInput()
                ->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'valor_consolidado_check')->hiddenInput(['maxlength' => true])->label(false); ?>

    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($sici, 'receita_bruta', $addon)->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'receita_bruta_check')->hiddenInput(['maxlength' => true])->label(false); ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'aliquota_nacional', $addon
        )->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'aliquota_nacional_check')->hiddenInput()->label(false); ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_aliquota')->textInput(['readonly' => 'readonly']);
        ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'receita_icms', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'receita_icms_check')->hiddenInput()->label(false); ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_icms')->textInput(['readonly' => 'readonly']);
        ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-6'>
        <?=
                $form->field($sici, 'receita_pis', $addon)
                ->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'receita_pis_check')->hiddenInput()->label(false); ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_pis')->textInput(['readonly' => 'readonly']);
        ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-6'>
        <?=
                $form->field($sici, 'receita_confins', $addon)
                ->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'receita_confins_check')->hiddenInput()->label(false); ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_confins')->textInput(['readonly' => 'readonly']);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($sici, 'receita_liquida', $addon)->textInput(['readonly' => 'readonly']);
        ?>
        <?= $form->field($sici, 'receita_liquida_check')->hiddenInput()->label(false); ?>

    </div>

    <div class='col-lg-12'>
        <?= $form->field($sici, 'obs_receita')->textarea(['rows' => 6]) ?>

    </div>

</div>