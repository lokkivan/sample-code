# Website-manager

### Requirements

1. PHP >= 7.1;
2. Mysql >= 8.0. 

### Installation
1. Install dependencies
    ```bash
    composer install 
    ```
2. Create database and fill env file
3. Run migrations
    ```bash
    php artisan migrate
    ```
4. Generate application key:
    ```bash
    php artisan key:generate
    ```
5. Create user
    ```bash
    php artisan user:create
    ``` 
6. Change user role
    ```bash
    php artisan user:change-role
    ``` 
