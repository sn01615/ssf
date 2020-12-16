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

## Database: Query Builder

Model的 mtb 和 tb 属性都是 Illuminate\Database\Eloquent\Builder 实例， 不同的是mtb是使用主库，tb可能查询的从库

查询数据

```PHP
$result = $this->mtb->where('id', $id)->limit(1)->get()->toArray();
```

直接运行SQL(使用db属性的select等方法)

```PHP
$result = $this->db->select("select * from user where id = 1 limit 1");
```

插入数据可以使用`iInsert`方法

```PHP
$newId = $this->iInsert([
    'name' => 123,
]);
```

update数据

```PHP
$affected = $this->mtb->where('id', 1)->update([
    'name' => '哈哈',
]);
```

Model命名说明
`TestModel`会映射到`test`表
`UserModel`会映射到`user`表
`XxCccModel`会映射到`xx_ccc`表，驼峰会转成下划线

## 参考

数据库 laravel database语法参考 https://laravel.com/docs/5.8/database

模板引擎 twig语法参考 https://twig.symfony.com/doc/2.x

## 使用交流

[![](https://pub.idqqimg.com/wpa/images/group.png)](https://qm.qq.com/cgi-bin/qm/qr?k=jhc1rElYTsePKHkLuZdTPG_KH1oR1ZAq&jump_from=webapi)

群号码：21890295

论坛：https://www.qingwx.com/category/7
