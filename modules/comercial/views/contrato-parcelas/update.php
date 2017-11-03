<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuLateralModuloWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\comercial\models\TabContratoParcelas */

?>

<div class="tab-contrato-parcelas-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
