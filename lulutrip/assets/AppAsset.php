<?php
/**
 * AppAsset
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
    public $css = [

    ];
    public $js = [
        /*'/js/jquery.min.js',
        '/js/jquery.form.js',
        '/js/My97DatePicker/WdatePicker.js'*/
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
