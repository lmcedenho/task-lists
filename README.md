# TaskLists

TaskLists is an application for creating task lists and sharing them with registered users, developed using Laravel 11.

## Technologies Used

- **Laravel 11**: A PHP framework for web application development.
- **Herd**: Environment manager to facilitate local development.
- **Node.js v22.5.1**: JavaScript runtime environment.
- **npm 10.2.2**: Package manager for Node.js.
- **Tailwind CSS**: CSS framework for designing interfaces.
- **Breeze**: Laravel package for user management.
- **Sanctum**: For API authentication.
- **Mailhog**: For testing email notifications.

## Environment Setup

### Prerequisites

Make sure you have installed:
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) and npm

### Steps to Run the Project Locally

1. **Clone the Repository**

   ```bash
   git clone <REPOSITORY_URL>
   cd <DIRECTORY_NAME>
   ```

2. **Install PHP Dependencies**

   Run the following command to install PHP dependencies:

   ```bash
   composer install
   ```

3. **Install Node Dependencies**

   Install the Node.js dependencies by running:

   ```bash
   npm install
   ```

4. **Configure the `.env` File**

   Copy the `.env.example` file and rename it to `.env`:

   ```bash
   cp .env.example .env
   ```

   Then, configure the environment variables according to your local setup.

5. **Generate Application Key**

   Run the following command to generate the application key:

   ```bash
   php artisan key:generate
   ```

6. **Run Migrations**

   Execute the migrations to create the tables in the database:

   ```bash
   php artisan migrate
   ```

7. **Compile Assets**

   Compile the application's assets:

   ```bash
   npm run build
   ```

8. **Start the Local Server**

   Start the local Laravel server:

   ```bash
   php artisan serve
   ```

9. **Register in the Application**

   Open your browser and go to `http://localhost:8000`. You can register as a new user.

## Run Notifications
php artisan queue:work

## Run Tests
php artisan test

## Contributions

Contributions are welcome. If you would like to contribute to this project, please open an issue or submit a pull request.

