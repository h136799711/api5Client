<?php

namespace by\component\api5client\infra;

use by\component\http\ByHttp\Http\Psr7\Consts\MediaType;
use by\component\http\ByHttp\Http\Psr7\Consts\RequestHeader;
use by\component\http\HttpRequest;
use by\component\string_extend\helper\StringHelper;
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
    private $authorization;


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

    protected function guid()
    {
        mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);// "}"
        return $uuid;
    }

    protected function getServiceUrl(RequestPo $requestPo)
    {
        return rtrim($this->apiUri, '/') . '/' . $requestPo->getServiceVersion() . '/' . $requestPo->getServiceType();
    }

    function send(RequestPo $requestPo, $headers = [
        'Content-type' => MediaType::APPLICATION_FORM_URLENCODED
    ])
    {
        $requestPo->setNotifyId($this->guid());
        $requestPo->setAppRequestTime(StringHelper::numberFormat(microtime(true), 3));
        $requestPo->setClientId($this->clientId);
        $requestPo->setSign($this->sign($requestPo));
        $requestPo->setBussData($this->encrypt($requestPo));
        $postArr = $requestPo->toArray();
        $url = $this->getServiceUrl($requestPo);
        if (!empty($this->getAuthorization())) {
            $headers[RequestHeader::AUTHORIZATION] = $this->getAuthorization();
        }
        $resp = $this->http
            ->headers($headers)
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

    protected function sign(RequestPo $po)
    {
        $origin = $po->getAppRequestTime() . $this->clientSecret . $this->convertServiceType($po->getServiceType()) . $po->getServiceVersion() . $po->getBussData();
        return RsaUtil::sign($origin, $this->userPrivateKey);
    }

    protected function encrypt(RequestPo $po)
    {
        return RsaUtil::encryptChunk($po->getBussData(), $this->systemPublicKey);
    }

    /**
     * @return string
     */
    public function getApiUri()
    {
        return $this->apiUri;
    }

    /**
     * @param string $apiUri
     * @return $this
     */
    public function setApiUri($apiUri)
    {
        $this->apiUri = $apiUri;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     * @return $this
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
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
     * @return $this
     */
    public function setHttp($http)
    {
        $this->http = $http;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     * @return $this
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
        return $this;
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
     * @return $this
     */
    public function setSystemPublicKey($systemPublicKey)
    {
        $this->systemPublicKey = $systemPublicKey;
        return $this;
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
     * @return $this
     */
    public function setUserPrivateKey($userPrivateKey)
    {
        $this->userPrivateKey = $userPrivateKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @param string $authorization
     * @return $this
     */
    public function setAuthorization($authorization)
    {
        $this->authorization = $authorization;
        return $this;
    }
}
