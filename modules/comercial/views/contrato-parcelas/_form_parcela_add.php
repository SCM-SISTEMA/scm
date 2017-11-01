<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\TabContato */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'header' => '<h3><div id="tituloFormaPagamento">Incluir forma de pagamento</div></h3>',
    'id' => 'modalFormaPagamento',
    'closeButton' => false,
    'size' => 'modal-md',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
        Html::button('Refazer Parcelas', [
        'id' => 'botaoRefazerFormaPagamento',
        'class' => 'btn btn-primary',
    ])
    . PHP_EOL .
    Html::button('Incluir Pagamento', [
        'id' => 'botaoSalvarFormaPagamento',
        'class' => 'btn btn-success',
    ])
    ,
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);
?>

<div id="divFormaPagamento">

</div>
<?php Modal::end(); ?>