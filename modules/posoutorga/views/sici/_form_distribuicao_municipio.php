<?php use yii\helpers\ArrayHelper; ?>
<div class='row'>
    <div class='col-lg-6'>

        <?=
        $form->field($empresa[0], 'cod_municipio_fk')->dropDownList(
                ArrayHelper::map(
                        app\models\TabMunicipiosSearch::find()->where(['sgl_estado_fk' => strtoupper($empresa[0]->uf)])->all(), 'cod_municipio', 'txt_nome'
                ), ['prompt' => $this->app->params['txt-prompt-select'],
            'class' => 'chosen-select', 'id' => 'tabempresamunicipio' . $key . '-cod_municipio_fk', 'name' => 'TabEmpresaMunicipio[' . $key . '][cod_municipio_fk]']);
        ?>
    </div>
    <div class='col-lg-6'>
        
         <?=
            $form->field($empresa[0], 'tecnologia')->dropDownList(
                    ArrayHelper::map(
                            app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                                app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tecnologia'])->one()['cod_atributos']
                            ])->all(), 'cod_atributos_valores', 'dsc_descricao'
                    ), ['prompt' => $this->app->params['txt-prompt-select'],'id' => 'tabempresamunicipio' . $key . '-tecnologia', 'name' => 'TabEmpresaMunicipio[' . $key . '][tecnologia]'
            ]);
            ?>
        
        
    </div>

</div>
<div class='row'>
    <div class='col-lg-6'>

        <?=
        $form->field($empresa[0], 'uf')->dropDownList(
                ArrayHelper::map(
                        app\models\TabEstadosSearch::find()->all(), 'sgl_estado', 'txt_nome'
                ), ['prompt' => $this->app->params['txt-prompt-select'],
            'class' => 'chosen-select'
                ], ['id' => 'tabempresamunicipio' . $key . '-cod_municipio_fk', 'name' => 'TabEmpresaMunicipio[' . $key . '][cod_municipio_fk]']);
        ?>
    </div>
</div>
<br>
<div class='row'>
    <div class='col-lg-1'>
        <p></p>
    </div>
    <div class='col-lg-1'>
        <p><b>até 512 Kbps</b></p>
    </div>
    <div class='col-lg-2'>
        <p><b>512 Kbps à 2 Mbps</b></p>
    </div>
    <div class='col-lg-2'>
        <p><b>2 Mbps à 12 Mbps</b></p>
    </div>
    <div class='col-lg-2'>
        <p><b>12 Mbps à 34 Mbps</b></p>
    </div>
    <div class='col-lg-2'>
        <p><b>ACIMA DE 34 Mbps</b></p>
    </div>
    <div class='col-lg-2'>
        <p><b>Total</b></p>
    </div>
</div>
<div class='row'>
    <div class='col-lg-1'>
        <p><b>FÍSICA</b></p>
    </div>
    <div class='col-lg-1'>
        <?=
        $form->field($empresa[1], 'valor_512')->textInput(['id' => 'tabplanossearchmf' . $key . '-valor_512', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][valor_512]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanossearchmf' . $key . '-valor_512', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][valor_512]'
            ],
        ])->label(false);
        ?>
    </div>
    <div class='col-lg-2'>
        <?=
        $form->field($empresa[1], 'valor_512k_2m')->textInput(['id' => 'tabplanossearchmf' . $key . '-valor_512k_2m', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][valor_512k_2m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanossearchmf' . $key . '-valor_512k_2m', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][valor_512k_2m]'
            ],
        ])->label(false);
        ?>
    </div>
    <div class='col-lg-2'>
        <?=
        $form->field($empresa[1], 'valor_2m_12m')->textInput(['id' => 'tabplanossearchmf' . $key . '-valor_2m_12m', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][valor_2m_12m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanossearchmf' . $key . '-valor_2m_12m', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][valor_2m_12m]'
            ],
        ])->label(false);
        ?>
    </div>
    <div class='col-lg-2'>
        <?=
        $form->field($empresa[1], 'valor_12m_34m')->textInput(['id' => 'tabplanossearchmf' . $key . '-valor_12m_34m', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][valor_12m_34m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanossearchmf' . $key . '-valor_12m_34m', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][valor_12m_34m]'
            ],
        ])->label(false);
        ?>
    </div>
    <div class='col-lg-2'>
        <?=
        $form->field($empresa[1], 'valor_34m')->textInput(['id' => 'tabplanossearchmf' . $key . '-valor_34m', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][valor_34m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanossearchmf' . $key . '-valor_34m', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][valor_34m]'
            ],
        ])->label(false);
        ?>
    </div>
    <div class='col-lg-2'><b>
        <?=
        $form->field($empresa[1], 'total_fisica')->textInput(['disabled' => true, 'id' => 'tabempresamunicipio' . $key . '-total_fisica', 'name' => 'TabEmpresaMunicipio[' . $key . '][total_fisica]'])->label(false);
        ?></b>
    </div>
