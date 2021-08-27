<?php

namespace by\component\api5client\login_session;

use by\component\api5client\infra\BaseApi;
use by\component\api5client\infra\RequestPoBuilder;

class LoginSessionApi extends BaseApi
{
    public function __construct()
    {
        parent::__construct('', '','', '', '');
    }

    /**
     * 检测是否已登录
     * @param $userId
     * @return \by\infrastructure\base\CallResult
     */
    public function check($userId) {
        $bussParams = [
            'user_id' => $userId
        ];

        return $this->newRequest()
            ->bussParams($bussParams)
            ->call('LoginSession/check', '100');
    }
//    public function login() {
//        $bussParams = [
//            'device_token' => md5(date("Ymd")),
//            'device_type' => 'server',
//            'mobile' => '',
//            'code' => '',
//            'country_no' => '86',
//            'login_info' => ''
//        ];
//        $po = RequestPoBuilder::getInstance()
//            ->bussParams($bussParams)
//            ->serviceInfo('UserLoginSession/loginByMobileCode', '100')->build();
//        return $this->send($po);
//    }
}
