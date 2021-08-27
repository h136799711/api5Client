<?php

namespace by\component\api5client\infra;

class RequestPoBuilder
{
    /**
     * @var RequestPo
     */
    private $po;
    /**
     * @var RequestPoBuilder|null
     */
    private static $_instance = null;

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new RequestPoBuilder();
            self::$_instance->po = null;
            self::$_instance->po = new RequestPo();
        }
        return self::$_instance;
    }

    function bussParams(array $bussParams) {
        ksort($bussParams, SORT_ASC);
        self::getInstance()->po->setBussData(json_encode($bussParams, JSON_UNESCAPED_UNICODE));
        return self::getInstance();
    }

    function serviceInfo($serviceType, $serviceVersion = '100') {
        self::getInstance()->po->setServiceType($serviceType);
        self::getInstance()->po->setServiceVersion($serviceVersion);
        return self::getInstance();
    }

    function build() {
        return self::getInstance()->po;
    }
}
