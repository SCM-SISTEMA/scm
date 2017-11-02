<?php

namespace mgcode\assets;

use yii\web\AssetBundle;

/**
 * @link https://github.com/mg-code/yii2-assets
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class BootstrapClickableDropdownAsset extends AssetBundle
{
    public $sourcePath = '@mgcode/assets/files/bootstrap-clickable-dropdown';
    public $js = [
        'bootstrap-clickable-dropdown.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}