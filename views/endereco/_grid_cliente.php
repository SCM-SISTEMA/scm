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
            'dataProvider' => app\models\TabEnderecoSearch::buscaCampos(),
            //'filterModel' => $searchModel,
            'columns' => [
                'logradouro',
                [
                    'attribute' => 'numero',
                    'label' => 'Número'
                ],
                'complemento',
                [
                    'attribute' => 'cep',
                    'label' => 'CEP'
                ],
                [
                    'attribute' => 'uf',
                    'label' => 'UF'
                ],
                [
                    'attribute' => 'municipio',
                    'label' => 'Município'
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
                                                        Projeto.prototype.cliente.limpaForm('Endereco');
							Projeto.prototype.cliente.openModal('Endereco');
                                                        Projeto.prototype.cliente.preencheForm(dados, 'Endereco');
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
									 url: '" . Url::toRoute(['excluir-endereco', 'cod_endereco' => $key['cod_endereco']]) . "',
									 type: 'post',
									 success: function (response) {
									 var dados = $.parseJSON(response);
									 $('#divGridEndereco').html(dados.grid);
									 
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