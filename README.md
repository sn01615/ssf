# ssf

Simple swoole framework

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