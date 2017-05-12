
<?=
\projeto\helpers\Html::button('<i class="glyphicon glyphicon-plus"></i> Adicionar acesso físico', [
    'class' => 'btn btn-success btn-sm',
    'id' => 'addAcesso',
    'onclick' => 'adicionar()',
])
?>

<div id="acessoFisico">
    <?php if ($empresas) : ?>
        <?php foreach ($empresas as $key => $empresa) : ?>
            <?php echo $this->render('_form_distribuicao_tab', compact('empresa', 'sici', 'form', 'key')); ?>

            <hr/>
        <?php endforeach; ?>
    <?php else : ?>
        <div class='row'>
            <div class='col-lg-6'>
                Não existe nenhum acesso cadastrado.
            </div>

        </div>
    <?php endif; ?>
</div>
