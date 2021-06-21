<?php

namespace by\component\api5client\infra;

use by\component\http\ByHttp\Http\Psr7\Consts\MediaType;
use by\component\http\ByHttp\Http\Psr7\Consts\RequestHeader;
use by\component\http\HttpRequest;
use by\infrastructure\constants\BaseErrorCode;
use by\infrastructure\helper\CallResultHelper;

abstract class BaseApi
{
    private $apiUri;
    private $clientId;
    private $clientSecret;
    private $http;
    private $systemPublicKey;
    private $userPrivateKey;

    /**
     * BaseHttpClient constructor.
     * @param $apiUri
     * @param $clientId
     * @param $clientSecret
     * @param string $systemPublicKey 一行
     * @param string $userPrivateKey 一行
     */
    public function __construct($apiUri, $clientId, $clientSecret, $systemPublicKey, $userPrivateKey)
    {
        $this->apiUri = $apiUri;
        $this->clientSecret = $clientSecret;
        $this->clientId = $clientId;
        $this->systemPublicKey = RsaUtil::formatPublicText($systemPublicKey);
        $this->userPrivateKey = RsaUtil::formatPrivateText($userPrivateKey);
        $this->http = new HttpRequest();
    }

    private function guid()
    {
        mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);// "}"
        return $uuid;
    }

    private function getServiceUrl(RequestPo $requestPo)
    {
        return rtrim($this->apiUri, '/') . '/' . $requestPo->getServiceVersion() . '/' . $requestPo->getServiceType();
    }

    function send(RequestPo $requestPo)
    {
        $requestPo->setNotifyId($this->guid());
        $requestPo->setAppRequestTime(time());
        $requestPo->setClientId($this->clientId);
        $requestPo->setSign($this->sign($requestPo));
        $requestPo->setBussData($this->encrypt($requestPo));
        $postArr = $requestPo->toArray();
        var_dump($postArr);
        $url = $this->getServiceUrl($requestPo);
        $resp = $this->http
            ->header(RequestHeader::CONTENT_TYPE, MediaType::APPLICATION_FORM_URLENCODED)
            ->post($url, $postArr);
        if (!$resp->success) {
            return CallResultHelper::fail('[请求错误]' . $resp->getError(), $resp->getError());
        }
        if ($resp->getStatusCode() < 200 || $resp->getStatusCode() > 299) {
            return CallResultHelper::fail('[响应码错误]' . ($resp->getReasonPhrase() ? '未知' : $resp->getReasonPhrase()), $resp->getStatusCode());
        }
        $respContent = $resp->getBody()->getContents();
        $json = json_decode($respContent, JSON_OBJECT_AS_ARRAY);
        if (is_array($json) && array_key_exists('code', $json) && array_key_exists('msg', $json)) {
            if (!array_key_exists('data', $json)) {
                $json['data'] = '';
            }
            if ($json['code'] == BaseErrorCode::Success) {
                return CallResultHelper::success($json['data'], $json['msg']);
            } else {
                return CallResultHelper::fail($json['msg'], $json['data'], $json['code']);
            }
        } else {
            return CallResultHelper::fail('[响应数据不是JSON格式]', $respContent);
        }
    }

    protected function convertServiceType($serviceType) {
        return 'by_'.str_replace('/', '_', $serviceType);
    }

    private function sign(RequestPo $po)
    {
        $origin = $po->getAppRequestTime() . $this->clientSecret . $this->convertServiceType($po->getServiceType()) . $po->getServiceVersion() . $po->getBussData();
        return RsaUtil::sign($origin, $this->userPrivateKey);
    }

    private function encrypt(RequestPo $po)
    {
        var_dump($po->getBussData());
        return RsaUtil::encryptChunk($po->getBussData(), $this->systemPublicKey);
    }

    /**
     * @return mixed
     */
    public function getApiUri()
    {
        return $this->apiUri;
    }

    /**
     * @param mixed $apiUri
     */
    public function setApiUri($apiUri)
    {
        $this->apiUri = $apiUri;
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
     * @return HttpRequest
     */
    public function getHttp()
    {
        return $this->http;
    }

    /**
     * @param HttpRequest $http
     */
    public function setHttp($http)
    {
        $this->http = $http;
    }

    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param mixed $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return string
     */
    public function getSystemPublicKey()
    {
        return $this->systemPublicKey;
    }

    /**
     * @param string $systemPublicKey
     */
    public function setSystemPublicKey($systemPublicKey)
    {
        $this->systemPublicKey = $systemPublicKey;
    }

    /**
     * @return string
     */
    public function getUserPrivateKey()
    {
        return $this->userPrivateKey;
    }

    /**
     * @param string $userPrivateKey
     */
    public function setUserPrivateKey($userPrivateKey)
    {
        $this->userPrivateKey = $userPrivateKey;
    }
}
