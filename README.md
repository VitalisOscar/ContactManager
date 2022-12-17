This application allows multiple users to add, edit, view and delete contacts easily

### Set up
- Run the command `composer install` to install dependencies
- Create a copy of `.env.example` and save it as `.env`
- Create an application key by running the command `php artisan key:generate`

#### Database setup
Create a database to use in storing the application data
Open the `.env` file and update the following lines in the `DB` section with your environment specific settings
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<NAME OF THE DATABASE YOU CREATED>
DB_USERNAME=root
DB_PASSWORD=
```
Create the database tables by running the command:<br>**`php artisan migrate`**

## Running the application
After you have set up everything you can now run the application by running the command:<br>**`php artisan serve`**<br>
Open a browser and navigate to the url specified on the terminal after you run the command e.g localhost:8000

