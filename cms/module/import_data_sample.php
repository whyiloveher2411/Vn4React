<?php
function importSqlFile($sqlFile, $tablePrefix = null, $InFilePath = null){
  try {
    
    $servername = config('database.connections.mysql.host');
    $port = config('database.connections.mysql.port');
    $username = config('database.connections.mysql.username');
    $password = config('database.connections.mysql.password');
    $database_name = config('database.connections.mysql.database');

    try{
        $pdo = new pdo( 'mysql:host='.$servername.':'.$port.';dbname='.$database_name,
                        $username,
                        $password,
                        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0; SET @tables = NULL;SELECT GROUP_CONCAT(table_schema, '.', table_name) INTO @tables  FROM information_schema.tables   WHERE table_schema = '".$database_name."'; SET @tables = CONCAT('DROP TABLE ', @tables); PREPARE stmt FROM @tables; EXECUTE stmt; DEALLOCATE PREPARE stmt; SET FOREIGN_KEY_CHECKS = 1; ");

    }catch(PDOException $ex){

      return false;
    }

    // Enable LOAD LOCAL INFILE
    $pdo->setAttribute(\PDO::MYSQL_ATTR_LOCAL_INFILE, true);
    
    $errorDetect = false;
    
    // Temporary variable, used to store current query
    $tmpLine = '';
    
    // Read in entire file
    $lines = file($sqlFile);
    
    // Loop through each line
    foreach ($lines as $line) {
      // Skip it if it's a comment
      if (substr($line, 0, 2) == '--' || trim($line) == '') {
        continue;
      }
      
      // Read & replace prefix
      $line = str_replace(['<<prefix>>', '<<InFilePath>>'], [$tablePrefix, $InFilePath], $line);
      
      // Add this line to the current segment
      $tmpLine .= $line;
      
      // If it has a semicolon at the end, it's the end of the query
      if (substr(trim($line), -1, 1) == ';') {
        try {
          // Perform the Query
          $pdo->exec($tmpLine);
        } catch (\PDOException $e) {
          return $e->getMessage();
          $errorDetect = true;
        }
        
        // Reset temp variable to empty
        $tmpLine = '';
      }
    }
    
    // Check if error is detected
    if ($errorDetect) {
      return false;
    }
    
  } catch (\Exception $e) {
    return $e->getMessage();
  }
  
  return true;
}
