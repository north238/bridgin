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
- wsl2
- ubuntu22.04
- github
- Docker

# ツール・ライブラリの名前

- laravel:10
- PHP:8.3
- mysql:8.0
- nginx:stable-alpine
- redis:alpine
- node:20.15.0

## 簡単な説明

- 資産管理アプリケーションです。資産の入力さえしてしまえば、面倒に感じる資産管理も簡単にできます。
- エクセルやスプレッドシートよりも手軽に入力と管理ができます。

## インストール

- ターミナルで下記のコードを入力

```
$ git clone https://github.com/north238/bridgin.git
$ cd bridgin
$ cp .env.example .env
```
- cpコマンドが権限で使えない場合
```
$ sudo cp .env.example .env
```

## Docker 起動の手順

- 下記のコマンドを実行してください

```
$ docker compose up -d --build
```

- コンテナ完成形確認

```
$ docker compose ps
```
- 下記の表示があればOK

```
REPOSITORY    TAG       IMAGE ID       CREATED              SIZE      SHARED SIZE   UNIQUE SIZE   CONTAINERS
bridgin-web   latest    0620580999d1   52 seconds ago       415MB     0B            415.4MB       1
bridgin-app   latest    1e12b6b85531   About a minute ago   1.24GB    7.799MB       1.232GB       1
mysql         8.0       0b60ddd8609d   41 hours ago         572MB     0B            572MB         1
redis         alpine    38a44d796822   5 weeks ago          40.7MB    7.799MB       32.92MB       1
```

## アプリケーション立ち上げ

- コンテナ内での操作
```
$ docker compose exec app bash
$ sh init.sh
$ npm run dev
```

## 画面表示

- 下記のURLへアクセス
```
http://localhost:9000
```
- 画面が表示されれば成功

## その他

- Windows 環境での開発ですので、Mac ユーザーの方は Docker が起動されない可能性があります。ご容赦ください。
- docker環境構築で詰まったとき（削除系コマンド）
```
$ docker container prune
$ docker image prune
$ docker network prune
$ docker volume prune
$ docker system prune --volumes
```

- プロジェクトをすべて削除するとき(※プロジェクトのコンテナ、イメージ、ボリューム、ネットワークが削除されます)
```
$ docker compose down --rmi all --volumes --remove-orphans
```

## 作者

mail to: fumiyama02@yahoo.ne.jp
