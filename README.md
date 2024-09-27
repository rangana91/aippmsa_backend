# Laravel Livewire Project

This is a **Laravel** application that uses **Livewire** for dynamic front-end interactions. The project is built on **Laravel 9** and includes several packages that extend the functionality of the application.

## Requirements

Before running this project, ensure that you have the following installed:

- **PHP 7.3 or 8.0+**
- **Composer** (for managing dependencies)
- **Node.js & npm** (optional, for front-end assets)
- **MySQL or any other database supported by Laravel**

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/rangana91/aippmsa_backend
    cd aippmsa_backend
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    ```

3. Copy `.env` file:
    ```bash
    cp .env.example .env
    ```

4. Set your environment variables in the `.env` file (database, mail, etc.).

5. Generate an application key:
    ```bash
    php artisan key:generate
    ```

6. Run migrations:
    ```bash
    php artisan migrate
    ```

7. (Optional) If you're using **Laravel Sail**, start the local development server:
    ```bash
    ./vendor/bin/sail up
    ```

8. Start the Laravel development server:
    ```bash
    php artisan serve
    ```

## Features

This project includes the following packages and features:

- **Livewire**: A framework for building dynamic interfaces without leaving Laravel.
- **Laravel Sanctum**: Provides a simple token-based API authentication system.
- **Yajra DataTables**: A plugin for handling dynamic tables with sorting, filtering, and pagination.
- **Spatie Laravel Permission**: Handle user roles and permissions.
- **Stripe API**: Integrates the **Stripe** payment gateway for processing payments.

## Demo

### Login Page
![Login Page](http://app.novatechlane.net/storage/appendix/backend/login.png)

### Demo Video
[Watch the Demo](http://app.novatechlane.net/storage/videos/backend-demo.mp4)

## Usage

- All core logic for Livewire components is located in the `app/Http/Livewire/` directory.
- To create a new Livewire component, use the following artisan command:
    ```bash
    php artisan make:livewire YourComponentName
    ```

## Testing

This project uses **PHPUnit** for testing. Run the test suite using:

```bash
php artisan test
```

You can also run specific test cases located in the `tests/` directory.

## Contributing

If you'd like to contribute to this project:

1. Fork the repository.
2. Create a new branch for your feature or bug fix:
    ```bash
    git checkout -b feature/your-feature-name
    ```
3. Commit your changes:
    ```bash
    git commit -m "Add your message here"
    ```
4. Push to your branch:
    ```bash
    git push origin feature/your-feature-name
    ```
5. Create a pull request.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.
