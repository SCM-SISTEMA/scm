<?php

use projeto\helpers\Html;
use yii\helpers\Url;
use app\models\VisAtributosValores;

?>

<?php
$m = app\modules\admin\models\TabModulosSearch::getEquipeModuloId(\Yii::$app->controller->module->id);
if ($m) {
    echo "<footer class='main-footer'>";
        echo "<b>{$m['txt_equipe']}</b><br/>";
        echo "<i class='fa fa-envelope'></i> " . Html::a($m['txt_email_equipe'], 'mailto:' . $m['txt_email_equipe'] . '') . "&nbsp&nbsp&nbsp";
        echo Html::icon('phone-alt', $m['num_fones_equipe']);
    echo "</footer>";
}
?>
