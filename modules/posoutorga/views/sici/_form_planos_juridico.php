<?= $form->field($planof, 'tipo_plano_fk')->hiddenInput(['id' => 'tabplanosj-tipo_plano_fk', 'name' => 'TabPlanosJ[tipo_plano_fk]'])->label(false) ?>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planoj, 'valor_512')->textInput(['id' => 'tabplanosj-valor_512', 'name' => 'TabPlanosJ[valor_512]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosj-valor_512', 'name' => 'TabPlanosJ[valor_512]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planoj, 'valor_512k_2m')->textInput(['id' => 'tabplanosj-valor_512k_2m', 'name' => 'TabPlanosJ[valor_512k_2m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosj-valor_512k_2m', 'name' => 'TabPlanosJ[valor_512k_2m]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planoj, 'valor_2m_12m')->textInput(['id' => 'tabplanosj-valor_2m_12m', 'name' => 'TabPlanosJ[valor_2m_12m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosj-valor_2m_12m', 'name' => 'TabPlanosJ[valor_2m_12m]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planoj, 'valor_12m_34m')->textInput(['id' => 'tabplanosj-valor_12m_34m', 'name' => 'TabPlanosJ[valor_12m_34m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosj-valor_12m_34m', 'name' => 'TabPlanosJ[valor_12m_34m]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planoj, 'valor_34m')->textInput(['id' => 'tabplanosj-valor_34m', 'name' => 'TabPlanosJ[valor_34m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosj-valor_34m', 'name' => 'TabPlanosJ[valor_34m]'
            ],
        ]);
        ?>
    </div>
</div>

<hr />
<p><b><i>Maior e menor preço por Mbps ofertado e comercializado pela prestadora</i></b></p>

<div class='row'>
<?= $form->field($planoj_mn, 'tipo_plano_fk')->hiddenInput(['id' => 'tabplanosmenormaiorj-tipo_plano_fk', 'name' => 'TabPlanosMenorMaiorJ[tipo_plano_fk]'])->label(false) ?>
    <div class='col-lg-12'>
        <?=
        $form->field($planoj_mn, 'valor_menos_1m_ded')->textInput(['id' => 'tabplanosmenormaiorj-valor_menos_1m_ded', 'name' => 'TabPlanosMenorMaiorJ[valor_menos_1m_ded]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosmenormaiorj-valor_menos_1m_ded', 'name' => 'TabPlanosMenorMaiorJ[valor_menos_1m_ded]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planoj_mn, 'valor_menos_1m')->textInput(['id' => 'tabplanosmenormaiorj-valor_menos_1m', 'name' => 'TabPlanosMenorMaiorJ[valor_menos_1m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosmenormaiorj-valor_menos_1m', 'name' => 'TabPlanosMenorMaiorJ[valor_menos_1m]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planoj_mn, 'valor_maior_1m_ded')->textInput(['id' => 'tabplanosmenormaiorj-valor_maior_1m_ded', 'name' => 'TabPlanosMenorMaiorJ[valor_maior_1m_ded]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosmenormaiorj-valor_maior_1m_ded', 'name' => 'TabPlanosMenorMaiorJ[valor_maior_1m_ded]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planoj_mn, 'valor_maior_1m')->textInput(['id' => 'tabplanosmenormaiorj-valor_maior_1m', 'name' => 'TabPlanosMenorMaiorJ[valor_maior_1m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosmenormaiorj-valor_maior_1m', 'name' => 'TabPlanosMenorMaiorJ[valor_maior_1m]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?= $form->field($planoj, 'obs')->textarea(['rows' => 6, 'id' => 'tabplanosj-obs', 'name' => 'TabPlanosJ[obs]']) ?>
    </div>
</div>
