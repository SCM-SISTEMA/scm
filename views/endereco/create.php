<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuLateralModuloWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Endereco */

$this->registerJsFile('@web/js/app/admin.cliente.js', ['position' => $this::POS_END, 'depends' => [\app\assets\ProjetoAsset::className()]]);
?>

<div class="endereco-create">

    <div id="divGridEndereco" class='gride' style="display: block">
        <?= $this->render('_grid_cliente'); ?>
    </div>

    <?=
    Html::button('<i class="glyphicon glyphicon-plus"></i> Incluir Nova', [
        'class' => 'btn btn-success btn-sm',
        'id' => 'incluirEndereco',
        'style' => 'display: block',
    ])
    ?>
    <?= $this->render('_form_cliente', ['form' => $form]); ?>

</div>
