<?php

use yii\helpers\Html;
use yii\helpers\Url;

dmstr\web\AdminLteAsset::register($this);

if (class_exists('backend\assets\AppAsset')) {
    backend\assets\AppAsset::register($this);
} else {
    app\assets\ProjetoAsset::register($this);
}

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode(Yii::$app->params['nome-sistema'] . ' - ' . Yii::$app->params['descr-sistema']) ?></title>

        <?= Html::tag('base', null, ['href' => Url::home()]) ?>
        <?=
        Html::tag('link', null, [
            'href' => Url::home() . 'favicon-16x16.png',
            'rel' => 'shortcut icon',
            'type' => 'image/vnd.microsoft.icon'
        ])
        ?>
        <?=
        Html::tag('link', null, [
            'href' => Url::home() . 'favicon-32x32.png',
            'rel' => 'shortcut icon',
            'type' => 'image/vnd.microsoft.icon'
        ])
        ?>
        <?php $this->head() ?>
    </head>
    <?php
    //$bodyClass = ['fixed', 'sidebar-mini', 'layout-boxed'];

    $bodyClass[] = 'skin-purple-light';

    $bodyClass[] = 'sidebar-collapse';
    ?>
    <body class="<?= implode(' ', $bodyClass) ?>">
        <?php $this->beginBody() ?>


        <div class="wrapper">

            <?= $this->render('content.php', ['content' => $content, 'directoryAsset' => $directoryAsset]) ?>

        </div>
        <?php $this->endBody() ?>


    </body>
</html>
<?php $this->endPage() ?>
