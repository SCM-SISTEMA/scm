<?php

namespace mgcode\assets;

use yii\base\InvalidConfigException;
use yii\web\AssetBundle;

/**
 * @link https://github.com/mg-code/yii2-assets
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class ReactDomAsset extends AssetBundle
{
    public $sourcePath = '@bower/react';
    public $js = [
        'react-dom.min.js',
    ];
    public $depends = [
        'mgcode\assets\ReactAsset'
    ];
}