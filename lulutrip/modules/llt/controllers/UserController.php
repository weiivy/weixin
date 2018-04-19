<?php
/**
 * 用户相关信息
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */
namespace lulutrip\modules\llt\controllers;

use lulutrip\library\Users;
use yii\rest\Controller;
use Yii;

class UserController extends Controller {

    /**
     * 订购时登录
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-08-28
     * @return array
     */
    public function actionQuickLogin() {
        $request = Yii::$app->request->post();
        try{
            $user = new Users();
            $user->quickLogin($request);
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 400;
            return ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }
    }

    /**
     * 无注册订购
     * @author Xiaopei Dou<xiaopei.dou@ipptravel.com>
     * @copyright 2018-02-26
     * @return array
     */
    public function actionNoRegisterBuy() {
        $params = Yii::$app->request->post();
        try{
            if(empty($params['email'])){
                $return = [
                    'status' => '1001',
                    'message' => '用户邮箱不能为空',
                ];
            }elseif (!Yii::$app->helper->ce($params['email'])){
                $return = [
                    'status' => '1002',
                    'message' => '邮箱不符合规范',
                ];
            }
            if(!empty($return)){
                echo json_encode($return);
                exit;
            }
            $request['contactInfo']['emailAddress'] = $params['email'];
            $request['contactInfo']['fullName'] = empty($params['fullName'])? '' : $params['fullName'];
            $request['contactInfo']['phoneNumber'] = empty($params['phoneNumber'])? '' : $params['phoneNumber'];
            $product = ['pcode' => $params['productCode'], 'title' => $params['productTitle']];
            $user = new Users();
            $memberid = $user->noRegisterBuy($request,$product);
            if(!empty($memberid) && is_numeric($memberid)){
                $return = [
                    'data' => $memberid,
                    'status' => '1003',
                    'message' => '注册成功'
                ];
            }
            echo json_encode($return);
            exit;
        } catch (\Exception $e) {
            echo json_encode(['status' => $e->getCode(), 'message' => $e->getMessage()]);
            exit;
        }

    }
}