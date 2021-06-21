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
            'nonce' => 'a'.strval(rand(1000, 10000))
        ];
        $po = RequestPoBuilder::getInstance()->bussParams($bussParams)
            ->serviceInfo('LoginSession/check','100')
            ->build();
        return $this->send($po);
    }
}
