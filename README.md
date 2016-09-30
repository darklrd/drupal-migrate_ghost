Drupal Migrate Ghost
====================

Uses [Drupal][]s migrate API to migrate content from a [Ghost][] blog to
Drupal 8.

## Installation

1. Install [Drush][] if you do not have it already.
2. Download [Migrate Plus][], [Migrate Tools][], and this module, using 
   your preferred method (Drush, composer, manual download, etc.)
3. Install the modules.
4. Create a text format with the machine name "markdown"
5. Configure Drupal's access to the Ghost database, by adding a section
   for it in Drupal's settings.php file, like this:
   
		  $databases['ghost']['default'] = [
		    'database' => 'ghost_mikkel',
		    'username' => 'ghost',
		    'password' => 'ghostly-password',
		    'prefix' => '',
		    'host' => 'localhost',
		    'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
		    'driver' => 'mysql',
		  ];
		  
	Note that this section should be in addition to your existing database
	configuration, not replace it.

	This should work with any of Ghost's supported databases, not just
	MySQL. Refer to the documentation in settings.php for how to configure
	the database connection to PostgreSQL or SQLite.


## Usage

Once the module is installed (see above), run the following Drush command
to complete the migration:

    drush mi --group=ghost

[Drupal]: https://www.drupal.org/
[Ghost]: https://ghost.org/
[Migrate Plus]: https://www.drupal.org/project/migrate_plus
[Migrate Tools]: https://www.drupal.org/project/migrate_tools
[Drush]: http://www.drush.org/
