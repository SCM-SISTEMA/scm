<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuLateralModuloWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Endereco */

$this->registerJsFile('@web/js/app/admin.cliente.js', ['position' => $this::POS_END, 'depends' => [\app\assets\ProjetoAsset::className()]]);
?>

<div class="socios-create">

    <div id="divGridSocios" class='gride' style="display: block">
        <?= $this->render('_grid_socios'); ?>
    </div>

    <?=
    Html::button('<i class="glyphicon glyphicon-plus"></i> Incluir Novo', [
        'class' => 'btn btn-success btn-sm',
        'id' => 'incluirSocios',
        'style' => 'display: block',
    ])
    ?>
    <?= $this->render('_form_socios', ['form' => $form]); ?>

</div>
