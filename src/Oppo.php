<?php

namespace Webguosai\Ocpc;

class Oppo
{
    protected $url = 'https://sapi.ads.oppomobile.com/v1/clue/sendData';
    protected $apiId;
    protected $apiKey;
    protected $ownerId;
    public function __construct($apiId, $apiKey, $ownerId)
    {
        $this->apiId = $apiId;
        $this->apiKey = $apiKey;
        $this->ownerId = $ownerId;
    }

    /**
     * 监听回传检测
     * @return bool
     */
    public function listenCheck()
    {
        if ($this->isCheck()) {
            $params = $this->getParams();
            if ($params) {
                try {
                    return $this->send($params['pageId'], $params['tid'], $params['lbid']);
                } catch (\Exception $e) {
                    return false;
                }
            }
        }
    }

    /**
     * 获取回调参数
     *
     * @return array
     */
    public function getParams()
    {
        // 从request参数中获取
        $request = $_REQUEST;

        // 从来源参数中获取
        $referer = $this->parseUrlArr($_SERVER['HTTP_REFERER']);

        // 合并
        $params = array_merge($referer, $request);

        // 过滤
        if ($params['pageId'] && $params['tid'] && $params['lbid']) {
            return [
                'pageId' => $params['pageId'],
                'tid'    => $params['tid'],
                'lbid'   => $params['lbid'],
            ];
        }

        return [];
    }

    /**
     * 发送回传
     *
     * @param string|int $pageId
     * @param string $tid
     * @param string $lbid
     * @param string $ip ip地址
     * @param int $transformType 回传类型
     * @return bool
     * @throws \Exception
     */
    public function send($pageId, $tid, $lbid, $ip = '127.0.0.1', $transformType = 101)
    {
        $http = new \Webguosai\HttpClient();
        $headers = [
            'Authorization' => 'Bearer '.$this->getToken()
        ];
        $data = json_encode([
            'pageId' => $pageId,
            'ownerId' => $this->ownerId,
            'ip' => $ip ?: '127.0.0.1',
            'tid' => urlencode($tid),
            'lbid' => $lbid,
            'transformType' => $transformType,//101=表单提交，105=支付
        ]);

        $response = $http->post($this->url, $data, $headers);

//        dump($response->httpStatus);
//        dump($response->body);
//        dump($response->request);
//        dump($data);

        if ($response->ok()){
            $json = $response->json();
            if ($json['code'] === 0) {
                return true;
            }

            throw new \Exception("{$json['msg']}[{$json['ret']}]");
        }

        throw new \Exception($response->getErrorMsg());
    }

    /**
     * 是否为回传检测
     *
     * @return bool
     */
    protected function isCheck()
    {
        if (!empty($_GET['testFlag']) && $_GET['testFlag'] == 1) {
            return true;
        }
        return false;
    }

    /**
     * 获取token
     *
     * @return string
     */
    protected function getToken()
    {
        $timeStamp = time();
        $sign = sha1($this->apiId.$this->apiKey.$timeStamp);
        return base64_encode("{$this->ownerId},{$this->apiId},{$timeStamp},{$sign}");
    }

    /**
     * 解析url中的参数
     *
     * @param string $url
     * @return array
     */
    protected function parseUrlArr($url)
    {
        $params = [];

        if (preg_match('#\?(.+)#i', $url,$mat)) {
            $query = $mat[1];
            parse_str($query, $urlArr);
            return $urlArr;
        }

        return $params;
    }


}