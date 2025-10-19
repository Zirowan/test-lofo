# 🎓 ITS NU Pekalongan Lost & Found System

![Laravel](https://img.shields.io/badge/Laravel-v11.x-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css)
![Status](https://img.shields.io/badge/Status-Production%20Ready-green?style=for-the-badge)

A comprehensive web application designed to help students and staff at ITS NU Pekalongan report, track, and recover lost or found items on campus. This system provides a user-friendly platform with features tailored to ensure transparency, ethical posting, and efficient item management.

> **🌍 Language Support**: Fully translated to Bahasa Indonesia with responsive UI/UX optimized for Indonesian university environment.

## 👥 Development Team

This project was developed by:
- **Ahsanu Rohmatika Taqwa**
- **Hasan Mahfudh**
- **Abiyyul Asyqor**

As part of the Final Year Project (FYP) requirement at ITS NU Pekalongan.

## 🌟 Key Features

### 🔐 Authentication & Authorization
- **Student Registration/Login** - Secure authentication for students
- **Admin Panel Access** - Dedicated admin dashboard with enhanced privileges
- **Role-Based Access Control** - Different permissions for students and administrators

### 📍 Location-Based Services
- **Interactive Campus Map** - Leaflet.js with OpenStreetMap/Mapbox integration for precise location reporting
- **Real-time Marker Display** - Dynamic red/green markers for lost/found items with popup information
- **Location Clustering** - Efficient visualization of multiple items in close proximity
- **Geolocation Tracking** - Latitude/longitude coordinates for accurate item placement with fallback to campus default location

### 🧾 Item Management
- **Lost/Found Reporting** - Detailed submission forms with descriptions, photos, and categories
- **Image Upload** - Support for item photos to aid identification
- **Status Tracking** - Real-time updates on item status (Lost, Found, Claimed, Archived)

### ✅ Ethical Verification System
- **Ethics Confirmation** - Mandatory agreement to ethical posting guidelines
- **Admin Moderation** - Review and approval process for all submissions
- **Flagging System** - Report inappropriate or suspicious content

### 🛠️ Admin Dashboard
- **Item Management** - Approve, flag, or delete item listings
- **Claim Processing** - Review and manage item claims
- **User Management** - Monitor student activity and reports
- **Activity Logs** - Track all administrative actions

### 💬 Communication System
- **Messaging Platform** - Direct communication between item owners and finders
- **Real-time Notifications** - Instant updates on claim status changes

### 🔍 Advanced Search Capabilities
- **Text Search** - Keyword-based item discovery with Indonesian language support
- **Image Recognition** - AI-powered search using Google Vision API with robust error handling
- **Category Filtering** - Filter by item type and status
- **Visual Item Details** - Enhanced item viewing page with proper image fallbacks

## 🛠️ Technology Stack

### Backend
- **Framework**: Laravel 11.x
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0+
- **APIs**: Google Maps API, Google Vision API

### Frontend
- **Templating**: Blade Templates with Indonesian language support
- **Styling**: Tailwind CSS 3.x with custom green theme matching ITS NU Pekalongan branding
- **JavaScript**: Vanilla JS with modern ES6+ features and comprehensive error handling
- **Mapping**: Leaflet.js with OpenStreetMap/Mapbox integration and dynamic marker system

### Development Tools
- **Environment**: Laragon (Windows)
- **Package Manager**: Composer (PHP), NPM (JavaScript)
- **Build Tools**: Vite.js

## 📋 System Requirements

- PHP >= 8.2
- MySQL >= 8.0
- Composer
- Node.js >= 16.x
- NPM >= 8.x
- Mapbox Access Token (optional, fallback to OpenStreetMap)
- Google Cloud Vision API Key (optional, with graceful fallback)

## 🚀 Installation Guide

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/lost-and-found-itsnupkl.git
   cd lost-and-found-itsnupkl
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript Dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup**
   - Create a MySQL database
   - Update `.env` with your database credentials
   - Run migrations:
     ```bash
     php artisan migrate
     ```
   - Seed the database:
     ```bash
     php artisan db:seed
     ```

6. **Build Frontend Assets**
   ```bash
   npm run build
   ```

7. **Start Development Server**
   ```bash
   php artisan serve
   ```

8. **Access the Application**
   - Frontend: http://localhost:8000
   - Admin Panel: http://localhost:8000/admin/login

## 👤 Default Credentials

### Admin Access
- **Email**: admin@itsnupkl.ac.id
- **Password**: admin123

### Test Student
- **Email**: test@student.itsnupkl.ac.id
- **Password**: secret123

## 📚 API Documentation

The application provides RESTful endpoints for integration with external systems. Detailed API documentation is available in the [API_DOCS.md](API_DOCS.md) file.

## 🛡️ Security Features

- CSRF Protection
- SQL Injection Prevention
- XSS Attack Prevention
- Password Hashing (bcrypt)
- Session Management
- Input Validation
- File Upload Sanitization
- Enhanced Admin Logging with IP tracking and user agent logging

## 🔧 Recent Updates & Bug Fixes

### ✅ Latest Improvements (Latest Version)
- **Complete Indonesian Translation** - All user interface elements translated to Bahasa Indonesia
- **Map Integration Fixed** - Dynamic red/green markers now properly display database items
- **UI/UX Enhancements** - Fixed navbar overlap, popup positioning, and responsive design issues
- **Database Error Handling** - Improved error handling for image uploads and API integrations
- **Admin Panel Improvements** - Fixed image display paths and moderation functionality
- **Security Enhancements** - Added proper access controls for item deletion and admin logging
- **Robust Error Handling** - Added fallback mechanisms for API failures and missing data

## 📊 Database Schema

The system uses a well-structured database with the following main tables:
- `students` - User accounts and profiles
- `items` - Lost and found item listings
- `claims` - Item claim requests and approvals
- `admins` - Administrative user accounts
- `admin_logs` - Activity logging for admin actions
- `messages` - Communication between users

## 🎨 UI/UX Design

The application features a modern, responsive design with:
- **Custom Green Theme** - Branded theme matching ITS NU Pekalongan identity
- **Mobile-first Approach** - Fully responsive for all device sizes
- **Intuitive Navigation** - User-friendly interface with clear workflows in Bahasa Indonesia
- **Accessibility Features** - WCAG-compliant design principles
- **Fixed Layout Issues** - Proper navbar spacing, map integration, and popup positioning resolved

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is part of a Final Year Project (FYP) for ITS NU Pekalongan and is intended for educational purposes.

## 🙏 Acknowledgments

- ITS NU Pekalongan Faculty and Staff
- Google Cloud Platform for API services
- Open Source Community for development tools and libraries
- **Ahsanu Rohmatika Taqwa**, **Hasan Mahfudh**, and **Abiyyul Asyqor** - Development Team

For a complete list of contributors, please see [AUTHORS.md](AUTHORS.md).

---

<p align="center">Made with ❤️ for the ITS NU Pekalongan Community</p>

