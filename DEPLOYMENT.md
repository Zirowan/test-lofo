# 🚀 Deployment Guide - ITS NU Pekalongan Lost & Found System

This guide provides step-by-step instructions for deploying the Lost & Found system to production environment.

## 📋 Pre-Deployment Checklist

### System Requirements
- **Server**: Ubuntu 20.04+ / CentOS 7+ / Windows Server 2019+
- **PHP**: 8.2 or higher
- **MySQL**: 8.0 or higher
- **Web Server**: Apache 2.4+ / Nginx 1.18+
- **SSL Certificate**: Recommended for production

### Required Environment Variables
```env
APP_NAME="ITS NU Pekalongan Lost & Found"
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lostandfound
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password

MAPBOX_ACCESS_TOKEN=your-mapbox-token
GOOGLE_APPLICATION_CREDENTIALS=path/to/service-account.json

MAIL_MAILER=smtp
MAIL_HOST=smtp.your-provider.com
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

## 🛠️ Production Deployment Steps

### 1. Server Setup
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install nginx mysql-server php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip composer nodejs npm git -y

# Install additional PHP extensions
sudo apt install php8.2-gd php8.2-intl php8.2-bcmath -y
```

### 2. Database Setup
```bash
# Secure MySQL installation
sudo mysql_secure_installation

# Create database and user
sudo mysql -u root -p
```

```sql
CREATE DATABASE lostandfound CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'lostfound_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON lostandfound.* TO 'lostfound_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Application Deployment
```bash
# Clone repository
cd /var/www
sudo git clone https://github.com/your-repo/lost-and-found-itsnupkl.git
sudo chown -R www-data:www-data lost-and-found-itsnupkl
cd lost-and-found-itsnupkl

# Install dependencies
sudo -u www-data composer install --optimize-autoloader --no-dev
sudo -u www-data npm install
sudo -u www-data npm run build

# Set permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 4. Environment Configuration
```bash
# Copy environment file
sudo cp .env.example .env
sudo nano .env
# Configure all environment variables as shown above

# Generate application key
sudo -u www-data php artisan key:generate

# Run migrations
sudo -u www-data php artisan migrate --force

# Seed database (optional)
sudo -u www-data php artisan db:seed --force

# Cache configuration
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
```

### 5. Web Server Configuration

#### Nginx Configuration
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/lost-and-found-itsnupkl/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### SSL Configuration (Let's Encrypt)
```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Obtain SSL certificate
sudo certbot --nginx -d your-domain.com

# Auto-renewal setup
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

### 6. Performance Optimization
```bash
# Install Redis (optional, for better performance)
sudo apt install redis-server php8.2-redis -y

# Configure Laravel for Redis in .env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Set up Laravel scheduler
sudo crontab -e
# Add: * * * * * cd /var/www/lost-and-found-itsnupkl && php artisan schedule:run >> /dev/null 2>&1
```

### 7. Security Hardening
```bash
# Set proper file permissions
sudo chown -R www-data:www-data /var/www/lost-and-found-itsnupkl
sudo find /var/www/lost-and-found-itsnupkl -type f -exec chmod 644 {} \;
sudo find /var/www/lost-and-found-itsnupkl -type d -exec chmod 755 {} \;
sudo chmod -R 775 storage bootstrap/cache

# Configure firewall
sudo ufw allow 'Nginx Full'
sudo ufw allow ssh
sudo ufw enable
```

## 🔧 Post-Deployment Tasks

### 1. Verify Installation
- Visit your domain to ensure the application loads
- Test login functionality with admin credentials
- Verify map functionality and marker display
- Test item submission and image upload

### 2. Monitor Performance
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Monitor server resources
htop
df -h
```

### 3. Backup Setup
```bash
# Create database backup script
sudo nano /usr/local/bin/backup-db.sh
```

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u lostfound_user -p lostandfound > /backups/db_backup_$DATE.sql
find /backups -name "*.sql" -mtime +7 -delete
```

```bash
sudo chmod +x /usr/local/bin/backup-db.sh
sudo crontab -e
# Add: 0 2 * * * /usr/local/bin/backup-db.sh
```

## 🚨 Troubleshooting

### Common Issues

1. **Map not loading**: Check Mapbox token and firewall settings
2. **Image upload fails**: Verify storage permissions and PHP upload limits
3. **500 errors**: Check Laravel logs and file permissions
4. **Database connection**: Verify MySQL service and credentials

### Useful Commands
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check application status
php artisan about

# Run database migration
php artisan migrate:status
```

## 📞 Support

For deployment issues or questions, please refer to:
- [README.md](README.md) - General setup and requirements
- [API_DOCS.md](API_DOCS.md) - API documentation
- GitHub Issues for bug reports

---

**Important**: Always test in a staging environment before deploying to production!
