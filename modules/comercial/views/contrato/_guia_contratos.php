<div class='row'>
    <?php if (isset($msg)) { ?>
        <div class="col-md-12">
            <div class="alert-<?= $msg['tipo'] ?> alert fade in">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <i class="icon fa fa-<?= $msg['icon'] ?>"></i>
                <?= $msg['msg'] ?>
            </div>
        </div>
    <?php } ?>
    <div class='col-lg-12'  style=" text-align:right">
            <?=
            \projeto\helpers\Html::button('<i class="glyphicon glyphicon-plus"></i> Novo Contrato', [
                'class' => 'btn btn-success btn-sm',
                'id' => 'addContrato',
                'onclick' => 'adicionarContrato()',
            ])
            ?>
    </div>
</div> 
<br/>
<div class='row'>
    <div class='col-lg-12'>


        <?php $contratos = \Yii::$app->session->get('contratos'); ?>
        <?php if ($contratos) : ?>
            <?php foreach ($contratos as $key => $contrato): ?>
        
                <?php
                $nomeContrato = \app\models\TabAtributosValoresSearch::find()->where(['cod_atributos_valores' => $contrato['attributes']['tipo_contrato_fk']])->one();
                /* $itens[] = [
                  'label' => "<b style=\"color:#337ab7\">Contrato - {$nomeContrato->dsc_descricao} </b>",
                  'content' => $this->render('_guia_contrato', compact('form', 'contrato', 'key')),
                  'active' => false,
                  ];) */
                ?>



                <?php
                echo yii\bootstrap\Collapse::widget([
                    'id' => 'box-contrato-' . $key,
                    'items' => [
                        //DICA
                        [
                            'label' => "{$nomeContrato->dsc_descricao}",
                            'content' => [$this->render('_guia_contrato', compact('form', 'contrato', 'key'))],
                            'encode' => false,
                            'contentOptions' => ($key == 0) ? ['class' => 'in'] : [],
                        // open its content by default
                        ],
                    ]
                ]);
                ?>

            <?php endforeach; ?>
            <?php /* echo
              kartik\tabs\TabsX::widget([
              'items' => $itens,
              'position' => kartik\tabs\TabsX::POS_ABOVE,
              'bordered' => true,
              'encodeLabels' => false,
              ])
             */ ?>


        <?php endif; ?>
    </div>
</div> 