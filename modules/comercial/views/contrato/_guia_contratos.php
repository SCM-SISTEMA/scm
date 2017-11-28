    <?=
    kartik\tabs\TabsX::widget([
        'items' => [
            [
                'label' => "<b style=\"color:#337ab7\">Lista de contratos</b>",
               'content' => ['<div id="divGuiaContrato">' .
                                $this->render('@app/modules/comercial/views/contrato/_lista_contratos', ['form'=>$form, 'cod_cliente'=>$model->cod_cliente]) .
                                '</div>'],

                'active' => true,
            ],
            [
                'label' => "<b style=\"color:#337ab7\">Importar Contrato</b>",
                //'content' => $this->render('_dados_tecnicos', compact('model', 'form')),
                'active' => false,
            ],
     
        ],
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'bordered' => true,
        'encodeLabels' => false,
    ])
    ?>