# Laravel Project Setup Guide

This guide will help you set up and run the Laravel project using Docker. Follow the steps below to get started.

## Prerequisites

- Ensure you have **Docker** and **Docker Compose** installed on your system.
- If you have **Composer** installed on your system, you should run `composer install` before starting Docker.

## Getting Started

1. **Install Dependencies**

   If Composer is installed locally, inside the **app** directory run:

   ```bash
   composer install
   ```

   This will install the necessary PHP dependencies for the project.

2. **Start Docker**

   Run the following command to start the Docker containers:

   ```bash
   docker-compose up -d
   ```

   If you skipped running `composer install` earlier, you can do it now inside the Docker container. See step 3 for details.

3. **Access the Application Container**

   To log in to the application container's shell, run:

   ```bash
   docker exec --user=application app sh
   ```

   Inside the container shell, run:

   ```bash
   composer install
   ```

4. **Run Migrations and Seeders**

   While inside the container shell, execute the following command to run the database migrations and seeders:

   ```bash
   php artisan migrate --seed
   ```

5. **Access the Application**

   By default, the application runs on **port 80**. Open your browser and visit:

   ```
   http://localhost
   ```

   If you want to change the port, modify the Docker Compose file (`docker-compose.yml`) before running `docker-compose up`.

## Database and Cache Configuration

- This project uses **MySQL** as the database. Ensure your `.env` file is configured with the correct database credentials.
- **Redis** is used for caching. The cache is applied specifically to the `article list` route for improved performance. Make sure Redis is running and properly configured in your `.env` file.

## API Documentation

You can access the API documentation and test the endpoints using the Postman collection available at the given link in email

## Notes

- Ensure your `.env` file is properly configured before running the project. You can copy the `.env.example` file if needed:
  ```bash
  cp .env.example .env
  ```
  Then update the database and other configurations as necessary.
- If you encounter any issues, ensure Docker and Composer are installed and configured correctly.
