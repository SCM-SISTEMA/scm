<?php

use yii\helpers\ArrayHelper;
?>
<div>
    <?=
    $form->field($model, 'cod_endereco')->hiddenInput([
        'id' => 'tabenderecosocios-cod_endereco', 'name' => 'TabEnderecoSociosSearch[cod_endereco]',
        'maxlength' => true])->label(false);
    ?>
    
    <div class='row'>
        <div class='col-lg-4'>
            <?=
            $form->field($model, 'cep')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '99.999-999',
                'options' => [
                    'id' => 'tabenderecosocios-cep', 'name' => 'TabEnderecoSociosSearch[cep]',
                ],
            ])->textInput(['class' => 'form-control',
                'id' => 'tabenderecosocios-cep', 'name' => 'TabEnderecoSociosSearch[cep]',
                'maxlength' => true]);
            ?>

        </div>

        <div class='col-lg-4'>
            <?=
            $form->field($model, 'uf')->dropDownList(
                    ArrayHelper::map(
                            app\models\TabEstadosSearch::find()->all(), 'sgl_estado', 'txt_nome'
                    ), ['prompt' => $this->app->params['txt-prompt-select'],
                'id' => 'tabenderecosocios-uf', 'name' => 'TabEnderecoSociosSearch[uf]',
            ]);
            ?>
        </div>
        <div class='col-lg-4'>
            <?=
            $form->field($model, 'cod_municipio_fk')->dropDownList(
                    [], ['prompt' => $this->app->params['txt-prompt-select'],
                'id' => 'tabenderecosocios-cod_municipio_fk', 'name' => 'TabEnderecoSociosSearch[cod_municipio_fk]',
            ]);
            ?>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg-6'>
            <?= $form->field($model, 'logradouro')->textInput(['maxlength' => true, 'id' => 'tabenderecosocios-logradouro', 'name' => 'TabEnderecoSociosSearch[logradouro]',]) ?>
        </div>
        <div class='col-lg-6'>
            <?= $form->field($model, 'numero')->textInput(['maxlength' => true, 'id' => 'tabenderecosocios-numero', 'name' => 'TabEnderecoSociosSearch[numero]',]) ?>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg-6'>
            <?= $form->field($model, 'complemento')->textInput(['maxlength' => true, 'id' => 'tabenderecosocios-complemento', 'name' => 'TabEnderecoSociosSearch[complemento]',]) ?>
        </div>
        <div class='col-lg-6'>
            <?= $form->field($model, 'bairro')->textInput(['maxlength' => true, 'id' => 'tabenderecosocios-bairro', 'name' => 'TabEnderecoSociosSearch[bairro]',]) ?>
        </div>
    </div>
</div>