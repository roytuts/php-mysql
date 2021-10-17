<?php

	require("config.php");

	$sql = "SELECT * FROM user";
	$result = dbQuery($sql);

	if (dbNumRows($result) > 0) {
		while ($row = dbFetchAssoc($result)) {
			echo "\n";
			echo 'Id: ' . $row['id'] . "\n";
			echo 'Name: ' . $row['name'] . "\n";
			echo 'Email: ' . $row['email'] . "\n";
			echo 'Phone: ' . $row['phone'] . "\n";
			echo 'Address: ' . $row['address'] . "\n";
			echo "\n";
		}
	} else {
		echo 'No result found';
	}
	
?>