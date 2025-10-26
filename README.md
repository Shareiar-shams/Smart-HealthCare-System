# 🏥 Healthcare Management System

A comprehensive Laravel-based healthcare management system designed for hospitals, clinics, and medical practices. This system provides a complete solution for patient management, appointment scheduling, medical records, and administrative tasks.

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-4.6-7952B3?style=for-the-badge&logo=bootstrap)

## 📋 Table of Contents

- [✨ Features](#-features)
- [🏗️ Tech Stack](#️-tech-stack)
- [📋 Prerequisites](#-prerequisites)
- [🚀 Installation](#-installation)
- [⚙️ Configuration](#️-configuration)
- [📖 Usage](#-usage)
- [🏗️ Project Structure](#️-project-structure)
- [👥 User Roles & Permissions](#-user-roles--permissions)
- [🔌 API Endpoints](#-api-endpoints)
- [🧪 Testing](#-testing)
- [🚀 Deployment](#-deployment)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)

## ✨ Features

### 👥 User Management
- **Multi-role Authentication** (Super Admin, Doctor, Patient, Pharmacy)
- **Role-based Access Control** (RBAC)
- **User Profiles** with detailed information
- **Secure Password Management**

### 📅 Appointment System
- **Online Appointment Booking**
- **Real-time Availability Checking**
- **Doctor Schedule Management**
- **Appointment Status Tracking** (Pending, Confirmed, Cancelled)
- **Document Upload** with appointments
- **Notification System**

### 👨‍⚕️ Doctor Management
- **Doctor Profiles** with specializations
- **Experience & Qualification Tracking**
- **Chamber Information**
- **Consultation Fee Management**
- **Schedule Management**

### 🏥 Patient Management
- **Patient Registration & Profiles**
- **Medical History Tracking**
- **Document Management**
- **Appointment History**
- **Prescription Access**

### 📋 Medical Records
- **Digital Prescription System**
- **Medical Test Reports**
- **Treatment History**
- **Document Storage & Retrieval**

### 🩸 Additional Features
- **Blood Donation Management**
- **Medical Learning Resources**
- **Admin Dashboard** with analytics
- **Responsive Design** for all devices

## 🏗️ Tech Stack

### Backend
- **Laravel 11.x** - PHP Web Framework
- **PHP 8.2+** - Server-side Scripting
- **MySQL 8.0+** - Database
- **Composer** - Dependency Management

### Frontend
- **Bootstrap 4.6** - CSS Framework
- **JavaScript (ES6+)** - Client-side Scripting
- **jQuery** - DOM Manipulation
- **Summernote** - Rich Text Editor
- **SweetAlert2** - Beautiful Alerts
- **Select2** - Enhanced Select Boxes

### Development Tools
- **Laravel Mix** - Asset Compilation
- **NPM** - Package Management
- **Git** - Version Control

## 📋 Prerequisites

Before you begin, ensure you have met the following requirements:

- **PHP 8.2 or higher**
- **MySQL 8.0 or higher**
- **Composer** (latest version)
- **Node.js & NPM** (for asset compilation)
- **Git** (for version control)
- **Web Server** (Apache/Nginx) or Laravel development server

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/healthcare-management-system.git
cd healthcare-management-system
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

```bash
cp .env.example .env
```

Edit the `.env` file with your database and application settings:

```env
APP_NAME="Healthcare Management System"
APP_ENV=local
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=healthcare_db
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email@domain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Database Setup

```bash
# Create database
mysql -u your_username -p -e "CREATE DATABASE healthcare_db;"

# Run migrations
php artisan migrate

# Seed the database (optional)
php artisan db:seed
```

### 7. Storage Link

```bash
php artisan storage:link
```

### 8. Compile Assets

```bash
npm run dev
# or for production
npm run production
```

### 9. Start the Application

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## ⚙️ Configuration

### Database Configuration
- All migrations are located in `database/migrations/`
- Seeders are in `database/seeders/`
- Models are in `app/Models/`

### Role & Permission Setup
The system uses Laravel Permission package for role management:

```bash
php artisan permission:create-role Super\ Admin
php artisan permission:create-role Doctor
php artisan permission:create-role Patient
php artisan permission:create-role Pharmacy
```

### File Upload Configuration
- Upload settings in `config/filesystems.php`
- Maximum file size in `.env` file
- Storage location: `storage/app/public/`

## 📖 Usage

### 👥 User Registration

1. **Super Admin**: First user registered becomes Super Admin
2. **Doctor Registration**: Requires approval from Super Admin
3. **Patient Registration**: Self-registration available
4. **Pharmacy Registration**: Requires approval from Super Admin

### 📅 Appointment Booking

1. **Patient selects a doctor**
2. **Chooses available date and time**
3. **Provides reason for visit**
4. **Uploads relevant documents** (optional)
5. **Submits appointment request**

### 👨‍⚕️ Doctor Dashboard

- **View daily appointments**
- **Manage patient records**
- **Update appointment status**
- **Access patient documents**

### 💊 Pharmacy Dashboard

- **View and manage orders**
- **Process prescriptions**
- **Track order status** (Pending, Completed)
- **Access patient order history**
- **Quick actions for order fulfillment**

### 🔐 Admin Panel

- **User management**
- **System configuration**
- **Analytics and reports**
- **Content management**

## 🏗️ Project Structure

```
healthcare-management-system/
├── app/
│   ├── Http/Controllers/           # Controllers
│   │   ├── Administration/         # Admin controllers
│   │   ├── Appointment/            # Appointment management
│   │   └── Auth/                   # Authentication
│   ├── Models/                     # Eloquent models
│   ├── Services/                   # Business logic
│   └── Traits/                     # Reusable traits
├── database/
│   ├── migrations/                 # Database migrations
│   └── seeders/                    # Database seeders
├── public/
│   ├── assets/                     # Compiled assets
│   └── index.php                   # Entry point
├── resources/
│   ├── views/                      # Blade templates
│   │   ├── admin/                  # Admin views
│   │   ├── layouts/                # Layout templates
│   │   └── errors/                 # Error pages
│   └── lang/                       # Language files
├── routes/                         # Route definitions
├── storage/                        # File storage
├── tests/                          # Test files
└── config/                         # Configuration files
```

### Key Directories Explained

- **`app/Http/Controllers/`** - Request handling logic
- **`app/Models/`** - Database models and relationships
- **`app/Services/`** - Business logic and operations
- **`resources/views/`** - User interface templates
- **`database/migrations/`** - Database schema changes
- **`routes/`** - URL routing definitions

## 👥 User Roles & Permissions

### Super Admin
- Full system access
- User management
- System configuration
- All appointments access
- Financial reports

### Doctor
- Patient appointment management
- Medical records access
- Prescription creation
- Schedule management
- Patient communication

### Patient
- Appointment booking
- Medical record access
- Document upload
- Profile management
- Appointment history

### Pharmacy
- Order management and fulfillment
- Prescription processing
- Inventory tracking (if applicable)
- Patient order history
- Profile management

## 🔌 API Endpoints

### Appointment APIs
```javascript
// Get available time slots
GET /api/doctor/{doctor}/time-slots?date=2024-01-15

// Book appointment
POST /administration/appointment/store

// Get appointments
GET /administration/appointment/index
```

### Authentication APIs
```javascript
// Login
POST /login

// Register
POST /register

// Logout
POST /logout
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test --filter=AppointmentTest

# Generate test coverage report
php artisan test --coverage
```

## 🚀 Deployment

### Using Laravel Forge
1. Connect your repository to Laravel Forge
2. Configure deployment settings
3. Set up SSL certificate
4. Deploy!

### Manual Deployment
```bash
# On production server
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run production
```

### Environment Variables for Production
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=your_production_db_host
DB_DATABASE=your_production_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password
```

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/amazing-feature`)
3. **Commit** your changes (`git commit -m 'Add amazing feature'`)
4. **Push** to the branch (`git push origin feature/amazing-feature`)
5. **Open** a Pull Request

### Development Guidelines

- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation as needed
- Ensure all tests pass before submitting PR

## 📞 Support

If you encounter any issues or need help:

- **Documentation**: Check the `docs/` directory
- **Issues**: Open a GitHub issue with detailed information
- **Discussions**: Use GitHub Discussions for questions

## 🔄 Changelog

See [CHANGELOG.md](CHANGELOG.md) for version history and updates.

## 🙏 Acknowledgments

- Laravel Framework and community
- Bootstrap team for the amazing CSS framework
- All contributors who help improve this project
- Healthcare professionals who provided valuable insights

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

---

<p align="center">Made with ❤️ for healthcare professionals and patients</p>
<p align="center">
    <img src="https://img.shields.io/badge/Status-Production%20Ready-brightgreen" alt="Status">
    <img src="https://img.shields.io/badge/Maintained-Yes-green" alt="Maintained">
    <img src="https://img.shields.io/badge/Contributions-Welcome-orange" alt="Contributions Welcome">
</p>
