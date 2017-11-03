<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuLateralModuloWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\posoutorga\models\TabEmpresaMunicipio */

?>

<div class="tab-empresa-municipio-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
