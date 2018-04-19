<?php
/**
 * Created by PhpStorm.
 * User: zhangweiwei
 * Date: 17/7/10
 * Time: 下午2:43
 */

namespace lulutrip\modules\channel\controllers;

use lulutrip\components\Cookies;
use lulutrip\components\Helper;
use Yii;
use yii\helpers\Url;

class ChannelController extends BaseController
{
    public $_refresh;
    public $page = [
        'NA'=>'america',
        'EU'=>'europe',
        'AU'=>'australia_newzealand'
    ];
    public $regionRoot = 'NA';
    public $staticUrl;
    public $_sceneData;

    public function init()
    {
        parent::init();
        $this->layout = 'main';
        $this->defaultAction = 'home';
        $this->staticUrl = Yii::$app->params['staticDomain'] . "/lulutrip/".Yii::$app->params['front_version']."/dist/pages/";
        $this->_sceneData =  \common\library\base\Data::getScenes();
    }

    public function beforeAction($action)
    {
        $cId = $this->id;
        $aId = $action->id;
        Helper::setSeo($cId, $aId);

        //刷新参数
        $this->_refresh = Yii::$app->request->get('refresh', false);
        return parent::beforeAction($action);

    }

    public function actions()
    {
        return [
            'home' => 'lulutrip\modules\channel\actions\channel\Home',
            'america' => 'lulutrip\modules\channel\actions\channel\America',
            'europe' => 'lulutrip\modules\channel\actions\channel\Europe',
            'australia_newzealand' => 'lulutrip\modules\channel\actions\channel\AustraliaNewzealand',
        ];
    }

} 