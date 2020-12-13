# ssf

Simple swoole framework

## install

`composer create-project sn01615/ssf youname dev-main`

## Run

php index.php

## Nginx config

```
server {
    ...

    location / {
        try_files $uri /sw_proxy_pass;
    }

    location /sw_proxy_pass {
        proxy_http_version 1.1;
        proxy_set_header Connection "keep-alive";
        proxy_set_header X-Real-IP $remote_addr;
        proxy_pass http://127.0.0.1:9501$request_uri;
    }

    ...
}
```

## 使用交流

<a
        target="_blank"
        href="https://qm.qq.com/cgi-bin/qm/qr?k=jhc1rElYTsePKHkLuZdTPG_KH1oR1ZAq&jump_from=webapi"
        style="vertical-align: middle"
      ><img
        border="0"
        src="//pub.idqqimg.com/wpa/images/group.png"
        alt="PHP开发技术交流"
        title="PHP开发技术交流"
      ></a>
        群号码：21890295

论坛：https://www.qingwx.com/category/7