</div>
<div class='row'>
    <div class='col-lg-1'>
        <p><b>JURÍDICO</b></p>
    </div>
    <div class='col-lg-1'>
        <?=
        $form->field($empresa[2], 'valor_512')->textInput(['id' => 'tabplanossearchmj' . $key . '-valor_512', 'name' => 'TabEmpresaMunicipioMJ[' . $key . '][valor_512]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanossearchmj' . $key . '-valor_512', 'name' => 'TabEmpresaMunicipioMJ[' . $key . '][valor_512]'
            ],
        ])->label(false);
        ?>
    </div>
    <div class='col-lg-2'>
        <?=
        $form->field($empresa[2], 'valor_512k_2m')->textInput(['id' => 'tabplanossearchmj' . $key . '-valor_512k_2m', 'name' => 'TabEmpresaMunicipioMJ[' . $key . '][valor_512k_2m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanossearchmj' . $key . '-valor_512k_2m', 'name' => 'TabEmpresaMunicipioMJ[' . $key . '][valor_512k_2m]'
            ],
        ])->label(false);
        ?>
    </div>
    <div class='col-lg-2'>
        <?=
        $form->field($empresa[2], 'valor_2m_12m')->textInput(['id' => 'tabplanossearchmj' . $key . '-valor_2m_12m', 'name' => 'TabEmpresaMunicipioMJ[' . $key . '][valor_2m_12m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanossearchmj' . $key . '-valor_2m_12m', 'name' => 'TabEmpresaMunicipioMJ[' . $key . '][valor_2m_12m]'
            ],
        ])->label(false);
        ?>
    </div>
    <div class='col-lg-2'>
        <?=
        $form->field($empresa[2], 'valor_12m_34m')->textInput(['id' => 'tabplanossearchmj' . $key . '-valor_12m_34m', 'name' => 'TabEmpresaMunicipioMJ[' . $key . '][valor_12m_34m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanossearchmj' . $key . '-valor_12m_34m', 'name' => 'TabEmpresaMunicipioMJ[' . $key . '][valor_12m_34m]'
            ],
        ])->label(false);
        ?>
    </div>
    <div class='col-lg-2'>
        <?=
        $form->field($empresa[2], 'valor_34m')->textInput(['id' => 'tabplanossearchmj' . $key . '-valor_34m', 'name' => 'TabEmpresaMunicipioMJ[' . $key . '][valor_34m]'])->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabplanossearchmj' . $key . '-valor_34m', 'name' => 'TabEmpresaMunicipioMJ[' . $key . '][valor_34m]'
            ],
        ])->label(false);
        ?>
    </div>
    <div class='col-lg-2'>
        <b><?=
        $form->field($empresa[2], 'total_juridica')->textInput(['disabled' => true, 'id' => 'tabempresamunicipio' . $key . '-total_juridica', 'name' => 'TabEmpresaMunicipio[' . $key . '][total_juridica]'])->label(false);
        ?></b>
    </div>
</div>
<div class='row'>
    <div class='col-lg-1'>
        <p><b>Total</b></p>
    </div>
    <div class='col-lg-1'><b>
        <?=
        $form->field($empresa[1], 'total_512')->textInput(['disabled' => true,'id' => 'tabplanossearchmf' . $key . '-total_512', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][total_512]'])->label(false);
        ?></b>
    </div>
    <div class='col-lg-2'><b>
        <?=
        $form->field($empresa[1], 'total_512k_2m')->textInput(['disabled' => true,'id' => 'tabplanossearchmf' . $key . '-total_512k_2m', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][total_512k_2m]'])->label(false);
        ?></b>
    </div>
    <div class='col-lg-2'><b>
        <?=
        $form->field($empresa[1], 'total_2m_12m')->textInput(['disabled' => true,'id' => 'tabplanossearchmf' . $key . '-total_2m_12m', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][total_2m_12m]'])->label(false);
        ?></b>
    </div>
    <div class='col-lg-2'><b>
        <?=
        $form->field($empresa[1], 'total_12m_34m')->textInput(['disabled' => true,'id' => 'tabplanossearchmf' . $key . '-total_12m_34m', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][total_12m_34m]'])->label(false);
        ?></b>
    </div>
    <div class='col-lg-2'><b>
        <?=
        $form->field($empresa[1], 'total_34m')->textInput(['disabled' => true,'id' => 'tabplanossearchmf' . $key . '-total_34m', 'name' => 'TabEmpresaMunicipioMF[' . $key . '][total_34m]'])->label(false);
        ?></b>
    </div>
    <div class='col-lg-2'><b>
        <?=
        $form->field($empresa[1], 'total')->textInput(['disabled' => true, 'id' => 'tabempresamunicipio' . $key . '-total', 'name' => 'TabEmpresaMunicipio[' . $key . '][total]'])->label(false);
        ?></b>
    </div>
</div>
<br>
<div class='row'>

    <div class='col-lg-6'>
        <?=
        $form->field($empresa[0], 'capacidade_municipio')->textInput(['id' => 'tabempresamunicipio' . $key . '-capacidade_municipio', 'name' => 'TabEmpresaMunicipio[' . $key . '][capacidade_municipio]']);
        ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($empresa[0], 'capacidade_servico')->textInput(['id' => 'tabempresamunicipio' . $key . '-capacidade_servico', 'name' => 'TabEmpresaMunicipio[' . $key . '][capacidade_servico]']);
        ?>
    </div>
</div>