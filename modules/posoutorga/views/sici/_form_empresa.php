

<div class='row'>
    <div class='col-lg-4'>
        <?= $form->field($cliente, 'razao_social')->textInput(['maxlength' => true]) ?>
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
        <?= $form->field($cliente, 'cnpj')->textInput(['maxlength' => true]) ?>
    </div>

    <div class='col-lg-4'>
      
         <?=
            $form->field($sici, 'mes_ano_referencia')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                           \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('mes'), 'cod_atributos_valores', 'dsc_descricao'
                    ), ['prompt' => $this->app->params['txt-prompt-select'],
               
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

