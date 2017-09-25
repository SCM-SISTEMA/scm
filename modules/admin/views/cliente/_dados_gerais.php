<div class='row'>
    <?= $form->field($model, 'cod_cliente')->hiddenInput()->label(false); ?>
    <div class='col-lg-3'>
        <?=
        $form->field($model, 'cnpj')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => ['99.999.999/9999-99'],
            'options' => [
                'class' => 'form-control'
            ],
        ])->textInput(['maxlength' => true, 'disabled'=>($model->cod_cliente && $model->cnpj)])
        ?>
    </div>
    <div class='col-lg-3'>
        <?= $form->field($model, 'fistel')->textInput(['maxlength' => true, 'class' => 'form-control somenteNumero']) ?>
    </div>
    <div class='col-lg-3'>
        <?= $form->field($model, 'ie')->textInput(['maxlength' => true, 'class' => 'form-control somenteNumero']) ?>
   
    </div>
        <div class='col-lg-3'>
        <?= $form->field($model, 'responsavel')->textInput(['maxlength' => true]) ?>
   
    </div>
</div>
<div class='row'>
    <div class='col-lg-6'>
        <?= $form->field($model, 'fantasia')->textInput(['maxlength' => true]) ?>
    </div>
    <div class='col-lg-6'>
        <?= $form->field($model, 'razao_social')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-6' id='situacaoCliente' style="display: <?= ($model->isNewRecord) ? 'none' : 'block' ?>">
         <?=
            $form->field($model, 'situacao')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                    app\models\TabAtributosValores::find()->where(['fk_atributos_valores_atributos_id'=>
                            app\models\TabAtributos::find()->where(['sgl_chave'=>'opt-sim-nao'])->one()->cod_atributos]
                            )->asArray()->all(), 'cod_atributos_valores', 'dsc_descricao'
                    ));
            ?>
       
    </div>
</div>