# PHP Flowershop 🌸

A Laravel-based e-commerce application for a flower shop with complete product management, order processing, and customer management features.

## Features

- **Product Management**: Categories, brands, and products with images
- **Order Management**: Customer orders with order items tracking
- **User Management**: Admin and customer user roles
- **Wishlist**: Users can save favorite products
- **Banners**: Promotional banner management
- **Customer Management**: Customer information and order history

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & npm
- MySQL database (or SQLite for development)
- Git

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/nhandev04/php-flowershop.git
cd php-flowershop
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the environment example file and configure it:

```bash
copy .env.example .env
```

Edit the `.env` file and configure your database settings:

```env
# For MySQL (recommended for production)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flowershop
DB_USERNAME=root
DB_PASSWORD=your_password

# For SQLite (good for development - already configured)
# DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite
```

### 5. Generate Application Key

```bash
php artisan key:generate
```
Or manually set the `APP_KEY` in your `.env` file.

```env
APP_KEY=base64:your_generated_key_here
```

### 6. Database Setup

#### Option A: Using MySQL
1. Create a MySQL database named `flowershop`
2. Update your `.env` file with MySQL credentials
3. Run migrations and seeders:

```bash
php artisan migrate --seed
```

#### Option B: Using SQLite (Development)
The project is already configured for SQLite. Just run:

```bash
php artisan migrate --seed
```

### 7. Create Storage Link

```bash
php artisan storage:link
```

### 8. Build Frontend Assets

For development:
```bash
npm run dev
```

For production:
```bash
npm run build
```

## Running the Application

### Development Mode

You can start the development server with all services using the custom composer script:

```bash
composer run dev
```

This will start:
- Laravel development server (`php artisan serve`)
- Queue worker (`php artisan queue:listen`)
- Log viewer (`php artisan pail`)
- Vite development server (`npm run dev`)

### Manual Start

Alternatively, you can start services manually:

#### Start Laravel Server
```bash
php artisan serve
```

#### Start Vite Development Server (in another terminal)
```bash
npm run dev
```

The application will be available at: `http://localhost:8000`

## Default Users

After running the seeders, you can log in with these default accounts:

### Admin User
- **Email**: admin@example.com
- **Username**: admin
- **Password**: password
- **Role**: admin

### Regular User
- **Email**: user@example.com
- **Username**: user
- **Password**: password
- **Role**: user

## Database Structure

The application includes these main entities:

- **Users**: Admin and customer users
- **Categories**: Flower categories (Roses, Lilies, etc.)
- **Brands**: Flower brands and suppliers
- **Products**: Flower products with images and stock
- **Customers**: Customer information for orders
- **Orders**: Order management with status tracking
- **Order Items**: Individual items within orders
- **Banners**: Promotional banners
- **Wishlists**: User favorite products

## Available Artisan Commands

```bash
# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed

# Fresh migration with seeders
php artisan migrate:fresh --seed

# Clear application cache
php artisan cache:clear

# Clear configuration cache
php artisan config:clear

# Run tests
php artisan test
```

## Testing

Run the test suite:

```bash
php artisan test
```

Or using the composer script:

```bash
composer run test
```

## File Structure

```
app/
├── Models/           # Eloquent models
├── Http/
│   ├── Controllers/  # Application controllers
│   └── Middleware/   # Custom middleware
database/
├── migrations/       # Database migrations
├── factories/        # Model factories for testing
└── seeders/         # Database seeders
resources/
├── views/           # Blade templates
├── css/             # Stylesheets
└── js/              # JavaScript files
routes/
└── web.php          # Web routes
```

## Technology Stack

- **Backend**: Laravel 12.x, PHP 8.2+
- **Frontend**: Vite, TailwindCSS, JavaScript
- **Database**: MySQL/SQLite
- **Testing**: PHPUnit
- **Package Management**: Composer, npm

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests
5. Submit a pull request


## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).