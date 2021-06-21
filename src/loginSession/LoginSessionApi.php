<?php

namespace by\component\api5client\loginSession;

use by\component\api5client\infra\BaseApi;
use by\component\api5client\infra\RequestPoBuilder;

class LoginSessionApi extends BaseApi
{
    public function __construct()
    {
        parent::__construct('', '','', '', '');
    }

    public function check() {
        $bussParams = [
            'nonce' => time()
        ];
        $po = RequestPoBuilder::getInstance()
            ->bussParams($bussParams)
            ->serviceInfo('LoginSession/check','100')
            ->build();

        return $this->send($po);
    }

//    public function login() {
//        $bussParams = [
//            'device_token' => md5(date("Ymd")),
//            'device_type' => 'server',
//            'mobile' => '12345678900',
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
