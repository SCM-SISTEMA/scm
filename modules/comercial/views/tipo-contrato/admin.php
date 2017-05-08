<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuLateralModuloWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\comercial\models\TipoContrato */


?>

<div class="tipo-contrato-admin">
 
    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>
	
</div>
