<?php

use yii\helpers\Html;
use yii\helpers\Url;

dmstr\web\AdminLteAsset::register($this);
app\assets\ProjetoAsset::register($this);

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
    <body class="layout-top-nav">
        <?php $this->beginBody() ?>
        
        <div style="height: 40px;">&nbsp;</div>

        <div class="wrapper">
            <?= $this->render('header-publico.php', ['directoryAsset' => $directoryAsset]) ?>
            <?= $this->render('content.php', ['content' => $content]) ?>
        </div>

        <div style="background-color: #f5f5f5; height: 60px;">&nbsp;</div>

   
        <?php $this->endBody() ?>

        <style type="text/css">
            .content-wrapper, .right-side{
                background: #222d32 none repeat scroll 0 0;
            }
            .container-fluid {
                margin-right: auto;
                margin-left: auto;
                max-width: 950px; /* or 950px */
            }
            div.content-wrapper {
                min-height: 100px; 
            }
        </style>

        <script type="text/javascript">
            $(function () {
                $('div.content-wrapper').css('min-height', '500px')
            });
        </script>

    </body>
</html>
<?php $this->endPage() ?>
