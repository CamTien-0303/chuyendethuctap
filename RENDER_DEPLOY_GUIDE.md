# Hướng dẫn Deploy Laravel App lên Render với MySQL từ Railway

## Tổng quan
Ứng dụng Laravel của bạn cần chạy 2 lệnh:
- `php artisan serve` - Backend Laravel
- `npm run dev` - Frontend Vite (để build assets)

Trên Render, chúng ta sẽ build assets trong quá trình deploy và chỉ chạy Laravel server.

## Bước 1: Chuẩn bị Database MySQL trên Railway

### 1.1 Thông tin kết nối từ Railway
Đã có sẵn thông tin database:
- **Host**: `switchback.proxy.rlwy.net`
- **Port**: `54387`
- **Database**: `railway`
- **Username**: `root`
- **Password**: `mXIKnFWVTfFwKDETthuwftSnoNhEXxlO`

### 1.2 Cập nhật database connection
Trong Railway dashboard, đảm bảo:
- Database đã được tạo
- User có quyền truy cập database
- Connection string hoạt động

## Bước 2: Deploy lên Render

### 2.1 Tạo service mới trên Render
1. Đăng nhập vào [Render.com](https://render.com)
2. Click "New +" → "Web Service"
3. Connect GitHub repository của bạn

### 2.2 Cấu hình service
- **Name**: `laravel-vite-app` (hoặc tên bạn muốn)
- **Environment**: `PHP`
- **Build Command**: (sẽ được tự động lấy từ render.yml)
- **Start Command**: (sẽ được tự động lấy từ render.yml)

### 2.3 Cấu hình Environment Variables
Trong phần Environment Variables, thêm các biến sau:

#### Biến bắt buộc từ Railway (đã được cấu hình sẵn trong render.yml):
```
DB_HOST=switchback.proxy.rlwy.net
DB_PORT=54387
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=mXIKnFWVTfFwKDETthuwftSnoNhEXxlO
```

#### Biến môi trường Laravel:
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com
APP_KEY=base64:your_generated_key
DB_CONNECTION=mysql
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### 2.4 Tự động tạo APP_KEY
Render sẽ tự động tạo `APP_KEY` cho bạn trong quá trình build.

## Bước 3: Deploy Process

### 3.1 Quá trình build tự động
Render sẽ tự động:
1. Cài đặt PHP dependencies: `composer install --no-dev --optimize-autoloader`
2. Cài đặt Node.js dependencies: `npm install`
3. Build assets: `npm run build`
4. Tạo application key: `php artisan key:generate --force`
5. Chạy migrations: `php artisan migrate --force`
6. Chạy seeders: `php artisan db:seed --force` (tạo dữ liệu mẫu)

### 3.2 Start command
Service sẽ chạy với: `php artisan serve --host=0.0.0.0 --port=$PORT`

## Bước 4: Kiểm tra sau khi deploy

### 4.1 Kiểm tra logs
1. Vào dashboard Render
2. Click vào service của bạn
3. Vào tab "Logs" để xem quá trình build và runtime logs

### 4.2 Kiểm tra database connection
- Kiểm tra logs xem có lỗi database connection không
- Đảm bảo migrations đã chạy thành công

### 4.3 Test ứng dụng
- Truy cập URL được cung cấp bởi Render
- Kiểm tra các chức năng chính của ứng dụng

## Troubleshooting

### Lỗi thường gặp:

#### 1. Database connection failed
```
SQLSTATE[HY000] [2002] Connection refused
```
**Giải pháp**: Kiểm tra lại thông tin DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD

#### 2. APP_KEY not found
```
No application encryption key has been specified
```
**Giải pháp**: Render sẽ tự động tạo key, nếu vẫn lỗi thì thêm biến `APP_KEY=base64:...` manually

#### 3. Assets không load được
```
Failed to load resource: the server responded with a status of 404
```
**Giải pháp**: Kiểm tra xem `npm run build` đã chạy thành công chưa, kiểm tra file `public/build/manifest.json`

#### 4. Permission denied
```
The stream or file could not be opened
```
**Giải pháp**: Render sẽ tự động set permissions, nếu vẫn lỗi thì kiểm tra storage directories

### Debug tips:
1. Enable `APP_DEBUG=true` tạm thời để xem chi tiết lỗi
2. Kiểm tra logs trong Render dashboard
3. Test database connection bằng cách tạo một route đơn giản

## Cập nhật code

### Auto-deploy
- Render sẽ tự động deploy khi bạn push code lên GitHub
- Mỗi lần deploy, assets sẽ được build lại

### Manual deploy
- Vào dashboard Render
- Click "Manual Deploy" → "Deploy latest commit"

## Performance Optimization

### 1. Enable caching
Đã được cấu hình trong Dockerfile:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Optimize autoloader
```bash
composer install --optimize-autoloader --no-dev
```

### 3. CDN cho assets
Có thể sử dụng CDN cho static assets bằng cách cấu hình `ASSET_URL` trong environment variables.

## Monitoring

### 1. Health checks
Render tự động monitor service health

### 2. Logs
- Build logs: Xem quá trình build
- Runtime logs: Xem lỗi runtime
- Access logs: Xem requests

### 3. Metrics
- CPU usage
- Memory usage
- Response time

## Cost Optimization

### Free tier limits:
- 750 hours/month
- Sleep sau 15 phút không có traffic
- Cold start có thể mất 30-60 giây

### Paid plans:
- Always-on service
- Faster cold starts
- Better performance
- Custom domains
