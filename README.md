<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <h1>Project Setup Guide</h1>
        <h2>Introduction</h2>
        <p>This guide provides instructions for setting up and running the Laravel-based project locally on your machine.</p>
        <h2>Prerequisites</h2>
        <ul>
            <li>PHP >= 8.0</li>
            <li>Composer</li>
            <li>Laravel</li>
            <li>XAMPP (or any local server with MySQL)</li>
        </ul>
        <h2>Installation Steps</h2>
        <ol>
            <li><strong>Clone the project:</strong></li>
            <pre><code>git clone https://github.com/yourusername/project_2.git</code></pre>
            <li><strong>Navigate to the project directory:</strong></li>
            <pre><code>cd project_2</code></pre>
            <li><strong>Install the dependencies:</strong></li>
            <pre><code>composer install</code></pre>
            <li><strong>Create a copy of the .env file:</strong></li>
            <pre><code>cp .env.example .env</code></pre>
            <li><strong>Generate the application key:</strong></li>
            <pre><code>php artisan key:generate</code></pre>
            <li><strong>Configure the .env file:</strong> Open the <code>.env</code> file and update the following database settings:</li>
            <pre><code>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
            </code></pre>
            <li><strong>Run the database migrations:</strong></li>
            <pre><code>php artisan migrate</code></pre>
            <li><strong>Start the local server:</strong></li>
            <pre><code>php artisan serve</code></pre>
            <li><strong>Access the application:</strong> Open your browser and go to <code>http://localhost:8000</code></li>
        </ol>
        <h2>Usage</h2>
        <p>Once the setup is complete, you can start using the application by registering and logging in. You can perform CRUD operations on posts and manage users.</p>
        <h2>Additional Information</h2>
        <p>If you encounter any issues, check the Laravel documentation or reach out to the project maintainer.</p>
    </div>
</body>
</html>
