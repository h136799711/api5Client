<?php

namespace by\component\api5client\infra;

class RsaUtil
{

    /**
     * 生成RSA的公钥和私钥，返回数组第一位为公钥、第二位为私钥
     * @param string $digestAlg
     * @param int $bit 位数默认2048位 越多字符串长度越长
     * @param int $keyType
     * @return array
     */
    public static function generateRsaKeys($digestAlg = 'sha512', $bit = 2048, $keyType = OPENSSL_KEYTYPE_RSA) {
        $config = array(
            "digest_alg" => $digestAlg,
            "private_key_bits" => $bit,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        $res = openssl_pkey_new($config);
        openssl_pkey_export($res, $privKey);

        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];
        return [$pubKey, $privKey];
    }

    /**
     * 移除 公钥中的 换行符号，开头 结束字符
     * 变为一行字符串
     * @param $publicKey
     * @return mixed
     */
    public static function removeFormatPublicText($publicKey) {
        $publicKey = str_replace('-----BEGIN PUBLIC KEY-----', '', $publicKey);
        $publicKey = str_replace("\n", "", $publicKey);
        return str_replace('-----END PUBLIC KEY-----', '', $publicKey);
    }


    /**
     * 移除 私钥中的 换行符号，开头 结束字符
     * 变为一行字符串
     * @param $privateKey
     * @return string
     */
    public static function removeFormatPrivateText($privateKey) {
        $privateKey = str_replace('-----BEGIN PRIVATE KEY-----', '', $privateKey);
        $privateKey = str_replace("\n", "", $privateKey);
        return str_replace('-----END PRIVATE KEY-----', '', $privateKey);
    }

    /**
     *
     * 字符串中不得出现换行和BEGIN
     * 把纯字符串的转化为PEM格式的公钥
     * @param $key
     * @return string
     */
    public static function formatPublicText($key) {
        $newKey = "-----BEGIN PUBLIC KEY-----\n";
        $keyLength = strlen($key);
        $i = 0;
        while ($i < $keyLength) {
            $str64 = substr($key, $i, 64);
            $newKey .= $str64 . "\n";
            $i += 64;
        }
        $newKey .= '-----END PUBLIC KEY-----';
        return $newKey;
    }

    /**
     * 字符串中不得出现换行和BEGIN
     * 把纯字符串的转化为PEM格式的私钥
     * @param $key
     * @return string
     */
    public static function formatPrivateText($key) {
        return "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($key, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
    }

    /**
     * 签名 返回base64格式
     * @param $origin
     * @param string $privateKey 私钥
     * @return string
     */
    public static function sign($origin, $privateKey) {
        openssl_sign($origin, $sign, $privateKey, OPENSSL_ALGO_SHA256);
        return base64_encode($sign);
    }

    /**
     * 验证签名
     * @param string $origin 明文
     * @param $base64Sign
     * @param string $publicKey 公钥
     * @return int
     */
    public static function verifySign($origin, $base64Sign, $publicKey) {
        return openssl_verify($origin, base64_decode($base64Sign), $publicKey, OPENSSL_ALGO_SHA256);
    }


    /**
     * 公钥加密每次部分
     * @param $originalData
     * @param $publicKey
     * @return string base64格式
     */
    public static function encryptChunk($originalData, $publicKey)
    {
        $crypto = '';
        $chunk = '';
        foreach (str_split($originalData, 245) as $chunk) {
            openssl_public_encrypt($chunk, $encryptData, $publicKey);
            $crypto .= $encryptData;
        }
        return base64_encode($crypto);
    }

    /**
     * 私钥分部解密
     * @param $encryptData
     * @param $privateKey
     * @return string
     */
    public static function decryptChunk($encryptData, $privateKey)
    {
        $crypto = '';
        $chunk = '';
        foreach (str_split(base64_decode($encryptData), 256) as $chunk) {
            openssl_private_decrypt($chunk, $decryptData, $privateKey);
            $crypto .= $decryptData;
        }
        return $crypto;
    }
}
