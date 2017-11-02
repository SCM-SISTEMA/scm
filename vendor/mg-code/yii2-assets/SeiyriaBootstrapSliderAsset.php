<?php

namespace mgcode\assets;

use yii\base\InvalidConfigException;
use yii\web\AssetBundle;

/**
 * @link https://github.com/mg-code/yii2-assets
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class SeiyriaBootstrapSliderAsset extends AssetBundle
{
    public $sourcePath = '@bower/seiyria-bootstrap-slider/dist';
    public $css = [
        'css/bootstrap-slider.min.css',
    ];
    public $js = [
        'bootstrap-slider.min.js',
    ];
    public $depends = [];

    public function init()
    {
        parent::init();
        if(!file_exists(\Yii::getAlias('@bower/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js'))) {
            throw new InvalidConfigException('You must include `bower-asset/seiyria-bootstrap-slider` package in your composer.json configuration file.');
        }
    }
}