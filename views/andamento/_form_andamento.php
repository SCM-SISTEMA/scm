<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TabAndamento */
/* @var $form yii\widgets\ActiveForm */
?>

    <div id="divGuiaAndamento">
        
             <?= $this->render('_lista_andamento', [
        'contrato' => $contrato,
    ]) ?>
    </div>
   

