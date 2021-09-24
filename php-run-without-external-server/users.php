<?php

/**
* Author : https://roytuts.com
*/

require_once 'db.php';


$sql = "SELECT * FROM user";
$results = dbQuery($sql);

$rows = array();

while($row = dbFetchAssoc($results)) {
	$rows[] = $row;
}

closeConn();

echo json_encode($rows);

//End of file