# 自然言語処理 MeCab用

## 利用方法

```sh
$ docker-compose up -d
```

- 初回利用時はtokenを聞かれるため、コンテナから取得する。

例:

```sh
$ docker exec -it mecab-notebook /bin/bash
(base) root@406a7c03649f:~# jupyter server list
Currently running servers:
http://406a7c03649f:8888/?token=dbb03ba3c6f97135fe28c52a008fa358efa866f266f9002a :: /home/jovyan
```

## Neologd 動作確認

```sh
$ docker exec -it mecab-notebook /bin/bash                                                                                              207.509s  (main|💩?) 21:55
py(base) root@406a7c03649f:~# python
Python 3.11.6 | packaged by conda-forge | (main, Oct  3 2023, 10:40:35) [GCC 12.3.0] on linux
Type "help", "copyright", "credits" or "license" for more information.
>>> import MeCab
>>>
>>> MECAB_SETTING = "/etc/mecabrc"
>>> MECAB_DICTIONARY = "/usr/lib/x86_64-linux-gnu/mecab/dic/mecab-ipadic-neologd"
>>> MECAB_ARGS = " -r " + MECAB_SETTING + " -d " + MECAB_DICTIONARY
>>>
>>> m = MeCab.Tagger(MECAB_ARGS)
>>>
>>> text = "ONE TEAMは１日にして成らず"
>>> print(m.parse(text))
ONE TEAM	名詞,固有名詞,一般,*,*,*,ONE TEAM,ワンチーム,ワンチーム
は	助詞,係助詞,*,*,*,*,は,ハ,ワ
１	名詞,数,*,*,*,*,１,イチ,イチ
日	名詞,接尾,助数詞,*,*,*,日,ニチ,ニチ
に	助詞,格助詞,一般,*,*,*,に,ニ,ニ
し	動詞,自立,*,*,サ変・スル,連用形,する,シ,シ
て	助詞,接続助詞,*,*,*,*,て,テ,テ
成ら	動詞,自立,*,*,五段・ラ行,未然形,成る,ナラ,ナラ
ず	助動詞,*,*,*,特殊・ヌ,連用ニ接続,ぬ,ズ,ズ
EOS
```
