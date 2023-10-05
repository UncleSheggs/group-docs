## Group Docs

A simple API to create group and add members to the group.

The app allows you to:
- List all the groups and its members
- Create a Group and add up to 5 members to it

## Installation

1. Clone the project by running `git clone git@github.com:thecyrilcril/group-docs.git` or ```git clone https://github.com/thecyrilcril/group-docs.git``` from your CLI of choice.
2. Run ```cd group-docs``` to change into the project's directory
3. Run ```git checkout structure``` to checkout the ```structure``` branch.
4. Run ```composer install``` to install all php dependencies
5. create an ```.env``` *environment file* file at the root directory and copy the contents of ```.env.example``` into it, alternatively you can run ```cp .env.example .env``` from the CLI
6. Create a database with the value of the `DB_DATABASE` environment variable as the database name.
7. change all DB_~ configurations in the newly created .env file to the required values for your machine
8. Run `php artisan migrate:fresh --seed` in you CLI to seed the database with 100 sample users, and 25 groups already populated with members. 
9. Run `php artisan key:generate` to generate an encryption key for the application.
10. Run `php artisan serve` to start the application.


## Final Notes
- Visit `~/docs/api#/` on your browser to see the docs
- You can test the endpoints directly on the docs page or try the endpoints on your preffered HTTP Client(Postman, Insomia etc).

