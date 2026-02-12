# Backend Cellphones (Laravel API)

Backend API viết bằng Laravel 11, dùng Repository/Service pattern, paging chuẩn, và Swagger (L5-Swagger) để tài liệu hóa API.

## Có gì trong backend

- Auth JWT: đăng nhập/đăng ký/đăng xuất.
- CRUD + search + paging cho nhiều module (ví dụ: Color, Brand, Category, Product, Tag, Image, ...).
- Response paging thống nhất: `{ items: [...], paginate: { current_page, per_page, total } }`.
- Swagger UI: truy cập để xem/try API.
- Tool generate CRUD: `tools/generate_crud.php` (scaffold Repo/Service/Controller/Requests/Resources + routes cho các model).

## API Docs (Swagger)

- Swagger UI: `http://localhost:8000/api/documentation`

## Cài đặt bằng Docker (Nginx + PHP-FPM + MySQL + phpMyAdmin + Redis)

### Yêu cầu

- Docker Desktop (có `docker compose`)

### Chạy lần đầu

```bash
cd e:\laragon\www\backend-cellphones
docker compose up -d --build
```

Khi container `app` khởi động, hệ thống sẽ tự chạy các tác vụ Laravel (qua `docker/php/entrypoint.sh`):

- tạo `.env` từ `.env.example` nếu chưa có
- `composer install` nếu chưa có `vendor/`
- generate `APP_KEY` nếu chưa có
- chờ DB sẵn sàng rồi chạy `php artisan migrate --force`
- tạo symlink storage (`php artisan storage:link`)
- local: `php artisan optimize:clear`

### Chạy kiểu “production-like” (không bind-mount source)

Chế độ này build source + vendor vào image, bật cache config/routes/views (best-effort), và có thêm queue worker + scheduler.

```bash
cd e:\laragon\www\backend-cellphones
docker compose -f docker-compose.prod.yml up -d --build
```

phpMyAdmin trong prod compose là optional (profile `tools`):

```bash
docker compose -f docker-compose.prod.yml --profile tools up -d
```

Với `APP_ENV=production`, container `app` sẽ tự chạy `php artisan optimize` sau khi migrate.

Nếu cần chạy lại migrate/seed thủ công:

```bash
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed --force
```

### URLs / Ports

- API (Nginx): `http://localhost:8000`
- phpMyAdmin: `http://localhost:8081`
- MySQL host: `127.0.0.1:3307` (container 3306)
- Redis host: `127.0.0.1:6380` (container 6379)

### Thông tin DB mặc định (trong docker-compose)

- DB: `backend_cellphones`
- User/Pass: `backend` / `backend`
- Root pass: `root`

## Tài khoản mặc định khi seed

Sau khi chạy lệnh seed (migrate:fresh --seed), hệ thống sẽ tự tạo sẵn:

- **Admin:**
    - Email: `admin@gmail.com`
    - Mật khẩu: `admin123`
- **User:**
    - Email: `user@gmail.com`
    - Mật khẩu: `user123`

## Một vài lệnh hữu ích

## Sử dụng các lệnh Laravel với Docker

### 1. Chạy lệnh Laravel (artisan)

Chạy mọi lệnh artisan qua container `app`:

```bash
docker compose exec app php artisan <lệnh>
```

Ví dụ:

- Xem route: `docker compose exec app php artisan route:list`
- Tạo key: `docker compose exec app php artisan key:generate`
- Migrate DB: `docker compose exec app php artisan migrate`
- Seed DB: `docker compose exec app php artisan db:seed`
- Xóa cache: `docker compose exec app php artisan optimize:clear`

### 2. Chạy composer

- Cài package mới:
  docker compose exec app composer require <package>
- Update composer:
  docker compose exec app composer update

### 3. Chạy queue/scheduler

Queue và scheduler đã tự động chạy khi `docker compose up`, xem log bằng:

```bash
docker compose logs -f queue
docker compose logs -f scheduler
```

### 4. Truy cập shell bên trong container

Vào shell (Alpine dùng sh):

```bash
docker compose exec app sh
```

### 5. Một số lệnh hữu ích khác

- Xem log app:
  docker compose logs -f app
- Dừng toàn bộ stack:
  docker compose down
- Dừng và xóa luôn volume (reset DB, Redis):
  docker compose down -v

---

### Lưu ý tối ưu Docker

- Từ phiên bản này, chỉ còn 1 image PHP duy nhất (~149MB) dùng chung cho app/queue/scheduler.
- Base image là Alpine, entrypoint đã chuyển sang dùng `sh`.

## Ghi chú

- `.env.example` đang để `DB_CONNECTION=sqlite`. Khi chạy Docker, app sẽ dùng biến môi trường từ container (`DB_HOST=mysql`...). Nếu bạn muốn chạy ngoài Docker thì hãy chỉnh `.env` sang MySQL hoặc SQLite tùy nhu cầu.
