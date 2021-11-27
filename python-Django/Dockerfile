# 元となるdockerイメージを指定
FROM python:3
# この環境変数に値を入れることでバッファを無効化する('1'じゃなくてもいい)
ENV PYTHONUNBUFFERED 1
# codeディレクトリを作成
RUN mkdir /code
# codeディレクトリに移動
WORKDIR /code
# txtファイルをcodeディレクトリに配置
COPY requirements.txt /code/
# pipコマンドを最新にし、txtファイル内のパッケージをpipインストール
RUN pip install --upgrade pip \
    && pip install -r requirements.txt
# パッケージインストーラ
# requirements.system に対象パッケージ記入
RUN apt-get update \
 && xargs apt-get install -y --no-install-recommends \
    < requirements.system \
 && apt-get -y clean \
 && rm -rf /var/lib/apt/lists/*
RUN pip install --upgrade pip \
    && pip install -r requirements.txt
# sample-pj/配下のファイルをcodeディレクトリにコピー
COPY . /code/