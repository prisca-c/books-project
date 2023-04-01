# books-project

---

This is a school project which basically consists of a website where you can :

- Add books to your library
- Add books to your wishlist
- Search for books by title, author, tags, etc.
- Rate books
- Comment books
- Check books, authors statistics (ratings, comments, etc.)

__Requirements:__

- PHP 8.0+
- Composer
- MySQL
- A web server (Apache, Nginx, etc.)
- **Optional** * : Docker (to create a container for the database, but you can use any MYSQL Database)

__Installation:__

Run the following commands in your terminal :

```composer install```

Note:
- If you don't have composer installed, you can download it from [here](https://getcomposer.org/download/).
- If you don't have PHP installed, you can download it from [here](https://www.php.net/downloads.php).
- **Optional** * : If you have docker installed, you can run the following command to create a MYSQL DB : ```docker-compose up -d``` which will create a container for MYSQL Database.

Inside folder ```config``` you'll find a file called ```database_config``` which contains the database configuration to change.

You need to create a database and use the file ```database_create.sql``` inside ```Database``` folder to create the tables.

__Usage:__

Commands that can be used :

```composer start``` : This will start a PHP server on port 8000.

```composer db:create``` : This will create the databse ( **don't forget to change script inside ```composer.json``` with your database's informations** )

```composer db:seed``` : This will insert fake data into the database ( **to start when database is fresh new** )

```composer db:drop``` : This wil drop all table in your database