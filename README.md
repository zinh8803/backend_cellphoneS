# Backend Cellphones (Laravel API)

Backend API viết bằng Laravel 11, dùng Repository/Service pattern, paging chuẩn, và Swagger (L5-Swagger) để tài liệu hóa API.

## Có gì trong backend

- Auth JWT: đăng nhập/đăng ký/đăng xuất.
- CRUD + search + paging cho nhiều module (ví dụ: Color, Brand, Category, Product, Tag, Image, ...).
- Response paging thống nhất: `{ items: [...], paginate: { current_page, per_page, total } }`.
- Swagger UI: truy cập để xem/try API.
- Tool generate CRUD: `tools/generate_crud.php` (scaffold Repo/Service/Controller/Requests/Resources + routes cho các model).

## API Docs (Swagger)

- Swagger UI: `http://localhost:8080/api/documentation`

## Cài đặt bằng Docker (Nginx + PHP-FPM + MySQL + phpMyAdmin + Redis)

### Yêu cầu

- Docker Desktop (có `docker compose`)

### Chạy lần đầu

```bash
cd e:\laragon\www\backend-cellphones
docker compose up -d --build
docker compose exec app php artisan migrate
```

### Chạy kiểu “production-like” (không bind-mount source)

Chế độ này build source + vendor vào image, bật cache config/routes/views (best-effort), và có thêm queue worker + scheduler.

```bash
cd e:\laragon\www\backend-cellphones
docker compose -f docker-compose.prod.yml up -d --build
docker compose -f docker-compose.prod.yml exec app php artisan migrate
```

phpMyAdmin trong prod compose là optional (profile `tools`):

```bash
docker compose -f docker-compose.prod.yml --profile tools up -d
```

Mặc định container `app` sẽ:

- tạo `.env` từ `.env.example` nếu chưa có
- `composer install` nếu chưa có `vendor/`
- generate `APP_KEY` nếu chưa có

### URLs / Ports

- API (Nginx): `http://localhost:8080`
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

```bash
docker compose exec app php artisan route:list
docker compose exec app php artisan l5-swagger:generate
docker compose exec app php artisan migrate:fresh --seed
```

Queue/Scheduler logs:

```bash
docker compose logs -f queue
docker compose logs -f scheduler
```

## Ghi chú

- `.env.example` đang để `DB_CONNECTION=sqlite`. Khi chạy Docker, app sẽ dùng biến môi trường từ container (`DB_HOST=mysql`...). Nếu bạn muốn chạy ngoài Docker thì hãy chỉnh `.env` sang MySQL hoặc SQLite tùy nhu cầu.
