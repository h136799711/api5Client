<?php

namespace by\component\api5client\tool;

use by\component\api5client\infra\BaseApi;

class ToolApi extends BaseApi
{

    public function sendEmail($toEmail, $title, $content) {
        $bussParams = [
            'email' => $toEmail,
            'title' => $title,
            'content' => $content
        ];
        return $this->newRequest()
            ->bussParams($bussParams)
            ->call('Email/send', '100');
    }
}
