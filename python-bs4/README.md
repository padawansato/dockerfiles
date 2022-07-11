- arm 環境では実行できなかった。

# 概要

- スクレイピングをするにあたって、問題となるのは、スクレイピング対策です。
- 負荷をかけ過ぎれば営業の妨げとなりますが、適切に wait を設ければ、特に問題とはなりません。
- スクレイピング対策としては、user-agentをブラウザに限定、IPを制限、reCaptcha、等があります。


# Torとは
- Torは SOCKS5 プロキシ経由で Web にアクセスすることで接続元IPアドレスを秘匿化できます。
- Torのデフォルト設定では`127.0.0.1:9050`でSOCKS5プロキシとの接続をリッスンし、Torネットワーク上でトラフィックをリレーしていきます。
- 設定ファイルはコンテナ内の`/etc/tor/torsocks.conf`を参照してください。

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


# 参考

1. [How to Stay Anonymous on the Internet using TOR Network?](https://www.hacker9.com/can-hide-online-using-tor-network.html)
1. [Torで接続元を匿名化してスクレイピングしてみる](https://yolo-kiyoshi.com/2022/02/19/post-2862/)



