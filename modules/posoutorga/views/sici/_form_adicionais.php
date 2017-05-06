
<?=

kartik\tabs\TabsX::widget([
    'items' => [
        [
            'label' => "<b style=\"color:#337ab7\">Qte de cabos em Km</b>",
            'content' => $this->render('_form_adicionais_cabo', compact('sici', 'form')),
            'active' => true,
        ],
        [
            'label' => "<b style=\"color:#337ab7\">Qte de fibras dentro dos cabos em Km</b>",
            'content' => $this->render('_form_adicionais_fibra', compact('sici', 'form')),
            'active' => false,
        ],
        [
            'label' => "<b style=\"color:#337ab7\">IEM1 - Periodicidade ANUAL</b>",
            'content' => $this->render('_form_adicionais_iem1', compact('sici', 'form')),
            'active' => false,
        ],
        [
            'label' => "<b style=\"color:#337ab7\">IEM2 - Periodicidade ANUAL</b>",
            'content' => $this->render('_form_adicionais_iem2', compact('sici', 'form')),
            'active' => false,
        ],
    ],
    'position' => kartik\tabs\TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false,
])
?>