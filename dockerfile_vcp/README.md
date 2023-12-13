# dockerfile_vcp

資料：[vcp利用方法](https://system.atlassian.net/wiki/spaces/ENLP/pages/3076390998/Docker+GPU)

```sh
# 起動
$ docker-compose up -d
# 起動後、ブラウザで `http://192.168.100.90:8870` を開く
# 削除
$ docker-compose down -v
# プロセスの確認
$ docker ps -a
```