<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Cliente */
?>

<div class="cliente-admin">
    <div class="tab-cliente-form box box-default">
        <?php $form = ActiveForm::begin(['id' => 'formCliente']); ?>

        <div class="box-header with-border">
            <h3 class="box-title"></h3>
            <div class="box-tools">
                <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . ($model->isNewRecord ? 'Incluir registro' : 'Alterar registro'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm')]) ?>
                <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Cancelar', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
            </div>
        </div>
        <div class="box-body">





            <?php
            echo yii\bootstrap\Collapse::widget([
                'id' => 'box-primarios',
                'items' => [
                    //DICA
                    [
                        'label' => "<i class='fa fa-info-circle'></i> Informações Gerais",
                        'content' => [$this->render('_form', compact('model', 'form')
                            )],
                        'encode' => false,
                        'contentOptions' => ['class' => 'in'],
                    // open its content by default
                    ],
                ]
            ]);
            ?>







            <?php
            echo yii\bootstrap\Collapse::widget([
                'id' => 'box-contratos',
                'items' => [
                    [
                        'label' => "<i class='fa fa-book'></i> Contratos",
                        'content' => ['<div id="divGuiaContrato">' .
                            $this->render('@app/modules/comercial/views/contrato/_guia_contratos', compact('form')) .
                            '</div>'],
                        'encode' => false,
                        'contentOptions' => ['class' => 'in'],
                    // open its content by default
                    ],

                ]
            ]);
            ?>



        </div>
        <div class="box-footer">
            <h3 class="box-title"></h3>
            <div class="box-tools pull-right">
                <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . ($model->isNewRecord ? 'Incluir registro' : 'Alterar registro'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm')]) ?>
                <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Cancelar', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
            </div>
        </div>
        <?php echo $this->render('@app/modules/comercial/views/tipo-contrato/_form_tipo_contrato_add', ['form' => $form]); ?> 
        <?php echo $this->render('@app/modules/comercial/views/contrato/_form_contrato_add', ['form' => $form]); ?> 

        <?php ActiveForm::end(); ?>
    </div>
</div>
