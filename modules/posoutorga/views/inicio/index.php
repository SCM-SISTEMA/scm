<?php

use yii\helpers\Html;
use app\components\MenuLateralModuloWidget;

$infoModulo = $this->context->module->info;
$this->params['breadcrumbs'][] = $this->context->titulo;
?>

<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= $total ?></h3>

              <p>Total Mês</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= $totalE ?></sup></h3>

              <p>Total Enviado pelo usuário</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?= $totalP ?></h3>

              <p>Total Pendente</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $totalC ?></h3>

              <p>Total Checado</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>


<?php

echo yii\bootstrap\Collapse::widget([
    'id' => 'box',
    'items' => [
        //DICA
        [
            'label' => "<i class='fa fa-info-circle'></i> Dicas do " . $infoModulo['dsc_modulo'],
            'content' =>
            ['1 - Cras justo odio',
                '2 - Dapibus ac facilisis in',
                '3 - Morbi leo risus',
                '4 - Porta ac consectetur ac',
                '5 - Vestibulum at eros'
            ],
            'encode' => false,
            'contentOptions' => ['class' => 'in'],
        // open its content by default
        ],
        [
            'label' => "<i class='fa fa-info-circle'></i> Informações ",
            'content' =>
            ['1 - Cras justo odio',
                '2 - Dapibus ac facilisis in',
                '3 - Morbi leo risus',
                '4 - Porta ac consectetur ac',
                '5 - Vestibulum at eros'
            ],
            'encode' => false,
            'contentOptions' => ['class' => 'in'],
        // open its content by default
        ],
    ]
]);
?>
<?php

$info = $this->context->module->getInfo();
$box = 1;

if ($info['usuario-modulo']['qtd_acesso_perfil'] < 5) {
    $box = 2;
}

$this->registerJs("
	$('#box-collapse{$box}').removeClass('in');
	", \yii\web\VIEW::POS_LOAD);
?>
            




