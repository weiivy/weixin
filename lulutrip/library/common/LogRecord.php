<?php

namespace lulutrip\library\common;


use Yii;
use yii\base\Component;

/**
 * 日志相关
 * @copyright (c) 2018, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class LogRecord extends Component
{
    /**
     * 记录日志
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-01-12
     * @param $firstTime
     * @param $secondTime
     * @param $threeTime
     * @param $firstMem
     * @param $secondMem
     * @param $threeMem
     * @param $method
     */
    public static  function recordDebugInfo($firstTime, $secondTime, $threeTime, $firstMem, $secondMem, $threeMem, $method)
    {
        $endTime = Yii::$app->helper->getMicroTime();
        $endMem = memory_get_usage();
        $debugMsg = "\r\n===Total Processing Time(总处理时间)：" . ($endTime - $firstTime) . "S=== \r\n";
        $debugMsg .= '===API Request Time(请求接口时间)：' . ($threeTime - $secondTime) . "S=== \r\n";
        $debugMsg .= '===Processing Data Time(处理数据时间)：' . (($endTime - $firstTime) - ($threeTime - $secondTime)) . "S=== \r\n";
        $debugMsg .= '===Memory Start(内存开始)：' . round($firstMem/1048576, 2) . "M=== \r\n";
        $debugMsg .= '===Memory End(内存结束)：' . round($endMem/1048576, 2) . "M=== \r\n";
        $debugMsg .= '===Total Memory Consumption(内存总耗)：' . round(($endMem - $firstMem)/1048576, 2) . "M=== \r\n";
        $debugMsg .= '===Api Memory Consumption(调取api内存耗)：' . round(($threeMem - $secondMem)/1048576, 2) . "M=== \r\n";
        $debugMsg .= '===Processing Memory Consumption(处理数据内存耗)：' . round((($endMem - $firstMem) - ($threeMem - $secondMem))/1048576, 2) . "M=== \r\n";
        $debugMsg .= '=====END=======';
        Yii::info($debugMsg, $method);

    }
}