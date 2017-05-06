
<div class='row'>
    <div class='col-lg-6'>
        <?= $form->field($sici, 'fust')->textInput(['maxlength' => true]) ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($sici, 'valor_consolidado')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($sici, 'receita_bruta')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'aliquota_nacional')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_aliquota')->textInput(['disabled' => 'disabled']);
        ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'receita_icms')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_icms')->textInput(['disabled' => 'disabled']);
        ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'receita_pis')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_pis')->textInput(['disabled' => 'disabled']);
        ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'receita_confins')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_confins')->textInput(['disabled' => 'disabled']);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($sici, 'receita_liquida')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>

    <div class='col-lg-12'>
        <?= $form->field($sici, 'obs_receita')->textarea(['rows' => 6]) ?>
    </div>

</div>