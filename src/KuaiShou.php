<?php

namespace Webguosai\Ocpc;

class KuaiShou
{
    public function __construct()
    {

    }

    /**
     * 获取基础代码调用
     *
     * @return string
     */
    public function getJsBase()
    {
        return <<<EOF
<script type="text/javascript">
(function (root) {
    var ksscript = document.createElement('script');
    ksscript.setAttribute('charset', 'utf-8');
    ksscript.src = '//p1-yx.adkwai.com/udata/pkg/ks-ad-trace-sdk/ks-trace.3.2.0.min.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ksscript, s);
})(window);
</script>
EOF;
    }

    /**
     * 转化代码
     *
     * @return string
     */
    public function getJsConversion(){
        return <<<EOF
_ks_trace.push({event: 'form', convertId: 454947, cb: function(){
    console.log('Your callback function here!')
}})
EOF;

    }
}