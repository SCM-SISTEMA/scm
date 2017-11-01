<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\TabAcoes */
/* @var $form yii\widgets\ActiveForm */

//$this->registerJsFile("@web/js/app/posoutorga.sici.js?{$this->app->version}", ['position' => $this::POS_END, 'depends' => [\app\assets\SinisaAsset::className()]]);
?>

<div class="tab-acoes-form box box-default">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="import box-tools">
            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . 'Carregar Planilha', ['style' => 'display:' . (($importacao) ? 'none' : 'block'), 'name' => 'abrir', 'class' => 'import btn btn-primary  btn-sm']) ?>
            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . 'Salvar', ['style' => 'display:' . (($importacao) ? 'block' : 'none' ), 'name' => 'importar', 'class' => 'import btn btn-success btn-sm']) ?>
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
            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . 'Carregar Planilha', ['style' => 'display:' . (($importacao) ? 'none' : 'block'), 'name' => 'abrir', 'class' => 'import btn btn-primary  btn-sm']) ?>
            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . 'Salvar', ['style' => 'display:' . (($importacao) ? 'block' : 'none' ), 'name' => 'importar', 'class' => 'import btn btn-success btn-sm']) ?>            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
