# QR Code Attendance System

A Laravel-based QR code attendance system for tracking student attendance.

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL
- XAMPP (or similar local development environment)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/Is-haka/qr-attendance.git
cd qr-attendance
```

2. Install dependencies:
```bash
composer install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database in `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations:
```bash
php artisan migrate
```

## Testing QR Code Generation

1. Start the Laravel development server:
```bash
php artisan serve
```

2. Test the QR code functionality:
   - View QR code image directly: Visit `http://localhost:8000/qr-test`
   - View QR code in styled page: Visit `http://localhost:8000/qr-view`

The QR code currently contains a test message "Test QR Code". You can scan it with any QR code reader app to verify it works.

## Features

- QR Code Generation using Endroid/QR-Code package
- Student and Admin dashboards
- Attendance tracking
- Bootstrap-styled interface

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request
