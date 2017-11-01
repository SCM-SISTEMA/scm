<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuLateralModuloWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Cliente */


?>

<div class="cliente-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	
</div>
