# Lost and Found Project Setup Guide

## Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL database
- Laragon (recommended for Windows users)

## Setup Instructions

### 1. Environment Configuration
```bash
# Copy the example environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 2. Database Setup
1. Make sure MySQL is running
2. Update the .env file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=lostandfound
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Create the database:
   ```sql
   CREATE DATABASE IF NOT EXISTS lostandfound;
   ```

### 3. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Build frontend assets
npm run build
```

### 4. Database Migrations and Seeding
```bash
# Run migrations
php artisan migrate --force

# Seed the database with initial data
php artisan db:seed
```

### 5. Running the Application
```bash
# Start the development server
php artisan serve

# The application will be available at http://127.0.0.1:8000
```

## Admin Access
After seeding the database, you can access the admin panel:
- URL: http://127.0.0.1:8000/admin/login
- Use the default admin credentials from the seeder

## Troubleshooting

### Database Connection Issues
1. Ensure MySQL service is running
2. Verify database credentials in .env file
3. Check if the database exists

### Missing Dependencies
If you encounter any issues with missing packages:
```bash
composer install
npm install
```

### Clear Cache
If you make changes and they don't appear:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```