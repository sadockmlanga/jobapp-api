# Simple Recruitment Website - Laravel Backend API

This is the backend API repository for the Simple Recruitment Website project. It provides endpoints for managing job postings, user authentication, handling job applications, and integrating with the Stripe payment gateway for premium features.

## Features

- **Job Posting:** Recruiters can create, update, and delete job postings.
- **User Authentication:** Users can register, login, and manage their accounts.
- **Job Applications:** Users can apply for jobs, and recruiters can manage applications.
- **Premium Features:** Recruiters can pay for premium features to enhance their job postings and visibility.

## Technologies Used

- **Laravel:** PHP framework for building web applications.
- **Laravel Sanctum:** Laravel package for API token authentication.
- **MySQL:** Relational database management system for storing data.
- **Stripe:** Payment gateway for processing online payments securely.

## Installation

To set up the backend API locally, follow these steps:

1. Clone this repository to your local machine.
2. Install Composer dependencies using `composer install`.
3. Copy the `.env.example` file to `.env` and configure your database connection and Stripe API keys.
4. Generate an application key using `php artisan key:generate`.
5. Run database migrations and seeders using `php artisan migrate --seed`.
6. Start the development server using `php artisan serve --port=8090`.

## Stripe Integration

This backend API integrates with Stripe for processing online payments for premium features. Make sure to configure your Stripe API keys in the `.env` file:

```
STRIPE_KEY=your_stripe_public_key
STRIPE_SECRET=your_stripe_secret_key
```


## Contributing

Contributions are welcome! If you'd like to contribute to this project, please fork the repository, make your changes, and submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).
