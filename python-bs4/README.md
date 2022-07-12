# 概要

- スクレイピングをするにあたって、問題となるのは、スクレイピング対策です。
- 負荷をかけ過ぎれば営業の妨げとなりますが、適切に wait を設ければ、特に問題とはなりません。
- スクレイピング対策としては、user-agentをブラウザに限定、IPを制限、reCaptcha、等があります。


# Torとは
- Torは SOCKS5 プロキシ経由で Web にアクセスすることで接続元IPアドレスを秘匿化できます。
- Torのデフォルト設定では`127.0.0.1:9050`でSOCKS5プロキシとの接続をリッスンし、Torネットワーク上でトラフィックをリレーしていきます。
- 設定ファイルはコンテナ内の`/etc/tor/torsocks.conf`を参照してください。

# 実行環境

```
❯ sw_vers
ProductName:	macOS
ProductVersion:	11.5.2
BuildVersion:	20G95
```

- arm64 環境では実行未確認

# 実験1

以下の方法で、IP を変更します。

1. Torを再起動する
2. アクセス元のグローバルIPアドレスを取得する

## 実行方法

```zsh
$ docker-compose run --rm app python -m main
$ cat /log/scraping.lo
```

コンテナの再起動ポリシーを上書きしつつ、実行後にコンテナを削除したい場合は、`--rm`フラグを使用します。

これは、スクレイピングスクリプトを実行し、サービス構成に再起動ポリシーが指定されていても、実行終了後にコンテナを削除する、という意味になっています。

# 実験2

実験1の内容を並列に実行させ、時間を計測します。


## 実行方法
`&` を末尾につけると、バックグラウンドで、コマンドを実行できます。
これを複数個実行させて、IPが並列に変わっているか、出力させます。


```
$ bash ./run.sh
```

```
docker-compose run --rm app python -m main --seq=0 &
docker-compose run --rm app python -m main --seq=1 &
docker-compose run --rm app python -m main --seq=2 &
docker-compose run --rm app python -m main --seq=3 &
docker-compose run --rm app python -m main --seq=4
```

# 実験結果

- 表示が乱れているのもそのままです。
- 実行内容は 5倍になっているのに対して、時間が 1.2倍程度になっているため、並列に処理できていると考えられます。

```zsh
~/ghq/github.com/psato/dockerfiles/python-bs4 main !1 ?1 ·············································· 44s  11:09:06
❯ time ./run.sh | grep "Current IP address is"
+ docker-compose run --rm app python -m main --seq=0
+ docker-compose run --rm app python -m main --seq=1
+ docker-compose run --rm app python -m main --seq=2
+ docker-compose run --rm app python -m main --seq=4
+ docker-compose run --rm app python -m main --seq=3
Creating python-bs4_app_run ...
Creating python-bs4_app_run ...
Creating python-bs4_app_run ...
Creating python-bs4_app_run ...
Creating python-bs4_app_run ... done
tor: no process found
                     tor: no process found
                                          tor: no process found
                                                               tor: no process found
                                                                                    [4]Current IP address is 185.220.102.246
[4]Current IP address is 185.107.47.215
ERROR: 1
[0]Current IP address is 185.183.157.127
[0]Current IP address is 31.24.148.37
[0]Current IP address is 95.214.54.60
[0]Current IP address is 185.220.101.15
[0]Current IP address is 185.14.97.176
[3]Current IP address is 104.244.74.211
[3]Current IP address is 83.137.158.8
[3]Current IP address is 45.134.225.36
[3]Current IP address is 5.45.102.155
[3]Current IP address is 51.178.86.137
[1]Current IP address is 217.79.178.53
[1]Current IP address is 185.220.102.242
[1]Current IP address is 23.154.177.5
[1]Current IP address is 162.247.74.201
[1]Current IP address is 185.220.101.22
[2]Current IP address is 195.176.3.23
[2]Current IP address is 185.220.103.118
[2]Current IP address is 193.142.146.213
[2]Current IP address is 128.199.26.78
[2]Current IP address is 185.220.100.252

________________________________________________________
Executed in   61.49 secs      fish           external
   usr time  595.18 millis    0.26 millis  594.92 millis
   sys time  233.55 millis    1.07 millis  232.49 millis


~/ghq/github.com/psato/dockerfiles/python-bs4 main !1 ?1 ······································ ✔ 1|0 1m 1s  11:10:37
❯ time docker-compose run --rm app python -m main | grep "Current IP address is"
Creating python-bs4_app_run ... done
[0]Current IP address is 185.14.97.176
[0]Current IP address is 185.220.100.247
[0]Current IP address is 217.163.30.10
[0]Current IP address is 185.220.103.119
[0]Current IP address is 94.102.56.11

________________________________________________________
Executed in   38.41 secs      fish           external
   usr time  418.95 millis    0.28 millis  418.68 millis
   sys time  142.06 millis    1.13 millis  140.92 millis

```




# 参考

1. [How to Stay Anonymous on the Internet using TOR Network?](https://www.hacker9.com/can-hide-online-using-tor-network.html)
1. [Torで接続元を匿名化してスクレイピングしてみる](https://yolo-kiyoshi.com/2022/02/19/post-2862/)



