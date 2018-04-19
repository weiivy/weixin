<?php
namespace lulutrip\modules\llt\actions\common;

use lulutrip\library\History;
use yii\base\Action;

class ProductHistory extends Action
{
    public function run()
    {
        History::getHistoryData();die;
    }
}