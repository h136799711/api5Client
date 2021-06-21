<?php

namespace by\component\api5client\infra;
class RequestPo
{
    private $serviceVersion;
    private $serviceType;

    private $bussData;
    private $appVersion;
    private $appType;
    private $lang;
    private $appRequestTime;
    private $clientId;
    private $notifyId;
    private $sign;

    /**
     * RequestPo constructor.
     */
    public function __construct()
    {
        // 默认值
        $this->appVersion = '20210621';
        $this->appType = 'api5client';
        $this->lang = LangUtil::ZhCn;
        $this->serviceVersion = '100';
    }

    /**
     * @return mixed
     */
    public function getServiceVersion()
    {
        return $this->serviceVersion;
    }

    /**
     * @param mixed $serviceVersion
     */
    public function setServiceVersion($serviceVersion)
    {
        $this->serviceVersion = $serviceVersion;
    }

    /**
     * @return mixed
     */
    public function getServiceType()
    {
        return $this->serviceType;
    }

    /**
     * @param mixed $serviceType
     */
    public function setServiceType($serviceType)
    {
        $this->serviceType = $serviceType;
    }

    /**
     * @return mixed
     */
    public function getAppVersion()
    {
        return $this->appVersion;
    }

    /**
     * @param mixed $appVersion
     */
    public function setAppVersion($appVersion)
    {
        $this->appVersion = $appVersion;
    }

    /**
     * @return mixed
     */
    public function getAppType()
    {
        return $this->appType;
    }

    /**
     * @param mixed $appType
     */
    public function setAppType($appType)
    {
        $this->appType = $appType;
    }

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param mixed $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * @return mixed
     */
    public function getAppRequestTime()
    {
        return $this->appRequestTime;
    }

    /**
     * @param mixed $appRequestTime
     */
    public function setAppRequestTime($appRequestTime)
    {
        $this->appRequestTime = $appRequestTime;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getBussData()
    {
        return $this->bussData;
    }

    /**
     * @param mixed $bussData
     */
    public function setBussData($bussData)
    {
        $this->bussData = $bussData;
    }

    /**
     * @return mixed
     */
    public function getNotifyId()
    {
        return $this->notifyId;
    }

    /**
     * @param mixed $notifyId
     */
    public function setNotifyId($notifyId)
    {
        $this->notifyId = $notifyId;
    }

    /**
     * @return mixed
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @param mixed $sign
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
    }


    /**
     * @return array
     */
    public function toArray() {
        return [
            'sign' => $this->getSign(),
            'buss_data' => $this->getBussData(),
            'notify_id' => $this->getNotifyId(),
            'app_request_time' => $this->getAppRequestTime(),
            'lang' => $this->getLang(),
            'app_type' => $this->getAppType(),
            'app_version' => $this->getAppVersion(),
            'client_id' => $this->getClientId()
        ];
    }
}
