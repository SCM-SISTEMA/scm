<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuLateralModuloWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\posoutorga\models\Planos */


?>

<div class="planos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	
</div>
