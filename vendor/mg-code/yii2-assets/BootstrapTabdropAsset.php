<?php

namespace mgcode\assets;

use yii\web\AssetBundle;

/**
 * @link https://github.com/mg-code/yii2-assets
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class BootstrapTabdropAsset extends AssetBundle
{
    public $sourcePath = '@mgcode/assets/files/bootstrap-tabdrop';
    public $js = [
        'bootstrap-tabdrop.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}