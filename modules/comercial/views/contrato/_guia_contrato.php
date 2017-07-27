
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\comercial\models\TabContrato */
/* @var $form yii\widgets\ActiveForm */

$cont = new \app\modules\comercial\models\TabContratoSearch();

$cont->attributes = $contrato['attributes'];
?>

<div id='divTipoContrato-<?= $contrato['attributes']['cod_contrato'] ?>'>


    <div id='divGuiaTipoContrato-<?= $contrato['attributes']['cod_contrato'] ?>'>

        <?php
        echo yii\bootstrap\Collapse::widget([
            'id' => 'box-servico-'.$contrato['attributes']['cod_contrato'] ,
            'items' => [
                //DICA
                [
                    'label' => "Serviços",
                    'content' => [$this->render('_guia_tipo_contrato', compact('form', 'contrato'))],
                    'encode' => false,
                    'contentOptions' => ($key == 0) ? ['class' => 'in'] : [],
                // open its content by default
                ],
            ]
        ]);
        ?>

    </div>
    
    <div id='divGuiaContratoParcelas-<?= $contrato['attributes']['cod_contrato'] ?>'>

        <?php
        echo yii\bootstrap\Collapse::widget([
            'id' => 'box-parcela-'.$contrato['attributes']['cod_contrato'] ,
            'items' => [
                //DICA
                [
                    'label' => "Parcelas",
                    'content' => [$this->render('@app/modules/comercial/views/contrato-parcelas/_lista_parcelas', compact('form', 'contrato'))],
                    'encode' => false,
                    //'contentOptions' => ($key == 0) ? ['class' => 'in'] : [],
                // open its content by default
                ],
            ]
        ]);
        ?>
    </div>


</div>