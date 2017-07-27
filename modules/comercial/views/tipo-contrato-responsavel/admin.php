<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuLateralModuloWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\comercial\models\TipoContratoResponsavel */


?>

<div class="tipo-contrato-responsavel-admin">
 
    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>
	
</div>
