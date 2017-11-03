<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuLateralModuloWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Contato */


?>

<div class="contato-admin">
 
    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>
	
</div>
