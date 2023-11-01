# Training PHP Takakura

PHP課題用のリポジトリです（takakuraさん用）

<br>

## ディレクトリ構成
```
training-php-takakura/
    ┣ README.md             → 本ファイル
    ┣ docker/               → dockerコンテナの設定
    ┣ docker-comose.yml     → dockerコンテナ起動用
    ┣ .gitignore            → git対象外設定用
    ┣ log                   → dockerコンテナのログ
    ┗ public/               → ソースコード（ここを volume している）
        ┣ xxx/              → 課題xxx用
        ┣ yyy/              → 課題yyy用
        ┣ ・・・
        ┣ index.php         → トップ画面
        ┗ phpinfo.php       → phpinfo
```

<br>

## ローカル環境の起動方法
1. プロジェクトのルートディレクトリに移動
    ```
    [ホストマシン]$ cd ・・・/training-php-takakura/
    ```

1. Dockerコンテナを起動する
    ```
    [ホストマシン]$ docker-compose up -d
    ```

1. ブラウザで localhost へ 80ポートでアクセスしてトップページが表示されればOK  
    http://localhost

<br>

## ローカル環境の終了方法
1. Dockerコンテナを終了するだけ
    ```
    [ホストマシン]$ docker-compose down
    ```

<br>

## その他コマンド
* Dockerコンテナ(php)の中に入る
    ```
    [ホストマシン]$ docker-compose exec php bash
    [コンテナ内]:/public # (入った)
    ```

* Dockerコンテナ(php)を抜ける
    ```
    [コンテナ内]:/public # exit
    [ホストマシン]$ (抜けた)
    ```
