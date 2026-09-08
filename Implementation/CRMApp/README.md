# Sofa Project AppComm "Customer Relation Management"

## Description

## Using Docker

```bash
docker compose up
```

If it is you first launch, make sure, that you run the following command do initialize the database:
```bash
docker exec crmapp-crm-1 php artisan migrate 
docker exec crmapp-crm-1 php artisan key:generate
docker exec crmapp-crm-1 php artisan db:seed --class=AdminUserSeeder
```

## Installation

After pulling the repository, run the following commands to set up the project locally:

```bash
composer install
npm install
```

Once all dependencies are installed, copy the `.env.example` file to `.env` and fill in the required values.
That is mainly the database connection information without which the project will not work.
Then you can run the following commands to set up the database and generate the application key:

```bash
php artisan migrate
php artisan key:generate
```

Have a look at the chapter [Default Admin User](#default-admin-user) if you want to create an admin user automatically.

After that you can run the following commands to start the development server:

```bash
npm run build
php artisan serve
```

The application should now be available at [http://localhost:8000](http://localhost:8000).

### Default Admin User

It is possible to automatically generate an admin user during the installation process. 
If you are using the provided `.env.example` there will already be an admin user created with the following credentials:

```dotenv
ADMIN_NAME=Admin
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=password
```

If you wish to create a different admin user after you already ran the above installation commands, you can do so by replacing the values in the `.env` file before running the migration the first time.
After changing the values, run the following command to create the admin user:

```bash
php artisan db:seed --class=AdminUserSeeder
```

If you want to create a few sample customers with contact persons, use this command.

```bash
php artisan db:seed --class=CustomerSeeder
```

And if you wish to create a few solutions, you can use this command.

```bash
php artisan db:seed --class=SolutionSeeder
```

This will create a new user or update an existing one if only the name or password changed.
If the email also changed a new user will be created, however the old one will not be deleted automatically.

### Development

If you want to work on the project it is recommended that instead of running `npm run build` you run `npm run dev` to automatically recompile the assets when they change.
You then however have to run the serve command in a separate terminal window:

```bash
npm run dev
php artisan serve
```

## Testing

To run the tests, run the following command:

```bash
php artisan test
```

Or if to run the tests with coverage:

```bash
php artisan test --coverage
```

It is also possible to set different environment variables for the tests by creating a `.env.testing` file.
This file will be loaded automatically when running the tests.
After creating this file it is recommended to run the following command to migrate the testing database:

```bash
php artisan migrate --env=testing
```


## Usage

After the installation you can log in with the admin user you created or the default admin user.
