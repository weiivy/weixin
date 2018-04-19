<?php
/**
 * message
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\models;


class TourScene extends \common\models\tours\TourScene
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScene()
    {
        return $this->hasOne(Scene::className(), ['sceneid' => 'sceneid']);
    }
} 