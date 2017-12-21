<?php
/* @var $this yii\web\View */
/* @var $searchModel app\modules\comercial\models\TabContratoParcelasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;

$provider = new \yii\data\ActiveDataProvider([
    'query' => $anexos,
//    'sort' => [
//        'attributes' => ['cod_cliente'],
//    ],
    'pagination' => [
        'pageSize' => 100,
    ],
        ]);
?>
<br>
<br>
<br>
<div class='row'>


    <div class='col-lg-12'>
        <?=
        GridView::widget([
            'dataProvider' => $provider,
            'columns' => [
                array(
                    'label' => 'Código',
                    'attribute' => 'cod_contrato_anexo',
                ),
                
                'nome',
                
                array(
                    'label' => 'Inclusão',
                    'attribute' => 'dt_inclusao',
                    
                ),
                ['class' => 'projeto\grid\ActionColumn',
                    'template' => '{download} {delete}',
                    'buttons' => [
                       
                        'delete' => function ($urls, $key, $class) {

                            $dados = \yii\helpers\Json::encode($key);

                            return \yii\helpers\Html::a(
                                            '<span class="glyphicon glyphicon-trash"> </span>', '#', [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Excluir',
                                        'data-pjax' => '0',
                                        'onclick' => "	
							yii.confirm('" . Yii::t('yii', 'Are you sure you want to delete this item?') . "', function (){
								$.ajax({
									 url: '" . yii\helpers\Url::toRoute(['contrato-anexo/excluir-anexo', 'cod_contrato_anexo' => $key['cod_contrato_anexo']]) . "',
									 type: 'post',
									 success: function (response) {
									 var dados = $.parseJSON(response);
									 $('#listaAnexo').html(dados);
									 
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
                             'download' => function ($action, $model, $key) {
                           
                                    return \yii\helpers\Html::a('<span class="fa fa-download"></span>', '#', [
                                                'arialabel' => 'Download Arquivo',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Download Arquivo',
                                                'onclick' => "javascript: window.open('" . $model['url'] . "'); return false;",
                                    ]);
                                
                            },
                    ]
                ],
            ],
        ]);
        ?>
    </div>

</div> 





