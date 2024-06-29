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

## 簡単な説明

- 資産管理アプリケーションです。資産の入力さえしてしまえば、面倒に感じる資産管理も簡単にできます。
- エクセルやスプレッドシートよりも手軽に入力と管理ができます。

## インストール

- ターミナルに下記のコードを入力

```
$ git clone https://github.com/north238/laravel_docker_my-assets.git
$ cd laravel_docker_my-assets
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
$ docker compose up -d --build
$ docker compose exec app bash
$ cd my-assets
$ sh init.sh
$ npm run dev
```

- ホーム画面起動

## その他

- Windows 環境での開発ですので、Mac ユーザーの方は Docker が起動されない可能性があります。ご容赦ください

## 作者

mail to: fumiyama02@yahoo.ne.jp
