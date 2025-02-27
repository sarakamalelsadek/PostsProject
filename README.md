# PostsProject

## Introduction
This is a Laravel-based API project that provides authentication, user management, and post commenting functionalities.

## Requirements
- **PHP** 8+
- **Laravel** 10+
- **MySQL**
- **Composer**

## Installation

```bash
# Clone the repository
git clone https://github.com/sarakamalelsadek/PostsProject.git

# Navigate to the project directory
cd PostsProject

# Install dependencies
composer install

# Copy the environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Set up the database (update .env file with your DB credentials)
php artisan migrate --seed

# Start the development server
php artisan serve

#start queue to send emails and notifications
php artisan queue:work
```


## Thank You
