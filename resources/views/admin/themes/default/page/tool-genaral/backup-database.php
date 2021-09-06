<?php

$backup_folder = cms_path('storage','cms/database/'.$_SERVER['HTTP_HOST'].'/backup_'.time());

File::isDirectory(cms_path('storage').'cms/database/'.$_SERVER['HTTP_HOST']) or File::makeDirectory(cms_path('storage').'cms/database/'.$_SERVER['HTTP_HOST'], 0777, true, true);

if (!file_exists($backup_folder)) {
    mkdir($backup_folder, 0777, true);
}

if( env('DB_CONNECTION') === 'mysql'){
    $tables =  DB::connection()->getDoctrineSchemaManager()->listTableNames();

    foreach ( $tables as $table) {
        File::put($backup_folder.'/'.$table.'.json', json_encode(DB::table($table)->get(),JSON_PRETTY_PRINT));

    }
}else{

    $tables = \DB::connection()->listCollections();

    foreach ( $tables as $index => $collection) {

        $name = $collection->getName();
        File::put($backup_folder.'/'.$name.'.json', json_encode(DB::table($name)->get(),JSON_PRETTY_PRINT));

    }
}



if( env('DB_CONNECTION') === 'mysql'){

    $mysqlUserName      = env('DB_USERNAME', 'forge');
    $mysqlPassword      = env('DB_PASSWORD', '');
    $mysqlHostName      = env('DB_HOST', '127.0.0.1');
    $DbName             = env('DB_DATABASE', 'forge');
    $backup_name        = $backup_folder.'/database.sql';

    //or add 5th parameter(array) of specific tables:    array("mytable1","mytable2","mytable3") for multiple tables
	function Export_Database ($host,$user,$pass,$name,  $tables=false, $backup_name=false ){
        $mysqli = new mysqli($host,$user,$pass,$name); 
        $mysqli->select_db($name); 
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables    = $mysqli->query('SHOW TABLES'); 
        while($row = $queryTables->fetch_row()) 
        { 
            $target_tables[] = $row[0]; 
        }   
        if($tables !== false) 
        { 
            $target_tables = array_intersect( $target_tables, $tables); 
        }
        foreach($target_tables as $table)
        {
            $result         =   $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount  =   $result->field_count;  
            $rows_num=$mysqli->affected_rows;     
            $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
            $TableMLine     =   $res->fetch_row();
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row()){ 
                    //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                        if (isset($row[$j]))
                        {
                            $content .= '"'.$row[$j].'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }      
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }

        $backup_name = $backup_name ? $backup_name : $name.".sql";

        // header('Content-Type: application/octet-stream');   
        // header("Content-Transfer-Encoding: Binary"); 
        // header("Content-disposition: attachment; filename=\"".basename($backup_name)."\"");  

        File::put($backup_name, $content);

        // echo $content; exit;
    }

    Export_Database($mysqlHostName,$mysqlUserName,$mysqlPassword,$DbName,  $tables = false , $backup_name);

}

vn4_create_session_message('Success!','Backup Database Success.','success');

$is_acction = true;

