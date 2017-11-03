

<div class='row'>

    <div class='col-lg-4'>

        <?=
        $form->field($contrato, 'tipo_contrato_fk')->dropDownList(
                yii\helpers\ArrayHelper::map(
                        app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                            app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-contrato'])->one()['cod_atributos']
                        ])->all(), 'cod_atributos_valores', 'dsc_descricao'
                ), ['prompt' => $this->app->params['txt-prompt-select'], 'id' => 'tabcontratosearch-tipo_contrato_fk-' . $key, 'name' => 'TabContratoSearch[' . $key . '][tipo_contrato_fk]'
        ]);
        ?>


    </div>

    <div class='col-lg-4'>
        <?=
        $form->field($contrato, 'valor_contrato')->textInput(
                ['id' => 'tabcontratosearch-valor_contrato-' . $key, 'name' => 'TabContratoSearch[' . $key . '][valor_contrato]']
        )->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabcontratosearch-valor_contrato-' . $key, 'name' => 'TabContratoSearch[' . $key . '][valor_contrato]'
            ],
        ]);
        ?>
    </div>

    <div class='col-lg-4'>
        <?=
        $form->field($contrato, 'dt_prazo')->textInput(['id' => 'tabcontratosearch-dt_prazo-' . $key, 'name' => 'TabContratoSearch[' . $key . '][dt_prazo]']);
        ?>
    </div>
</div>
<div class='row'>

    <div class='col-lg-4'>
        <?=
                $form->field($contrato, 'dia_vencimento')->textInput(['id' => 'tabcontratosearch-dia_vencimento-' . $key, 'name' => 'TabContratoSearch[' . $key . '][dia_vencimento]'])
                ->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 0,
                        'allowZero' => false,]
        ]);
        ?>
    </div>

    <div class='col-lg-4'>
        <?=
        $form->field($contrato, 'qnt_parcelas')->textInput(
                ['id' => 'tabcontratosearch-qnt_parcelas-' . $key, 'name' => 'TabContratoSearch[' . $key . '][qnt_parcelas]']
        )->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 0,
                'allowZero' => false,],
            'options' => [
                'class' => 'form-control', 'id' => 'tabcontratosearch-qnt_parcelas-' . $key, 'name' => 'TabContratoSearch[' . $key . '][qnt_parcelas]'
            ],
        ]);
        ?>
    </div>

</div>
