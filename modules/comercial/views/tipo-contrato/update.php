<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuLateralModuloWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\comercial\models\TabTipoContrato */

?>

<div class="tab-tipo-contrato-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
