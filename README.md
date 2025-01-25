# Test task for BEKEY

**Prerequisites:**

*   Docker installed and running on your system

**Steps:**

1.  **Clone repo:**

    ```bash
    git clone https://github.com/MKovblyuk/test_task_for_bekey.git
2.  **In root directory create `.env` (copy `.env.example`)**
4.  **In src directory create `.env`**
     - Write credentials for database the same as in `.env` in root directory
5.  **Run:**
    ```bash
    docker compose build
    docker compose up -d
6.  **Move into container:**
    ```bash
    docker compose exec app_service sh
7.  **Inside container run:**
    ```bash
    composer install
    php artisan migrate
    php artisan db:seed
    php artisan key:generate
    php artisan serve --host 0.0.0.0
8. **Grant access permission to directories:**
    - src/bootstrap/cache
    - src/storage
      
   https://laravel.com/docs/11.x/deployment#directory-permissions

## Credentials for authenticated user:
  
**Email:** `test1@gmail.com`

**Password:** `123456`
