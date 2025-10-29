<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ClientAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/client-index.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',      // содержит yii.js и pjax
        'yii\bootstrap5\BootstrapAsset',
    ];
}
