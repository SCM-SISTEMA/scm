<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuLateralModuloWidget;

/* @var $this yii\web\View */
/* @var $model app\models\TabContato */

?>

<div class="tab-contato-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
