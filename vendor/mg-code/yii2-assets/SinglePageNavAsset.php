<?php

namespace mgcode\assets;

use yii\base\InvalidConfigException;
use yii\web\AssetBundle;

/**
 * @link https://github.com/mg-code/yii2-assets
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class SinglePageNavAsset extends AssetBundle
{
    public $sourcePath = '@mgcode/assets/files/single-page-nav-1.2.1';
    public $js = ['jquery.singlePageNav.min.js'];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}