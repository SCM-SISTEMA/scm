<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'faturamento_de')->textInput()->widget(\kartik\money\MaskMoney::className(), [
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
        $form->field($sici, 'faturamento_adicionado')->textInput()->widget(\kartik\money\MaskMoney::className(), [
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
        $form->field($sici, 'faturamento_industrial')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>
</div>
