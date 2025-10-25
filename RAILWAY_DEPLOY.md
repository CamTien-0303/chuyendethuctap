# Hướng dẫn Deploy PHP Flowershop lên Railway 🌸

## Về dự án

**PHP Flowershop** là ứng dụng e-commerce Laravel hoàn chỉnh cho shop hoa với:
- ✅ **Product Management**: Categories, brands, products với images
- ✅ **Order Management**: Quản lý đơn hàng và tracking
- ✅ **User Management**: Admin và customer roles  
- ✅ **Wishlist & Banners**: Tính năng yêu thích và quảng cáo
- ✅ **Customer Management**: Thông tin khách hàng và lịch sử

## Yêu cầu hệ thống

- **PHP**: 8.2+ ✅ (đã config trong Dockerfile)
- **Laravel**: 12.x ✅ 
- **Database**: MySQL ✅ (Railway cung cấp)
- **Frontend**: Vite + TailwindCSS ✅

## Bước 1: Chuẩn bị dự án

### 📁 Files đã được cấu hình sẵn:
- ✅ `Dockerfile` - PHP 8.2 + Apache + MySQL extensions
- ✅ `railway.json` - Railway deployment config
- ✅ `.htaccess` - Apache security headers và rewrite rules
- ✅ `docker-entrypoint.sh` - Auto migration, seeding, optimization
- ✅ `.dockerignore` - Bảo mật build process
- ✅ `.env.production` - Production-ready environment template

### 🔧 Auto-setup features:
- **Database migrations**: Tự động tạo tables từ Laravel migrations
- **Database seeding**: Tự động tạo sample data và default users
- **Laravel optimization**: Auto-clear cache, tạo storage link
- **Security**: Production-ready permissions và headers

### 👥 Default users sẽ được tạo:
```
Admin User:
- Email: admin@example.com  
- Username: admin
- Password: password

Regular User:
- Email: user@example.com
- Username: user  
- Password: password
```

## Bước 2: Deploy trên Railway

