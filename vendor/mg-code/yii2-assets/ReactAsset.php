<?php

namespace mgcode\assets;

use yii\base\InvalidConfigException;
use yii\web\AssetBundle;

/**
 * @link https://github.com/mg-code/yii2-assets
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class ReactAsset extends AssetBundle
{
    public $sourcePath = '@bower/react';
    public $js = [
        'react.min.js',
    ];

    public function init()
    {
        parent::init();
        if (!file_exists(\Yii::getAlias('@bower/react/react.min.js'))) {
            throw new InvalidConfigException('You must include `bower-asset/react` package in your composer.json configuration file.');
        }
    }
}