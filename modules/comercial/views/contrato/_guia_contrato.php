

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

        <?=
        kartik\tabs\TabsX::widget([
            'id' => 'box-contrato-' . $contrato['attributes']['cod_contrato'],
            'items' => [
                [
                    'label' => "<b>"."Serviços"."</b>",
                    'content' => $this->render('_guia_tipo_contrato', compact('form', 'contrato')),
                    'active' => true,
                ],
                [
                    'label' => "<b>"."Parcelas"."</b>",
                    'content' => $this->render('@app/modules/comercial/views/contrato-parcelas/_lista_parcelas', compact('form', 'contrato')),
                    'active' => false,
                ],
                [
                    'label' => "<b>"."Andamento"."</b>",
                    'content' => $this->render('@app/views/andamento/_form_andamento', compact('form', 'contrato')),
                    'active' => false,
                    'visible' => ((strpos('N', $contrato['attributes']['cod_contrato'])===false)) ? TRUE : FALSE,
                ],
            ],
            'position' => kartik\tabs\TabsX::POS_ABOVE,
            'bordered' => true,
            'encodeLabels' => false,
        ])
        ?>

      </div>

</div>

<div class='row'>

    <div class='col-sm-12'>
        <?=
        \projeto\helpers\Html::button('<i class="glyphicon glyphicon-trash"></i> Excluir Contrato', [
            'class' => 'btn btn-danger btn-sm',
            'onclick' => "excluirContratoParcelas('{$contrato['attributes']['cod_contrato']}')",
        ])
        ?>
    </div>
</div> 