<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuLateralModuloWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Atividade */


?>

<div class="atividade-admin">
 
    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>
	
</div>
