<?php ?>
<?php foreach ($empresas as $key => $empresa) : ?>
    <?php
    $nome = $empresa[0]->cod_municipio_fk;
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
                'content' => $this->render('_form_distribuicao_municipio', compact('empresa', 'sici', 'form', 'key')),
                'active' => true,
            ],
        ],
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'bordered' => true,
        'encodeLabels' => false,
    ])
    ?>
  
    <hr/>
<?php endforeach; ?>
