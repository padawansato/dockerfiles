# Terraform 学習用

## 環境構築

```sh
$ cp .env.dist .env
$ docker-compose up -d
$ docker-compose run terraform init
$ docker-compose run terraform plan
$ docker-compose run terraform apply
$ docker-compose run terraform destroy
$ docker-compose run terraform import
```

### バージョン

動作確認時バージョン：

```sh
$ tfenv list                                                                                                                                0.142s 16:03
  1.6.3
No default set. Set with 'tfenv use <version>'
$ docker -v                                                                                                                                 0.435s 16:04
Docker version 20.10.22, build 3a2c30b
$ docker-compose -v                                                                                                                         0.236s 16:13
Docker Compose version v2.15.1
```

## 参考文献

1. https://github.com/tfutils/tfenv
1. https://undersooon.hatenablog.com/entry/2023/02/24/120500
