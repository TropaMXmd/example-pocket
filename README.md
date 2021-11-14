## How to setup the project

Run the commands
- git clone https://github.com/TropaMXmd/example-pocket.git
- cd example-pocket
- cp .env.example .env
- alias sail='bash vendor/bin/sail'
- sail up --build

Application URL: http://localhost:8080/

To migrate table run: sail artisan migrate
To run queue: sail artisan queue:work
To run test: sail artisan test

A postman api collection is included with the project to test api
