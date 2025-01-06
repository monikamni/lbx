
## Project installation
To set the project:

1. Clone project using git@github.com:monikamni/lbx.git URL
2. add .env file
3. Update composer (composer update)
4. Run migrations (php artisan migrate)
5. Execute "php artisan serve"
6. Now you can test apis with localhost url. Here is the list of apis
- To import csv (file field name: employees): POST http://127.0.0.1:8000/api/employee
- To get all the empolyees: GET http://127.0.0.1:8000/api/employee
- To get perticular employee: GET http://127.0.0.1:8000/api/employee/198429
- To delete employee record: DELETE http://127.0.0.1:8000/api/employee/198429


## API Authentication
We can use Laravel Passposrt or Sanctum for Authentication.
I haven't added it yet.
