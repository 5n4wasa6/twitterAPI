# twitterAPI

## Usage

### コンテナの立ち上げ

```bash
git clone git@github.com:ulm-git/twitterAPI.git
cd new_buzzes/docker
docker-compose build
docker-compose up -d
```

### 初めてLaravelをインストールする場合

```bash
docker-compose exec php-apache composer create-project --prefer-dist laravel/laravel . "6.0.*"
``````

### 既にLaravelはインストール済みで必要なモジュールだけをインストールしたい場合

```bash
docker-compose exec php-apache composer install
cd ../src
cp .env.example .env
cd ../docker
docker-compose exec php-apache php artisan key:generate
```

### URL

http://localhost:8080/
