<?php

namespace mgcode\assets;

use yii\base\InvalidConfigException;
use yii\web\AssetBundle;

/**
 * @link https://github.com/mg-code/yii2-assets
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class OwlCarouselScriptAsset extends AssetBundle
{
    public $sourcePath = '@bower/owl.carousel/dist';
    public $js = [
        'owl.carousel.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();
        if(!file_exists(\Yii::getAlias('@bower/owl.carousel/dist/owl.carousel.min.js'))) {
            throw new InvalidConfigException('You must include `bower-asset/owl.carousel` package in your composer.json configuration file.');
        }
    }
}