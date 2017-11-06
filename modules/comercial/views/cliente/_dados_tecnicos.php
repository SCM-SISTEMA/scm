<div class='row'>

    <div class='col-lg-3'>
        <?= $form->field($model, 'qnt_clientes')->textInput(['maxlength' => true, 'class' => 'form-control somenteNumero']) ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-3'>
        <?=
        $form->field($model, 'operando')->dropDownList(
                yii\helpers\ArrayHelper::map(
                        app\models\TabAtributosValores::find()->where(['fk_atributos_valores_atributos_id' =>
                            app\models\TabAtributos::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos]
                        )->asArray()->all(), 'cod_atributos_valores', 'dsc_descricao'
        ));
        ?>
    </div>
    <div class='col-lg-3'>
        <?=
        $form->field($model, 'parceria')->dropDownList(
                yii\helpers\ArrayHelper::map(
                        app\models\TabAtributosValores::find()->where(['fk_atributos_valores_atributos_id' =>
                            app\models\TabAtributos::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos]
                        )->asArray()->all(), 'cod_atributos_valores', 'dsc_descricao'
        ));
        ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-3'>
        <?=
        $form->field($model, 'link_dedicado')->dropDownList(
                yii\helpers\ArrayHelper::map(
                        app\models\TabAtributosValores::find()->where(['fk_atributos_valores_atributos_id' =>
                            app\models\TabAtributos::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos]
                        )->asArray()->all(), 'cod_atributos_valores', 'dsc_descricao'
        ));
        ?>
    </div>
    <div class='col-lg-3'>
        <?=
        $form->field($model, 'consultoria_mensal')->dropDownList(
                yii\helpers\ArrayHelper::map(
                        app\models\TabAtributosValores::find()->where(['fk_atributos_valores_atributos_id' =>
                            app\models\TabAtributos::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos]
                        )->asArray()->all(), 'cod_atributos_valores', 'dsc_descricao'
        ));
        ?>
    </div>
</div>



<div class='row'>
    <div class='col-lg-3'>
        <?=
        $form->field($model, 'zero800')->dropDownList(
                yii\helpers\ArrayHelper::map(
                        app\models\TabAtributosValores::find()->where(['fk_atributos_valores_atributos_id' =>
                            app\models\TabAtributos::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos]
                        )->asArray()->all(), 'cod_atributos_valores', 'dsc_descricao'
        ));
        ?>
    </div>
    <div class='col-lg-3'>
        <?=
        $form->field($model, 'engenheiro_tecnico')->dropDownList(
                yii\helpers\ArrayHelper::map(
                        app\models\TabAtributosValores::find()->where(['fk_atributos_valores_atributos_id' =>
                            app\models\TabAtributos::find()->where(['sgl_chave' => 'opt-sim-nao'])->one()->cod_atributos]
                        )->asArray()->all(), 'cod_atributos_valores', 'dsc_descricao'
        ));
        ?>
    </div>
</div>