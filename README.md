# 仕様技術一覧

![Static Badge](https://img.shields.io/badge/-github-181717.svg?logo=github&style=social)
![Static Badge](https://img.shields.io/badge/-docker-2496ED.svg?logo=docker&style=social)
![Static Badge](https://img.shields.io/badge/-laravel-FF2D20.svg?logo=laravel&style=social)
![Static Badge](https://img.shields.io/badge/-php-777BB4.svg?logo=php&style=social)
![Static Badge](https://img.shields.io/badge/-ubuntu-E95420.svg?logo=ubuntu&style=social)
![Static Badge](https://img.shields.io/badge/-mysql-4479A1.svg?logo=mysql&style=social)
![Static Badge](https://img.shields.io/badge/-nginx-009639.svg?logo=nginx&style=social)
![Static Badge](https://img.shields.io/badge/-redis-FF4438.svg?logo=redis&style=social)

# 開発環境

- Windows10
- wsl
- ubuntu22.04
- github

# ツール・ライブラリの名前

- Docker
- laravel:10
- PHP:8.3
- mysql:8.0
- nginx:stable-alpine
- redis:alpine
- node:18.20.3

## 簡単な説明

- 資産管理アプリケーションです。資産の入力さえしてしまえば、面倒に感じる資産管理も簡単にできます。
- エクセルやスプレッドシートよりも手軽に入力と管理ができます。

## インストール

- ターミナルに下記のコードを入力

```
$ git clone git@github.com:north238/bridgin.git
$ cd bridgin
```

- DB の設定
- .env を作成して下記を記述（yml ファイルで必要なため）

```
DB_NAME=db-laravel
DB_USER=db-user
DB_PASS=db-pass
TZ=Asia/Tokyo
```

```
$ vi .env
```

- 参考: vi コマンドがわからない場合は下記を参考にしてください
- [【Linux 初心者向け】できた！vi コマンドで編集と保存](https://beyondjapan.com/blog/2020/06/vi/)

- Docker 起動の手順

```
REPOSITORY    TAG       IMAGE ID       CREATED              SIZE      SHARED SIZE   UNIQUE SIZE   CONTAINERS
bridgin-web   latest    0620580999d1   52 seconds ago       415MB     0B            415.4MB       1
bridgin-app   latest    1e12b6b85531   About a minute ago   1.24GB    7.799MB       1.232GB       1
mysql         8.0       0b60ddd8609d   41 hours ago         572MB     0B            572MB         1
redis         alpine    38a44d796822   5 weeks ago          40.7MB    7.799MB       32.92MB       1
```

```
$ docker compose up -d --build
$ docker compose exec app bash
$ sh init.sh
$ npm run dev
```

- ホーム画面起動

## その他

- Windows 環境での開発ですので、Mac ユーザーの方は Docker が起動されない可能性があります。ご容赦ください

- dockerですべて削除するときのコマンド(※既存のプロジェクトも削除されます)
```
$ docker compose down
$ docker system prune -a -f --volumes
```

## 作者

mail to: fumiyama02@yahoo.ne.jp
