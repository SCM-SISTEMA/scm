
    <?=
    kartik\tabs\TabsX::widget([
        'items' => [
            [
                'label' => "<b style=\"color:#337ab7\">Contrato</b>",
                'content' => $this->render('_form_contrato', compact('model', 'form')),
                'active' => true,
            ],
           
        ],
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'bordered' => true,
        'encodeLabels' => false,
    ])
    ?>