1. **Tạo tài khoản Railway**: Truy cập [railway.app](https://railway.app)
2. **Kết nối GitHub repository**:
   - Click "Deploy from GitHub repo"
   - Chọn repository `php-flowershop`
3. **Thêm MySQL Database**:
   - Trong dashboard, click "Add Service"
   - Chọn "Database" → "MySQL"
   - Đợi MySQL service khởi tạo xong (có thể mất vài phút)
   - MySQL sẽ tự động tạo database và cung cấp connection string

4. **Kết nối Database với App**:
   - Click vào MySQL service vừa tạo
   - Vào tab "Connect" hoặc "Variables"
   - Copy các thông tin connection (sẽ có dạng):
     - `MYSQL_HOST` = YOUR_HOST (ví dụ: gondola.proxy.rlwy.net)
     - `MYSQL_DATABASE` = railway
     - `MYSQL_USER` = root
     - `MYSQL_PASSWORD` = YOUR_PASSWORD
     - `MYSQL_PORT` = YOUR_PORT (ví dụ: 39067)

5. **Cấu hình biến môi trường**:
   - Quay lại PHP app service (không phải MySQL service)
   - Vào tab "Variables" của PHP app
   
   **Option 1: Sử dụng PUBLIC URL (khuyến nghị):**
   ```
   DATABASE_URL=mysql://root:YOUR_PASSWORD@YOUR_HOST:YOUR_PORT/railway
   
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=
   APP_URL=
   SEED_DATABASE=true
   ```
   
   **Option 2: Sử dụng riêng biệt (nếu option 1 không work):**
   ```
   DB_CONNECTION=mysql
   DB_HOST=YOUR_HOST
   DB_PORT=YOUR_PORT
   DB_DATABASE=railway
   DB_USERNAME=root
   DB_PASSWORD=YOUR_PASSWORD
   
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=
   APP_URL=
   SEED_DATABASE=true
   ```
   
   **Lưu ý:** Thay `YOUR_PASSWORD`, `YOUR_HOST`, `YOUR_PORT` bằng giá trị thực từ MySQL service của bạn.

6. **Deploy ứng dụng**:
   - Railway sẽ tự động build và deploy khi có biến môi trường
   - **Build process** (tự động):
     - Install PHP dependencies với Composer
     - Build frontend assets với Vite 
     - Setup PHP extensions (GD, PDO MySQL, ZIP)
     - Configure Apache với mod_rewrite
   - **Deployment script** sẽ tự động:
     - ⚙️ Tạo `.env` từ template production
     - 🔑 Generate `APP_KEY` Laravel
     - 📡 Kiểm tra database connection  
     - 🗄️ Chạy `php artisan migrate --force`
     - 🌱 Seed database với sample data (nếu `SEED_DATABASE=true`)
     - ⚡ Clear cache Laravel (`config:clear`, `cache:clear`, `view:clear`)
     - 🔗 Tạo storage link cho file uploads
     - 🔐 Set permissions an toàn cho thư mục
   - Đợi deployment hoàn thành (kiểm tra tab "Deployments")

## Bước 3: Sau khi deploy thành công

1. **Truy cập ứng dụng**:
   - Vào tab "Settings" của PHP app service
   - Copy URL public (dạng: `https://your-app.railway.app`)
   - Mở URL để kiểm tra app

2. **Kiểm tra deployment logs**:
   - Vào tab "Logs" để xem quá trình setup
   - Cần thấy các message thành công:
     ```
     🚀 Starting Laravel deployment...
     📄 Creating .env file for production...
     🔑 Generating APP_KEY...
     📡 Checking database connection...
     ✅ Database is ready!
     🗄️ Running database migrations...
     ✅ Migrations completed successfully
     🌱 Seeding database...
     ✅ Database seeded successfully
     ⚡ Optimizing Laravel...
     🔗 Creating storage link...
     🔐 Setting permissions...
     🎉 Laravel setup completed!
     🌐 Starting Apache server...
     ```

3. **Login và test**:
   - Truy cập `/login` với admin account:
     - **Email**: `admin@example.com`
     - **Password**: `password`
   - Test các tính năng:
     - ✅ Product management
     - ✅ Order processing  
     - ✅ User management
     - ✅ Category/Brand management

4. **Xử lý thủ công** (chỉ khi cần):
   - Nếu cần chạy command bổ sung, vào tab "Console"
   - Available commands:
     ```bash
     php artisan cache:clear
     php artisan config:clear
     php artisan migrate:status
     php artisan queue:work
     ```

## Lưu ý Production

### 🚀 **Auto-deployment:**
- Railway tự động deploy khi có commit mới push lên GitHub
- Có thể config auto-deploy từ specific branch
- Build time: ~2-3 phút cho project này

### 🗂️ **File storage:**
- Hiện tại: Local disk storage (phù hợp với Railway)
- Upload files sẽ lưu trong `/storage/app/public/`
- Đã tự động tạo storage link: `/public/storage` → `/storage/app/public/`

### 📊 **Database:**
- MySQL database với sample data đầy đủ
- Bao gồm: Categories, Brands, Products, Users, Banners
- Auto-backup theo Railway policy

### ⚡ **Performance:**
- Laravel optimization đã enable
- Frontend assets được build production
- Apache với mod_rewrite performance
- Caching: File-based (có thể upgrade Redis sau)

### 🔐 **Security:**
- Production environment (`APP_DEBUG=false`)
- Security headers (CSP, HSTS, XSS protection)
- File permissions 775 (không phải 777)
- Sensitive config via environment variables

## Troubleshooting

**Composer install failed - PHP version mismatch:**
```
Root composer.json requires php ^8.2 but your php version (8.1.33) does not satisfy that requirement.
```
- **Giải pháp**: Dockerfile đã được cập nhật để sử dụng PHP 8.2
- Laravel 12 yêu cầu PHP 8.2+, đã fix trong Dockerfile

**App không chạy được:**
- Kiểm tra logs trong Railway dashboard → tab "Logs"
- Kiểm tra tất cả biến môi trường đã đúng
- Đảm bảo APP_KEY đã được generate

**Database connection error:**
- Thử **Option 1** (DATABASE_URL) trước
- Nếu không work, thử **Option 2** (DB_HOST riêng biệt)
- Kiểm tra public URL từ MySQL service có đúng không
- Đảm bảo port đúng (thường 39067 cho public, 3306 cho internal)

**500 Error:**
- Kiểm tra storage folder có quyền write
- Chạy `php artisan config:clear` và `php artisan cache:clear`
- Kiểm tra logs Laravel tại storage/logs/

**Hình ảnh không hiển thị:**
- Chạy `php artisan storage:link`
- Cấu hình file storage hoặc sử dụng S3 cho production

## Tips & Best Practices

### 🔧 **Development workflow:**
```bash
# Local development (theo START.md)
composer install
npm install  
php artisan key:generate
php artisan migrate --seed
php artisan serve

# Deploy to Railway
git add .
git commit -m "Update feature"
git push origin main  # Auto-deploy
```

### 📈 **Scaling:**
- Railway auto-scaling available
- Có thể enable Redis cho sessions/cache
- Database connection pooling tự động
- CDN cho static assets (Railway cung cấp)

### 🛠️ **Maintenance commands:**
```bash
# Clear all caches
php artisan optimize:clear

# Fresh migration (CAREFUL!)
php artisan migrate:fresh --seed --force

# Check application status  
php artisan about

# Queue work (nếu có jobs)
php artisan queue:work --daemon
```

### 📱 **Mobile & API ready:**
- Responsive design với TailwindCSS
- API endpoints có thể thêm sau
- CORS đã cấu hình basic