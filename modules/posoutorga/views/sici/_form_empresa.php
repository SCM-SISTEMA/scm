<?= $form->field($sici, 'cod_sici')->hiddenInput(['maxlength' => true])->label(false); ?>
<?= $form->field($sici, 'tipo_entrada_fk')->hiddenInput(['maxlength' => true])->label(false); ?>

<div class='row'>
    <div class='col-lg-2'>
        <?=
        $form->field($cliente, 'cnpj')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => ['99.999.999/9999-99'],
            'options' => [
                'class' => 'form-control'
            ],
        ])->textInput(['maxlength' => true, 'disabled' => (($sici->cod_sici) ? true : false)])
        ?>
    </div>
        <div class='col-lg-2'>
        <?= $form->field($cliente, 'fistel')->textInput(['maxlength' => true, 'class'=>'form-control somenteNumero', 'disabled' => (($sici->cod_sici) ? true : false)]) ?>
    </div>

    <div class='col-lg-4'>
        <?= $form->field($sici, 'responsavel')->textInput(['maxlength' => true]) ?>
    </div>



    <div class='col-sm-4'>
        <?=
        $form->field($contatoT, 'contato')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
            'options' => [
                'class' => 'form-control', 'id' => 'tabcontatosearcht-contato', 'name' => 'TabContatoSearchT[contato]'
            ],
        ])->textInput(['maxlength' => true, 'id' => 'tabcontatosearcht-contato', 'name' => 'TabContatoSearchT[contato]'])->label('Telefone');
        ?>
        <?= $form->field($contatoT, 'tipo')->hiddenInput(['maxlength' => true, 'id' => 'tabcontatosearcht-tipo', 'name' => 'TabContatoSearchT[tipo]'])->label(false); ?>

    </div>
</div>




<div class='row'>
    <div class='col-lg-4'>
        <?= $form->field($cliente, 'razao_social')->textInput(['maxlength' => true, 'disabled' => (($sici->cod_sici) ? true : false)]) ?>
    </div>

    <div class='col-lg-2'>

        <?=
        $form->field($sici, 'mes_ano_referencia')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => ['99/9999'],
        ])->textInput(['maxlength' => true])
        ?>

    </div>
    <div class='col-lg-2'>

        <?=
        $form->field($sici, 'tipo_sici_fk')->dropDownList(
                
                yii\helpers\ArrayHelper::map(
                        app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                            app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-sici'])->one()['cod_atributos']
                        ])->all(), 'cod_atributos_valores', 'dsc_descricao'
                ), [
        ]);
        ?>


    </div>

    <div class='col-sm-4'>
        <?=
        $form->field($contatoC, 'contato')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
            'options' => [
                'class' => 'form-control', 'id' => 'tabcontatosearchc-contato', 'name' => 'TabContatoSearchC[contato]'
            ],
        ])->textInput(['maxlength' => true, 'id' => 'tabcontatosearchc-contato', 'name' => 'TabContatoSearchC[contato]'])->label('Celular');
        ?>
        <?= $form->field($contatoC, 'tipo')->hiddenInput(['maxlength' => true, 'id' => 'tabcontatosearchc-tipo', 'name' => 'TabContatoSearchC[tipo]'])->label(false); ?>

    </div>
</div>

