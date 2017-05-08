<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TabCliente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-cliente-form box box-default">
    <?php $form = ActiveForm::begin(['id'=>'formCliente']); ?>

    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools">
            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . ($model->isNewRecord ? 'Incluir registro' : 'Alterar registro'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm')]) ?>
            <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Cancelar', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
        </div>
    </div>

    <div class="box-body">
        <?=
        kartik\tabs\TabsX::widget([
            'items' => [
                [
                    'label' => "<b style=\"color:#337ab7\">Dados Gerais</b>",
                    'content' => $this->render('_dados_gerais', compact('model', 'form')),
                    'active' => false,
                ]
            ],
            'position' => kartik\tabs\TabsX::POS_ABOVE,
            'bordered' => true,
            'encodeLabels' => false,
        ])
        ?>

         <?=
        kartik\tabs\TabsX::widget([
            'items' => [
                [
                    'label' => "<b style=\"color:#337ab7\">Contato</b>",
                    'content' => $this->render('@app/views/contato/create', compact('form')),
                    'active' => false,
                ]
            ],
            'position' => kartik\tabs\TabsX::POS_ABOVE,
            'bordered' => true,
            'encodeLabels' => false,
        ])
        ?>
        
        <?=
        kartik\tabs\TabsX::widget([
            'items' => [
                [
                    'label' => "<b style=\"color:#337ab7\">Endereço</b>",
                    'content' => $this->render('@app/views/endereco/create', compact('form')),
                    'active' => false,
                ]
            ],
            'position' => kartik\tabs\TabsX::POS_ABOVE,
            'bordered' => true,
            'encodeLabels' => false,
        ])
        ?>
        


    </div>
    <div class="box-footer">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . ($model->isNewRecord ? 'Incluir registro' : 'Alterar registro'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm')]) ?>
            <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Cancelar', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
