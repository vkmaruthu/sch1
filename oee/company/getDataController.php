<?php 
    require '../common/db.php';
    //require '../common/session.php';

function mysqli_insert_array($table, $data, $exclude = array()) {
    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
            $fields[] = "`$key`";
            //$values[] = "'" . mysql_real_escape_string($data[$key]) . "'";
            $values[] = "'" .$data[$key]. "'";
        }
    }     
    $fields = implode(",", $fields);
    $values = implode(",", $values);

    $sql="INSERT INTO `$table` ($fields) VALUES ($values)";
    return $sql;
}   

function mysqli_update_array($table, $data, $exclude = array(),$cond) {
    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
            $dataA[]=$key."='" .$data[$key]. "'";
        }
    }     
    $dataA = implode(",", $dataA);

    $updateSql = "UPDATE $table SET $dataA where $cond";
    return $updateSql;
}

// get time formate in mm/dd/yyyy hh:mm PM TO yyyy-mm-dd hh:mm:ss Database Formate
function getDbDateTimeFormate($input) {
    $Datetime = date("Y-m-d H:i:s", strtotime($input));
    $only_date =date("Y-m-d", strtotime($input));
     return  array( "DateTime" => $Datetime,
                    "only_date" => $only_date,
                   );
}

function addZero($num) {
    if($num < 10) {
        $num = "0".$num;
    }
    return $num;
  }


?>