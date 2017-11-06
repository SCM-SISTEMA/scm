<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TabCliente */
/* @var $form yii\widgets\ActiveForm */
?>



    <?=
    kartik\tabs\TabsX::widget([
        'items' => [
            [
                'label' => "<b style=\"color:#337ab7\">Dados Gerais</b>",
                'content' => $this->render('_dados_gerais', compact('model', 'form')),
                'active' => true,
            ],
            [
                'label' => "<b style=\"color:#337ab7\">Dados Técnicos</b>",
                'content' => $this->render('_dados_tecnicos', compact('model', 'form')),
                'active' => false,
            ],
            [
                'label' => "<b style=\"color:#337ab7\">Contato</b>",
                'content' => $this->render('@app/views/contato/create', compact('form')),
                'active' => false,
            ],
            [
                'label' => "<b style=\"color:#337ab7\">Endereço</b>",
                'content' => $this->render('@app/views/endereco/create', compact('form')),
                'active' => false,
            ]
        ],
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'bordered' => true,
        'encodeLabels' => false,
    ])
    ?>


