<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\TabAcoes */
/* @var $form yii\widgets\ActiveForm */

//$this->registerJsFile("@web/js/app/posoutorga.sici.js?{$this->app->version}", ['position' => $this::POS_END, 'depends' => [\app\assets\SinisaAsset::className()]]);

$btSave = Html::a('<i class="glyphicon glyphicon-ok"></i> Salvar', '#', ['id' => 'salvarSici', 'name' => 'importar', 'class' => 'import btn btn-success btn-sm', 'style' => 'display:' . (($importacao) ? 'block' : 'none')]);
$btSave2 = Html::a('<i class="glyphicon glyphicon-ok"></i> Salvar', '#', ['id' => 'salvarSici2', 'name' => 'importar', 'class' => 'import btn btn-success btn-sm', 'style' => 'display:' . (($importacao) ? 'block' : 'none')]);
$btVoltar = Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Voltar', Url::to(['sici/index']), ['class' => 'importar btn btn-primary btn-sm']);
?>

<div class="tab-acoes-form box box-default">
    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="import box-tools">
            <?= $btSave ?>

            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . 'Carregar Planilha', ['style' => 'display:' . (($importacao) ? 'none' : 'block'), 'name' => 'abrir', 'class' => 'import btn btn-primary  btn-sm']) ?>

        </div>
        <div class="box-body">
            <div class="row">

                <div class="col-md-10">
                    <?= $form->field($model, 'file')->fileInput() ?>
                </div>
            </div>	
            <br />
            <div id="importacao">
                <?php if ($importacao) : ?>
                    <hr>
                    <br />

                    <?=
                    $this->render('_form_updade', [
                        'form' => $form,
                        'importacao' => $importacao
                    ])
                    ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="box-footer">
            <h3 class="box-title"></h3>
            <div class="box-tools pull-right">
                <?= $btSave ?>
                <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . 'Carregar Planilha', ['style' => 'display:' . (($importacao) ? 'none' : 'block'), 'name' => 'abrir', 'class' => 'import btn btn-primary  btn-sm']) ?>
               
            </div>
            

        </div>
    </div>
        <?php ActiveForm::end(); ?>
  </div>