Welcome to DechetAgglo!
===================


Dechet Agglo is a project for the city of Bourg-En-Bresse to inform citizen about waste management

----------


Requirements
-------------
Apache web server
MySQL Database
NodeJS (npm)
Gulp (`npm install -g gulp`)


Install
-------------

1. Download composer.phar : 
	  `php -r "readfile('https://getcomposer.org/installer');" | php`
2. Install  php dependencies : 
	 `php composer.phar update`
3. Create database: 
	`php app/console doctrine:database:create`
3. Generate tables: 
	`php app/console doctrine:schema:create`
5. Install node dependencies : 
	`npm install`
6. Run Gulp default task : 
	`gulp`
