<div id="acessoFisicoTecnologia-<?= $empresa->cod_empresa_municipio ?>">

    <?php
    $nome = $empresa->cod_municipio_fk;
    if ($nome) {
        $nome = app\models\TabMunicipiosSearch::find()->where(['cod_municipio' => $nome])->one();
        if (!$nome) {
            $nome = $uf = '';
        } else {

            $uf = $nome->sgl_estado_fk;
            $nome = $nome->txt_nome;
        }
    } else {
        $nome = $uf = '';
    }
    ?>
    <?=
    kartik\tabs\TabsX::widget([
        'items' => [
            [
                'label' => "<b style=\"color:#337ab7\">{$nome} - {$uf}</b>",
                'content' => '<div id="acessoFisico">'.$this->render('_form_distribuicao_municipio', compact('empresa', 'form')).'</div>',
                'active' => true,
            ],
        ],
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'bordered' => true,
        'encodeLabels' => false,
    ])
    ?>
</div>