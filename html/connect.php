<?php

	class DB {
	    private static $mysqli;
	    private function __construct(){} //no instantiation

	    static function conn() {
	        if( !self::$mysqli ) {
							require_once 'config.php';
							self::$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
	        }
	        return self::$mysqli;
	    }
	}

?>
