
<?= $form->field($planof, 'tipo_plano_fk')->hiddenInput(['id' => 'tabplanosf-tipo_plano_fk', 'name' => 'TabPlanosF[tipo_plano_fk]'])->label(false) ?>


<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof, 'valor_512', $addon)->textInput(['id' => 'tabplanosf-valor_512', 'name' => 'TabPlanosF[valor_512]'])->widget(\kartik\money\MaskMoney::className(), [
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
        <?= $form->field($planof, 'valor_512_check')->hiddenInput(['id' => 'tabplanosf-valor_512_check', 'name' => 'TabPlanosF[valor_512_check]'])->label(false); ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof, 'valor_512k_2m', $addon)->textInput(['id' => 'tabplanosf-valor_512k_2m', 'name' => 'TabPlanosF[valor_512k_2m]'])->widget(\kartik\money\MaskMoney::className(), [
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
        <?= $form->field($planof, 'valor_512k_2m_check')->hiddenInput(['id' => 'tabplanosf-valor_512k_2m_check', 'name' => 'TabPlanosF[valor_512k_2m_check]'])->label(false); ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof, 'valor_2m_12m', $addon)->textInput(['id' => 'tabplanosf-valor_2m_12m', 'name' => 'TabPlanosF[valor_2m_12m]'])->widget(\kartik\money\MaskMoney::className(), [
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
         <?= $form->field($planof, 'valor_2m_12m_check')->hiddenInput(['id' => 'tabplanosf-valor_2m_12m_check', 'name' => 'TabPlanosF[valor_2m_12m_check]'])->label(false); ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof, 'valor_12m_34m', $addon)->textInput(['id' => 'tabplanosf-valor_12m_34m', 'name' => 'TabPlanosF[valor_12m_34m]'])->widget(\kartik\money\MaskMoney::className(), [
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
        <?= $form->field($planof, 'valor_12m_34m_check')->hiddenInput(['id' => 'tabplanosf-valor_12m_34m_check', 'name' => 'TabPlanosF[valor_12m_34m_check]'])->label(false); ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof, 'valor_34m', $addon)->textInput(['id' => 'tabplanosf-valor_34m', 'name' => 'TabPlanosF[valor_34m]'])->widget(\kartik\money\MaskMoney::className(), [
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
          <?= $form->field($planof, 'valor_34m_check')->hiddenInput(['id' => 'tabplanosf-valor_34m_check', 'name' => 'TabPlanosF[valor_34m_check]'])->label(false); ?>
    </div>
</div>



<hr />
<p><b><i>Maior e menor preço por Mbps ofertado e comercializado pela prestadora</i></b></p>
<div class='row'>

<?= $form->field($planof_mn, 'tipo_plano_fk')->hiddenInput(['id' => 'tabplanosmenormaiorf-tipo_plano_fk', 'name' => 'TabPlanosMenorMaiorF[tipo_plano_fk]'])->label(false) ?>


    <div class='col-lg-12'>
        <?=
        $form->field($planof_mn, 'valor_menos_1m_ded', $addon)->textInput(['id' => 'tabplanosmenormaiorf-valor_menos_1m_ded', 'name' => 'TabPlanosMenorMaiorF[valor_menos_1m_ded]'])->widget(\kartik\money\MaskMoney::className(), [
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
        <?= $form->field($planof_mn, 'valor_menos_1m_ded_check')->hiddenInput(['id' => 'tabplanosmenormaiorf-valor_menos_1m_ded_check', 'name' => 'TabPlanosMenorMaiorF[valor_menos_1m_ded_check]'])->label(false); ?>
    </div>
</div>
<div class='row'>

    <div class='col-lg-12'>
        <?=
        $form->field($planof_mn, 'valor_menos_1m', $addon)->textInput(['id' => 'tabplanosmenormaiorf-valor_menos_1m', 'name' => 'TabPlanosMenorMaiorF[valor_menos_1m]'])->widget(\kartik\money\MaskMoney::className(), [
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
          <?= $form->field($planof_mn, 'valor_menos_1m_check')->hiddenInput(['id' => 'tabplanosmenormaiorf-valor_menos_1m_check', 'name' => 'TabPlanosMenorMaiorF[valor_menos_1m_check]'])->label(false); ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof_mn, 'valor_maior_1m_ded', $addon)->textInput(['id' => 'tabplanosmenormaiorf-valor_maior_1m_ded', 'name' => 'TabPlanosMenorMaiorF[valor_maior_1m_ded]'])->widget(\kartik\money\MaskMoney::className(), [
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
        <?= $form->field($planof_mn, 'valor_maior_1m_ded_check')->hiddenInput(['id' => 'tabplanosmenormaiorf-valor_maior_1m_ded_check', 'name' => 'TabPlanosMenorMaiorF[valor_maior_1m_ded_check]'])->label(false); ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($planof_mn, 'valor_maior_1m', $addon)->textInput(['id' => 'tabplanosmenormaiorf-valor_maior_1m', 'name' => 'TabPlanosMenorMaiorF[valor_maior_1m]'])->widget(\kartik\money\MaskMoney::className(), [
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
          <?= $form->field($planof_mn, 'valor_maior_1m_check')->hiddenInput(['id' => 'tabplanosmenormaiorf-valor_maior_1m_check', 'name' => 'TabPlanosMenorMaiorF[valor_maior_1m_check]'])->label(false); ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-12'>
        <?= $form->field($planof, 'obs')->textarea(['rows' => 6, 'id' => 'tabplanosf-obs', 'name' => 'TabPlanosF[obs]']) ?>
    </div>
</div>

