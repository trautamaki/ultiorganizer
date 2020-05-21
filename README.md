This is the **Ultimate Organizer**, a web application for online score keeping of Ultimate tournaments. To find out more, visit project homepage: https://sourceforge.net/apps/trac/ultiorganizer/wiki. To read more about Ultimate sport visit www.wfdf.org .

# What is here?

The files are organized as follows:

  * **php files in main directory** Only index.php is called directly. All other pages are called vi http://hostname.org/?view=pageXYZ. The pages in the main directory are accessible to all users.
  * **user** The pages in this directory are accessible to logged in users. Maintaining user and team info and result reporting.
  * **admin** The pages in this directory are for administrators (including series and event administrators).
  * **lib** Contains utilities used by all pages. SQL statements should only go in here!
  * **script** JavaScript files
  * **conf** Contains config.inc.php, which contains mysql user information and passwort and other server configuration. It should be writable during installation, but later you should restrict access to it as much as possible!
  * **cust** Contains skins for customized Ultiorganizer instances.
  * **locale** Contains translations. To update, simply edit the html files. To update translations in php pages you need the gettext utilities. The simplest way to add translations is by calling `poedit locales/de_DE.utf8/LC_MESSAGES/messages.po`. Then call 'update', add translations and save.
  * **images** Contains icons, flags, and, by default, the image and media upload directory.
  * **mobile** Contains pages for small screens on mobile devices.
  * **scorekeeper** Another take on mobile pages, using jQuery
  * **ext** Contains pages to be embedded in external pages. See ?view=ext/index
  * **plugins** Mainly tools for maintenance, export, import. Some are rather experimental!
  * **sql** database utilities
  * **restful** ???!!!


# Installation

To run Ultiorganizer you need a web server, php 4.4 and a mysql database.

To install Ultiorganizer simply copy the files to your web server, call http://yourpage.com/install.php and follow the instructions.

# Development

To enable fast start to Ultiorganizer development follow the instructions below to set up a development environment using Docker containers.

In order to install Docker follow the instructions on <https://docs.docker.com/get-docker/>

## Create a network

Adding a Docker network allows you to refer to the database with the contaniers name instead of using an ip-address in addition to isolating your development environment from your other containers. This step is optiona but recommended.

```sh
docker network create ultiorganizer-net
```

## Create the DB

MySQL 8 changed the default characterset to `utf8mb4` and the currently used MySQL PHP extension doesn't support it. Therefore MySQL 5 is used for development.

```sh
export MYSQL_ROOT_PASSWORD='<root password>'

docker run --detach --name=ultiorganizer-db --network ultiorganizer-net --env "MYSQL_ROOT_PASSWORD=$MYSQL_ROOT_PASSWORD" mysql:5.7
```

MySQL 5.7.5 and up implements detection of functional dependence. As there are queries in Ultiorganizer that refer to columns that are not listed in the `GROUP BY` section errors occur. These can be circumvented by disabling the new functionality.

```sh
docker exec ultiorganizer-db mysql --user=root --password="$MYSQL_ROOT_PASSWORD" --execute="CREATE DATABASE ultiorganizer;SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"
```

More details in: <https://dev.mysql.com/doc/refman/5.7/en/group-by-handling.html>

## Create the web server

The original MySQL PHP driver has been deprecated in PHP 5.5.0 and removed in PHP 7.0. Therefore Ultiorganizer can in it's current state be developed only with PHP 5.

The command below should be run ini the folder where you have cloned your Ultiorganizer Git repo. If not then substitute `$PWD` with a path to the code or copy the code to the container.

```sh
docker run --network ultiorganizer-net --name=ultiorganizer --publish 8080:80 --volume "$PWD":/var/www/html --detach php:5-apache

docker run --network ultiorganizer-net --name=ultiorganizer --publish 8080:80 -v "$PWD":/var/www/html -d php:5-apache
```

The base PHP apache image is missing some libraries and extensions that need to be installed.

```sh
docker exec ultiorganizer sh -c 'apt-get --assume-yes update && apt-get --assume-yes install zlib1g-dev libpng-dev'

docker exec ultiorganizer sh -c 'docker-php-ext-install mysql gettext gd mbstring && apachectl restart'
```

Now you should be able to connect to your development Ultiorganizer by poiniting your browser to <http://localhost:8080/>
