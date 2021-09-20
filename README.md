<h1>Installation</h1>

- composer install
- php artisan key:generate
- php artisan migrate --seed
- php artisan storage:link
- npm install
- npm run dev
- php artisan serve / your deployment method

<i>Remember to set .env APP_URL to make images path work properly</i>

Login as admin: admin@mail.com / admin<br>
Login as user: user1@mail.com / user<br>
For more data see database/seeders/UserSeeder

Full seeding of data can take more than one minute, because of adding images and conversion.

<h3>Implemented features</h3>

<h4>Routing Advanced</h4>

- Route Model Binding in Resource Controllers - <b>All controller user model binding</b>
- Route Redirect - homepage should automatically redirect to the login form - <b>routes/web.php:48</b>

<h4>Database Advanced</h4>

- Database Seeders and Factories - to automatically create first clients/projects/tasks and default users - <b>Done</b>
- Eloquent Query Scopes - show only active clients, for example - <b>app/Models/Project.php:60-87, app/Models/Task.php:51-77</b>
- Polymorphic relationships with Spatie Media Library package - <b>Project, Task & Response models implement Spatie Medialibrary</b>
- Eloquent Accessors and Mutators - view all date values in m/d/Y format - <b>Accessors defined in all models</b>
- Soft Deletes on any Eloquent models - <b>All models implement softdelete</b>

<h4>Auth Advanced</h4>

- Authorization: Roles/Permissions (admin and simple users), Gates, Policies with Spatie Permissions package - <b>PermissionSeeder, RoleSeeder. All actions are controlled by Policies for all models</b>
- Authentication: Email Verification - <b>User implements MustVerifyEmail, routes uses verified middleware, UserService dispatch Registered event and send verify email</b>

<h4>API Basics</h4>

- API Routes and Controllers - <b>routes/api.php, app/Http/Controllers/Api/V1/</b>
- API Eloquent Resources - <b>app/Http/Resources/V1/</b>
- API Auth with Sanctum - <b>routes/api.php:25</b>
- Override API Error Handling and Status Codes - <b>app/Exceptions/Handler.php:43-53</b> 

<h5>Test with Postman:</h5>

<i>(APP_URL depends on how you deploy on your system)</i>

Login post to: APP_URL/login

Pre-request script:

    pm.sendRequest({
      url: 'APP_URL/sanctum/csrf-cookie',
      method: 'GET'
    }, function(error, response, {cookies}){
      if(!error){
        pm.globals.set('xsrf-cookie', cookies.get('XSRF-TOKEN'))
      }
    })

Body / form-data:<br>
email: admin@mail.com<br>
password: admin<br>
Expected response: 204

GET projects: APP_URL/api/v1/project<br>
Expected response: 200

<h4>Debugging Errors</h4>

- Try-Catch and Laravel Exceptions - <b>app/Rules/CheckEncryptedInput.php:29-33</b>
- Customizing Error Pages - <b>Customized layout: resources/views/errors/layout.blade.php & all error pages</b>

<h4>Sending Email</h4>

- Mailables and Mail Facade
- Notifications System: Email - <b>app/Services/ProjectService.php notify user using ProjectAssignedNotification when it assigned on store & when user is changed on update</b>

<h4>Extra</h4>

- Automated Tests for CRUD Operations - <b>Test implemented for all CRUD operations</b>