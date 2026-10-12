<?php
	// This file stores the database connection settings in one place.
	// Keeping credentials here (instead of inside db_class.php) means
	// you only have to update them in one spot if the database changes.
    // This is the configuration layer.
	// define() creates a global constant - a named value that cannot
	// be changed anywhere else in the app once it is set here.

	define("DATABASE", "ecommerce_2026A_joanne_chepkoech"); // name of the database to connect to
	define("SERVER", "localhost"); // where the database server is running
	define("USERNAME", "joanne.chepkoech");    // MySQL username
	define("PASSWD", "Sep#pch2004");          // MySQL password (empty for local XAMPP by default)
?>
