<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="row">
    <?php if (isset($msg)) { ?>
        <div class="col-md-12">
            <div class="alert-<?= $msg['tipo'] ?> alert fade in">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <i class="icon fa fa-<?= $msg['icon'] ?>"></i>
                <?= $msg['msg'] ?>
            </div>
        </div>
    <?php } ?>
    <div class="col-lg-12"> 
        <?=
        yii\grid\GridView::widget([
            'dataProvider' => app\models\TabContatoSearch::buscaCampos(),
            //'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'tipo_desc',
                    'label' => 'Tipo Contato'
                ],
                [
                    'attribute' => 'contato_desc',
                    'label' => 'Contato'
                ],
                'ativo:boolean',
                ['class' => 'projeto\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($urls, $key, $class) {

                            $dados = \yii\helpers\Json::encode($key);
                            return Html::a(
                                            '<span class="glyphicon glyphicon-pencil"> </span>', '#', [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Alterar',
                                        'data-pjax' => '0',
                                        'onclick' => " 
							var dados = {$dados};
                                                        Projeto.prototype.cliente.limpaForm('Contato');
							Projeto.prototype.cliente.openModal('Contato');
                                                        Projeto.prototype.cliente.preencheForm(dados, 'Contato');
            						return false;
							"
                                            ]
                            );
                        },
                        'delete' => function ($urls, $key, $class) {

                            $dados = \yii\helpers\Json::encode($key);

                            return Html::a(
                                            '<span class="glyphicon glyphicon-trash"> </span>', '#', [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Excluir',
                                        'data-pjax' => '0',
                                        'onclick' => "	
							yii.confirm('" . Yii::t('yii', 'Are you sure you want to delete this item?') . "', function (){
								$.ajax({
									 url: '" . Url::toRoute(['excluir-contato', 'cod_contato' => $key['cod_contato']]) . "',
									 type: 'post',
									 success: function (response) {
									 var dados = $.parseJSON(response);
									 $('#divGridContato').html(dados.grid);
									 
									}
								});
							}, function () {
							  return false;
							});
							return false;
						"
                                            ]
                            );
                        }
                    ,
                    ]
                ],
            ],
        ]);
        ?>

    </div>
</div>