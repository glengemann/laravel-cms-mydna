# Documentation

```bash
php -S 127.0.0.1:14001 -t docs/
```

# Requirements

1. Authentication and Authorization
   - Use policies and gates ✅

2. Content Management System
   - CUD: posts, categories, and labels
   - WYSIWYG editor for posts
   - Upload images for posts

3. Comments and moderation ✅

4. API Restful 
   - CRUD: posts, categories, and comments ✅
   - Authentication via token

5. Search and filter posts and categories ✅

6. i18n

## Non-functional requirements

1. Performance
2. Security
3. PHPUnit ✅
4. Documentation ✅
5. Docker ✅

## Installation

- Clone the repository

```bash
git clone
```

- Move to the project directory
    
```bash
cd laravel-cms-mydna
```
 
- Install project dependencies using the following command:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

- Configure the environment file
  
```bash
cp .env.example .env
```

- Start containers

```bash
./vendor/bin/sail up
```

- Generate application key

```bash
./vendor/bin/sail artisan key:generate
```

- Migrate database tables

```bash
./vendor/bin/sail artisan migrate --seed
```

