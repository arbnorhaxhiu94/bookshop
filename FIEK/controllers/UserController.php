<?php
include_once "../config/db_connection.php";
$obj = new DB_Connect('localhost', 'root', '', 'bookshop');

$id = intval($_GET['id']);

$query = "SELECT * FROM `users` WHERE id = '".$id."'";
$get_query = $obj->getconn()->query($query);
$user = $get_query->fetch_assoc();

echo
( 
	"<table id='saved_books_table'>
		<tr>
			<td>".$user['id']."</td>
			<td>".$user['firstname']."</td>
			<td>".$user['lastname']."</td>
			<td>".$user['email']."</td>
		</tr>
	</table>"
);

?>