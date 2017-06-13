<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'faturamento_de', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'faturamento_de_check')->hiddenInput()->label(false); ?>
    </div>
    <div class='col-lg-6'>
         <?=
        $form->field($sici, 'faturamento_adicionado', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'faturamento_adicionado_check')->hiddenInput()->label(false); ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-6'>
       <?=
        $form->field($sici, 'faturamento_industrial', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'faturamento_industrial_check')->hiddenInput()->label(false); ?>
    </div>
</div>
