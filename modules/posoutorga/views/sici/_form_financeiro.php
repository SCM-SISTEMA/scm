

<div class='row'>
    <div class='col-lg-6'>

        <?=
        kartik\tabs\TabsX::widget([
            'items' => [
                [
                    'label' => "<b style=\"color:#337ab7\">Receita - valor total (em reais)</b>",
                    'content' => $this->render('_form_financeiro_receita', compact('sici', 'form', 'addon')),
                    'active' => false,
                ],
            ],
            'position' => kartik\tabs\TabsX::POS_ABOVE,
            'bordered' => true,
            'encodeLabels' => false,
        ])
        ?>



    </div>
    <div class='col-lg-6'>

        <?=
        kartik\tabs\TabsX::widget([
            'items' => [
                [
                    'label' => "<b style=\"color:#337ab7\">Despesa - valor total (em reais)</b>",
                    'content' => $this->render('_form_financeiro_despesa', compact('sici', 'form', 'addon')),
                    'active' => false,
                ],
            ],
            'position' => kartik\tabs\TabsX::POS_ABOVE,
            'bordered' => true,
            'encodeLabels' => false,
        ])
        ?>

    </div>
</div>
