<?php

namespace by\component\api5client\tool;

use by\component\api5client\infra\BaseApi;
use by\component\api5client\infra\RequestPoBuilder;

class EmailApi extends BaseApi
{


    public function sendEmail($toEmail, $title, $content) {
        $bussParams = [
            'email' => $toEmail,
            'title' => $title,
            'content' => $content
        ];
        $po = RequestPoBuilder::getInstance()
            ->bussParams($bussParams)
            ->serviceInfo('Email/send','100')
            ->build();
        return $this->send($po);
    }
}
