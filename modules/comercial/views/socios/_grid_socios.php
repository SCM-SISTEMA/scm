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
            'dataProvider' => app\modules\comercial\models\TabSociosSearch::buscaCampos(),
            //'filterModel' => $searchModel,
            'columns' => [
                'nome',
                'nacionalidade',
                'estado_civil_fk',
                'profissao',
                'rg',
                'orgao_uf',
                'cpf',
                [
                    'attribute' => 'representante_comercial',
                    'content' => function($data) {
                        $naoSim = app\models\TabAtributosValoresSearch::find()->where(['cod_atributos_valores' => $data['representante_comercial']])->one()->dsc_descricao;

                        return $naoSim;
                    },
                ],
                'nacimento',
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
                                                            
                                                        Projeto.prototype.cliente.limpaFormSocios();
							Projeto.prototype.cliente.openModalSocios();
                                                        Projeto.prototype.cliente.preencheFormSocios(dados);
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
									 url: '" . Url::toRoute(['socios/excluir-socios', 'cod_socios' => $key['cod_socio']]) . "',
									 type: 'post',
									 success: function (response) {
									 var dados = $.parseJSON(response);
									 $('#divGridSocios').html(dados.grid);
									 
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