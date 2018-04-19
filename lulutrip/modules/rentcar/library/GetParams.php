<?php
/**
 * 重组参数
 * @copyright 2017-10-12
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\library;
use yii\base\Component;
use Yii;

class GetParams extends Component
{
    /**
     * 整合参数
     * @copyright 2017-10-13
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @return array
     */
    public static function getParam() {
        $params = Yii::$app->request->get('params', array());
        $param = array();
        if ($params) {
            $params = explode('_', $params);
            foreach ($params as $item) {
                if (strstr($item, 'pDate') || strstr($item, 'rDate')) {
                    $items = explode('-', $item);
                    $param[$items[0]] = $items[1] . '-' . $items[2] . '-' . $items[3];
                } else {
                    $items = explode('-', $item);
                    $param[$items[0]] = $items[1];
                }
            }
        }

        $param['type'] = self::getFilter($param, 'type');
        $param['seat'] = self::getFilter($param, 'seat');
        $param['pDate'] = isset($param['pDate']) ? $param['pDate'] : date('Y-m-d', strtotime('+5 days'));
        $param['rDate'] = isset($param['rDate']) ? $param['rDate'] : date('Y-m-d', strtotime('+6 days'));
        $param['pTime'] = isset($param['pTime']) ? $param['pTime'] : '10:00';
        $param['rTime'] = isset($param['rTime']) ? $param['rTime'] : '10:00';
        $param['daylen'] = ceil((strtotime($param['rDate'] . ' ' . $param['rTime']) - strtotime($param['pDate'] . ' ' . $param['pTime'])) / 86400);
        $param['pt'] = (strtotime($param['pTime']) - strtotime('00:00')) / 1800;
        $param['rt'] = (strtotime($param['rTime']) - strtotime('00:00')) / 1800;
        //2 => 旧金山国际机场
        $param['pLc'] = isset($param['pLc']) ? intval($param['pLc']) : 2;
        $param['rLc'] = isset($param['rLc']) ? intval($param['rLc']) : 2;
        $param['page'] = isset($param['page']) ? intval($param['page']) : 1;
        return $param;
    }

    /**
     * 处理多选筛选参数
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-01-06
     * @param $param
     * @param $filter
     * @return array
     */
    private static function getFilter($param, $filter)
    {
        $data = [];
        if (isset($param[$filter])) {
            if(strstr($param[$filter], '|')) {
                foreach (explode('|', $param[$filter]) as $val) {
                    $data[] = intval($val);
                }
            } else {
                $data = [intval($param[$filter])];
            }
            unset($param[$filter]);
            if (in_array('0', $data)) {
                $data = [0];
            }
        } else {
            $data = [0];
        }
        return $data;
    }

    /**
     * 重组URL
     * @copyright 2017-10-13
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @return string
     */
    public function mergeUrl($param) {
        $www = Yii::$app->params['service']['www'];
        $newUrl = $www . '/rental-car/entry';
        $url = [];
        if ($param['pDate'] != date('Y-m-d', strtotime('+5 days'))) {
            $url[] = "pDate-{$param['pDate']}";
        }
        if ($param['rDate'] != date('Y-m-d', strtotime('+6 days'))) {
            $url[] = "rDate-{$param['rDate']}";
        }
        if ($param['pTime'] != '10:00') {
            $url[] = "pTime-{$param['pTime']}";
        }
        if ($param['rTime'] != '10:00') {
            $url[] = "rTime-{$param['rTime']}";
        }
        if (!in_array(0, $param['type'])) {
            $type = implode('|', $param['type']);
            $url[] = "type-{$type}";
        }
        if ($param['pLc'] != 2) {
            $url[] = "pLc-{$param['pLc']}";
        }
        if ($param['rLc'] != 2) {
            $url[] = "rLc-{$param['rLc']}";
        }
        $url[] = "page-{$param['page']}";
        if (!empty($url)) {
            $newUrl .= '/' . implode('_', $url);
        }
        return $newUrl;
    }

    /**
     * 重组详情页参数
     * @copyright 2017-10-13
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @param $params
     * @return mixed
     */
    public static function adaptParams($params) {
        $param['pDate'] = isset($params['pDate']) ? $params['pDate'] : date('Y-m-d', strtotime('+5 days'));
        $param['rDate'] = isset($params['rDate']) ? $params['rDate'] : date('Y-m-d', strtotime('+6 days'));
        $param['pt'] = isset($params['pt']) ? intval($params['pt']) : 20;
        $param['rt'] = isset($params['rt']) ? intval($params['rt']) : 20;
        $param['pLc'] = isset($params['pLc']) ? intval($params['pLc']) : 2;
        $param['rLc'] = isset($params['rLc']) ? intval($params['rLc']) : 2;
        $param['in'] = isset($params['in']) ? intval($params['in']) : 1;
        $param['days'] = isset($params['days']) ? intval($params['days']) : 0;
        if ($param['days'] > 0) {
            $param['rDate'] = date('Y-m-d', (strtotime($param['pDate']) + $param['days'] * 86400));
            $param['rt'] = $param['pt'];
        }
        if (isset($params['departure'])) {
            $departure = ['LAX' => 1, 'SFO' => 2, 'LAS' => 3];
            $param['pLc'] = $param['rLc'] = $departure[$params['departure']];
        }
        return $param;
    }
}