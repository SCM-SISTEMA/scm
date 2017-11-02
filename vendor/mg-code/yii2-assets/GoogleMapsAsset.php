<?php

namespace mgcode\assets;

use yii\base\InvalidConfigException;
use yii\web\AssetBundle;

/**
 * @link https://github.com/mg-code/yii2-assets
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class GoogleMapsAsset extends AssetBundle
{
    public function init()
    {
        parent::init();
        $js = '//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places,drawing,geometry,visualization&language=' . \Yii::$app->language;

        if(isset(\Yii::$app->params['googleMapsApiKey'])) {
            $js .= '&key='.\Yii::$app->params['googleMapsApiKey'];
        }

        $this->js[] = $js;
    }
}