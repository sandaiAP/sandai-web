#さくらVPS
info@b-i-factory.com
sandaiFX00

会員ID: fjk69851
電子メール: info@b-i-factory.com

#github
info@sandai-fx.com
user sandaiAP
pass sanidaiFX00

#ドメイン
sanidai-web.com


# 参考

Laravel SanctumとVue.jsによるSPA認証
https://noumenon-th.net/programming/2020/05/26/sanctum/

#error
cross-env: not found
https://qiita.com/Yorinton/items/fd9dae33c6748abcdfbc

Cannot find module 'webpack/lib/RequestShortener'
webpack -v
npm uninstall -g webpack
npm i webpack -g; npm link webpack --save-dev

webpack-cli/bin/cli.js:93 throw err;
Error: Cannot find module 'resolve'

rm -rf node_modules
rm package-lock.json yarn.lock
npm cache clear --force
npm install

# Log

composer create-project laravel/laravel sanctum-project --prefer-dist
chmod -R 777 storage
chmod -R 777 bootstrap/cache

composer require encore/laravel-admin
php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"

.env
database.php
データベースの編集

php artisan admin:install

## データベース作成（migration）

php artisan make:migration create_staffs_table --create=staffs
php artisan make:migration create_customers_table --create=customers
php artisan make:migration create_customer_details_table --create=customer_details

## モデル作成
## コントローラー作成

php artisan make:model Models\\Staff
php artisan admin:make StaffController --model=App\\Models\\Staff

### RLとなる部分
- index（一覧表示）
- show（詳細表示）
- edit（編集）
- create（新規作成）

### メソッド
- grid（一覧表示に使うメソッド）
- detail（詳細表示に使うメソッド）
- * form（編集・作成に使うメソッド）


## ルーティング設定
/app/app/Admin/routes.php


## 日本語化
/app/config/app.php

## リレーションテーブル作成
php artisan make:model Models\\Customer

## Laravel-adminでリレーションのあるテーブルを表示する
php artisan admin:make CustomerController --model=App\\Models\\Customer

## ルーティング設定
$router->resource('customers', CustomerController::class);
