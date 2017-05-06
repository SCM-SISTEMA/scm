<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Contato */

$this->registerJsFile('@web/js/app/admin.cliente.js', ['position' => $this::POS_END, 'depends' => [\app\assets\ProjetoAsset::className()]]);
?>

<div class="contato-create">

    <div id="divGridContato" class='gride' style="display: block">
        <?= $this->render('_grid_cliente'); ?>
    </div>

    <?=
    Html::button('<i class="glyphicon glyphicon-plus"></i> Incluir Nova', [
        'class' => 'btn btn-success btn-sm',
        'id' => 'incluirContato',
        'style' => 'display: block',
    ])
    ?>
    <?= $this->render('_form_cliente', ['form' => $form]); ?>

</div>
