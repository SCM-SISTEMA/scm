<div class='row'>
    <div class='col-lg-6'>


        <?=
        kartik\tabs\TabsX::widget([
            'items' => [
                [
                    'label' => "<b style=\"color:#337ab7\">FÍSICA</b>",
                    'content' => $this->render('_form_planos_fisico', compact('planoj', 'planof', 'planof_mn', 'planoj_mn', 'form')),
                    'active' => true,
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
                    'label' => "<b style=\"color:#337ab7\">JURÍDICA</b>",
                    'content' => $this->render('_form_planos_juridico', compact('planoj', 'planof', 'planof_mn', 'planoj_mn', 'form')),
                    'active' => true,
                ],
            ],
            'position' => kartik\tabs\TabsX::POS_ABOVE,
            'bordered' => true,
            'encodeLabels' => false,
        ])
        ?>
    </div>
</div>

<div class='row'>
    <div class='col-lg-12'>
        <p>É a MEDIA dos PREÇOS cobrados, preço de tabela. Média é a soma dos valores compreendido na faixa da velocidade e divido pela quantidade de valores. Exemplo: MENOS OU IGUAL A 512kbps: 128k: R$10,00, 256k: R$20,00 e 512k: R$30,00. Soma os valores da faixa de velocidade: 10+ 20 + 30 =  R$60,00 e divide o resultado por 03 (quantidade de valores dentro da faixa) R$60,00 / 3 = R$20,00 -> essa é a média, o valor que deve ser colocado na tabela. Lembrado que é separado por pessoa juridica e fisica.</p>


    </div>
</div>
