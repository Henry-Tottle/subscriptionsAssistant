An API created to serve a React front end to display books and their accompanying information.
Routes: (yes I need to tidy this up)
```/books``` GET - gets all books from database (currently limited to 100)
```/books/{category}``` GET - gets all books in a certain category (currently limited to 100)
```/categories``` GET - gets all distinct categories
```/book/{id}``` GET - gets a particular book by ID

## Install the Application

Create a new directory with your project name, e.g:


```bash
mkdir academyProject
```

Once inside the new directory, clone this repo:

```bash
git clone git@github.com:Mayden-Academy/subscriptionsAssistant.git .
```

One cloned, you must install the slim components by running:

```bash
composer install
```

To run the application locally:
```bash
composer start

```

Import '/public/subscriptions_test_database_2025-01-06.sql'


Run this command in the application directory to run the test suite
```bash
composer test
```

That's it! Now go build something cool.
