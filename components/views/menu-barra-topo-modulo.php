<?php

use yii\helpers\Url;
use projeto\helpers\Html;
use app\models\RlcModulosPrestadoresSearch;
use app\models\TabAtributosValoresSearch;

$controller = \Yii::$app->controller;
$module = $controller->module;
$infoModule = $module->info;

$url = \Yii::$app->urlManager->createUrl("/{$module->id}/{$controller->id}/selecionar-ano-ref");


?>

<ul class="nav navbar-nav">
	<?php if(count($modulos) > 1): ?>
		<li class="dropdown">
			<?= $infoModule['txt_nome'] ?>
			
		</li>
	<?php else: ?>
		<li>
			<a href="<?= Url::toRoute($infoModule['txt_url']) ?>" title="<?= $infoModule['dsc_modulo'] ?>" class="titulo-modulo"><?= $infoModule['txt_nome'] ?></a>
		</li>
	<?php endif; ?>
		
	
</ul>

<?= Html::hiddenInput('urlSelecionarAnoRef', $url) ?>