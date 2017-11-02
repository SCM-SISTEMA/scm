<?php

namespace mgcode\assets;

use yii\base\InvalidConfigException;
use yii\web\AssetBundle;

/**
 * @link https://github.com/mg-code/yii2-assets
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class AutobahnJsAsset extends AssetBundle
{
    public $sourcePath = '@mgcode/assets/files/autobahnjs-0.8.2';
    public $js = ['autobahn.min.js'];
}