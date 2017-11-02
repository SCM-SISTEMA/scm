<?php

namespace mgcode\assets;

use yii\base\InvalidConfigException;
use yii\web\AssetBundle;

/**
 * @link https://github.com/mg-code/yii2-assets
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class OwlCarouselAsset extends AssetBundle
{
    public $sourcePath = '@bower/owl.carousel/dist';
    public $css = [
        'assets/owl.carousel.min.css',
    ];
    public $depends = [
        'mgcode\assets\OwlCarouselScriptAsset',
    ];
}