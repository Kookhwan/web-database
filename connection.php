<?php

	function ConnectToDatabase()
	{
		$dbName = realpath("assignment5.mdb");
        
		if (!file_exists($dbName))
        {
			die("Could not find database file.");
            return false;
		}

        $connectionString = 'odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq='.$dbName;

        $connection = new PDO($connectionString);
		$connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
		return $connection;
    
	}
?>