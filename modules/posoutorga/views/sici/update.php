<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\TabAcoes */
/* @var $form yii\widgets\ActiveForm */

//$this->registerJsFile("@web/js/app/posoutorga.sici.js?{$this->app->version}", ['position' => $this::POS_END, 'depends' => [\app\assets\SinisaAsset::className()]]);

//$btSave = Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . 'Salvar', ['name' => 'abrir', 'class' => 'btn btn-success btn-sm']);

$btSave = Html::a('<i class="glyphicon glyphicon-ok"></i> Salvar','#', ['id'=>'salvarSici','name' => 'salvarSici', 'class' => 'btn btn-success btn-sm']);
$btSave2 = Html::a('<i class="glyphicon glyphicon-ok"></i> Salvar','#', ['id'=>'salvarSici2','name' => 'salvarSici2', 'class' => 'btn btn-success btn-sm']);
$btVoltar = Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Voltar',Url::to(['sici/index']), ['class' => 'btn btn-primary btn-sm']);

if (!$importacao['sici']->isNewRecord && $importacao['sici']->situacao_fk == \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('situacao-sici', 'C')) {
    $btXml = Html::a('<i class="fa fa-code"></i> Gerar XML', Url::to(['sici/gerar', 'cod_sici' => $importacao['sici']->cod_sici]), ['class' => 'btn btn-default btn-sm']);
}
?>

<div class="tab-acoes-form box box-default">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools">
            <?= $btSave; ?>
            <?= $btXml ?>
            <?= $btVoltar ?>
        </div>
        <div class="box-body">

            <?=
            $this->render('_form_updade', [
                'form' => $form,
                'importacao' => $importacao
            ])
            ?>

        </div>
        <div class="box-footer">
            <h3 class="box-title"></h3>
            <div class="box-tools pull-right">
                <?= $btSave2; ?>
                <?= $btXml ?>
                <?= $btVoltar ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
