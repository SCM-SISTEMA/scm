
<?= $form->field($planof, 'tipo_plano_fk')->hiddenInput(['id' => 'tabplanosf-tipo_plano_fk', 'name' => 'TabPlanosF[tipo_plano_fk]'])->label(false) ?>


<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof, 'valor_512')->textInput(['id' => 'tabplanosf-valor_512', 'name' => 'TabPlanosF[valor_512]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosf-valor_512', 'name' => 'TabPlanosF[valor_512]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof, 'valor_512k_2m')->textInput(['id' => 'tabplanosf-valor_512k_2m', 'name' => 'TabPlanosF[valor_512k_2m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosf-valor_512k_2m', 'name' => 'TabPlanosF[valor_512k_2m]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof, 'valor_2m_12m')->textInput(['id' => 'tabplanosf-valor_2m_12m', 'name' => 'TabPlanosF[valor_2m_12m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosf-valor_2m_12m', 'name' => 'TabPlanosF[valor_2m_12m]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof, 'valor_12m_34m')->textInput(['id' => 'tabplanosf-valor_12m_34m', 'name' => 'TabPlanosF[valor_12m_34m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosf-valor_12m_34m', 'name' => 'TabPlanosF[valor_12m_34m]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof, 'valor_34m')->textInput(['id' => 'tabplanosf-valor_34m', 'name' => 'TabPlanosF[valor_34m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosf-valor_34m', 'name' => 'TabPlanosF[valor_34m]'
            ],
        ]);
        ?>
    </div>
</div>



<hr />
<p><b><i>Maior e menor preço por Mbps ofertado e comercializado pela prestadora</i></b></p>
<div class='row'>

    <div class='col-lg-12'>
        <?=
        $form->field($planof_mn, 'valor_menos_1m_ded')->textInput(['id' => 'tabplanosmenormaiorf-valor_menos_1m_ded', 'name' => 'TabPlanosMenorMaiorF[valor_menos_1m_ded]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosmenormaiorf-valor_menos_1m_ded', 'name' => 'TabPlanosMenorMaiorF[valor_menos_1m_ded]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>

    <div class='col-lg-12'>
        <?=
        $form->field($planof_mn, 'valor_menos_1m')->textInput(['id' => 'tabplanosmenormaiorf-valor_menos_1m', 'name' => 'TabPlanosMenorMaiorF[valor_menos_1m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosmenormaiorf-valor_menos_1m', 'name' => 'TabPlanosMenorMaiorF[valor_menos_1m]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof_mn, 'valor_maior_1m_ded')->textInput(['id' => 'tabplanosmenormaiorf-valor_maior_1m_ded', 'name' => 'TabPlanosMenorMaiorF[valor_maior_1m_ded]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosmenormaiorf-valor_maior_1m_ded', 'name' => 'TabPlanosMenorMaiorF[valor_maior_1m_ded]'
            ],
        ]);
        ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof_mn, 'valor_maior_1m')->textInput(['id' => 'tabplanosmenormaiorf-valor_maior_1m', 'name' => 'TabPlanosMenorMaiorF[valor_maior_1m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanosmenormaiorf-valor_maior_1m', 'name' => 'TabPlanosMenorMaiorF[valor_maior_1m]'
            ],
        ]);
        ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-12'>
        <?= $form->field($planof, 'obs')->textarea(['rows' => 6, 'id' => 'tabplanosf-obs', 'name' => 'TabPlanosF[obs]']) ?>
    </div>
</div>

