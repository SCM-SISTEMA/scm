<?php

use app\components\MenuLateralModuloWidget;


?>

<aside class="main-sidebar">
	<section class="sidebar">
		<?php if (!Yii::$app->user->isGuest): ?>
			<?= MenuLateralModuloWidget::widget() ?>
		<?php endif; ?>
	</section>
</aside>