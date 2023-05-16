<?php

/* Create connection */
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "dbname";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* get total record */
$query_count = "SELECT count(*) as total_records FROM tablename";
$result_num = $conn->query($query_count);
$records = $result_num->fetch_assoc(); 

$batchSize = 10000; /* Batch Size*/
$totalRecords = $records['total_records']; /* Total number of records to import */
$offset = 0; /* Starting offset for each batch */

while ($offset < $totalRecords) {
	
    /* Fetch a batch of record */
	$query_batch = "SELECT * FROM tablename LIMIT $offset, $batchSize";
    $result = $conn->query($query_batch);

    if ($result->num_rows > 0) {        
        while ($row = $result->fetch_assoc()) {
		         /* write a code to import */
            echo $row['column_name'];
			      ob_flush();	
			      flush();
			      usleep(100000);
        }        
    }
	  $offset += $batchSize;
    $result->free_result();

}

/* Close the connections */
$conn->close();

?>
