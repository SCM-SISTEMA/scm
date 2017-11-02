<?php

namespace mgcode\assets;

use yii\base\InvalidConfigException;
use yii\web\AssetBundle;

/**
 * @link https://github.com/mg-code/yii2-assets
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class MessageFormatAsset extends AssetBundle
{
    public $sourcePath = '@bower/messageformat';
    public $js = [
        'messageformat.min.js',
    ];

    public function init()
    {
        parent::init();
        if(!file_exists(\Yii::getAlias('@bower/messageformat/messageformat.min.js'))) {
            throw new InvalidConfigException('You must include `bower-asset/messageformat` package in your composer.json configuration file.');
        }
    }
}