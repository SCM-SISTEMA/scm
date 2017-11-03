
<div class='row'>
<?php if (isset($msgT)) { ?>
        <div class="col-md-12">
            <div class="alert-<?= $msgT['tipo'] ?> alert fade in">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <i class="icon fa fa-<?= $msgT['icon'] ?>"></i>
                <?= $msgT['msg'] ?>
            </div>
        </div>
    <?php } ?>
    
    <div class='col-lg-12'  style=" text-align:right">
            <?=
            \projeto\helpers\Html::button('<i class="glyphicon glyphicon-plus"></i> Novo Serviço', [
                'class' => 'btn btn-success btn-sm',
                'id' => 'incluirTipoContrato',
              
                'onclick' => "adicionarTipoContrato('{$contrato['attributes']['cod_contrato']}')",
            ])
            ?>
    </div>
</div> 
<?php 

if ($contrato['tipo_contratos']) : ?>

    <?php foreach ($contrato['tipo_contratos'] as $key => $tipo_contrato): ?>

        <?php if ($tipo_contrato['cod_contrato_fk']) $contratoNome = app\models\TabAtributosValoresSearch::find()->where(['cod_atributos_valores' => $tipo_contrato['tipo_produto_fk']])->asArray()->one()['dsc_descricao']; ?>

        <?php

        $guias[] = [
          
            'label' => "<b style=\"color:#337ab7\">{$contratoNome}</b>",
            'content' =>$contratoNome ,
            'active' => false,
        ];
        
        ?>
    <?php endforeach; ?>

    <?=

    kartik\tabs\TabsX::widget([
        'id' => 'box-servico-' . $contrato['attributes']['cod_contrato'],
        'items' => $guias
        
            
        ,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'bordered' => true,
        'encodeLabels' => false,
    ])
    ?>
<?php endif; ?>