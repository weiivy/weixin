<?php
/**
 * Seo类
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\library;

use yii\base\Component;

class Seotdk extends Component
{
    public $tdk = array();

    public function __construct() {
        $this->tdk =  require(__DIR__ . '/../data/meta.php');
    }

    /**
     * 获取静态的TDK(存放在meta.php文件中)
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-10
     * @param $getc                 数组中的第一个下标
     * @param $getm                 数组中的第二个下标
     * @param null $getParam        数组中的第三个下标，默认为null
     *
     * @return array $staticTDK		返回存储有TDK的数组
     */
    public function getStaticTDK($getc, $getm, $getParam=null) {
        $staticTDK = array();
        if ( !empty($getParam) ) {
            $staticTDK			= $this->tdk[$getc][$getm][$getParam];

        } elseif( !empty($getm) ) {
            $staticTDK			= $this->tdk[$getc][$getm];
            if( empty($staticTDK['title']) && empty($staticTDK['keywords']) && empty($staticTDK['description']) ) {
                $staticTDK			= $this->tdk[$getc][$getm]['init'];
            }
        } elseif( !empty($getc) ) {
            $staticTDK			= $this->tdk[$getc]['init'];
        } else {
            $staticTDK			= $this->tdk['home']['init'];
        }
        if ( empty($staticTDK['title']) && empty($staticTDK['keywords']) && empty($staticTDK['description']) ) {
            $staticTDK			= $this->tdk['home']['init'];
        }

        return $staticTDK;
    }

    /**
     * 获取动态的TDK(存放在meta.php文件中)
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-10
     * @param $getc            数组中的第一个下标
     * @param $getm            数组中的第二个下标
     * @param null $getParam   数组中的第三个下标，默认为null
     *
     * @return array           $dynamicTDK	返回存储有TDK的数组
     */
    public function getDynamicTDK($getc, $getm, $getParam=null) {
        $dynamicTDK = array();
        $dynamicTDK           = $this->tdk[$getc][$getm][$getParam];
        return $dynamicTDK;
    }

    /**
     * 设置静态seo
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-10
     * @param $controller        数组中的第一个下标
     * @param $action            数组中的第二个下标
     * @param null $thirdParam   数组中的第三个下标，默认为null
     *
     * @return array
     */
    public  function setSeoTDK($controller, $action, $thirdParam = null)
    {
        if (!empty($thirdParam)) {
            $staticTDK = $this->getStaticTDK($controller, $action, $_GET[$thirdParam]);
        } else {
            $staticTDK = $this->getStaticTDK($controller, $action, null);
        }

        return array($staticTDK['title'], $staticTDK['keywords'], $staticTDK['description']);
    }

    /**
     * 设置动态seo
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-10
     * @param $controller        数组中的第一个下标
     * @param $action            数组中的第二个下标
     * @param null $param        数组中的第三个下标，默认为null
     * @param array $arr
     *
     * @return array
     */
    public  function setDynTDK($controller, $action, $param, $arr = array())
    {
        $tdkArr = array();
        $tdks = $this->getDynamicTDK($controller, $action, $param);
        if (count($arr) != 0) {
            $tdkTmp = implode('|||', $tdks);
            foreach ($arr as $k => $v) {
                $tdkTmp = str_replace($k, $v, $tdkTmp);
            }
            $tdkArr = explode('|||', $tdkTmp);
        } else {
            $tdkArr = array_values($tdks);
        }
        return $tdkArr;
    }
}