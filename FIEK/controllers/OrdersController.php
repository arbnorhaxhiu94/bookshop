<?php
	
	
class OrdersController 
{
	public function getAll($user_id)
	{
		$obj = new DB_Connect('localhost', 'root', '', 'bookshop');
		
		$query = "SELECT * FROM `orders` WHERE user_id = '".$user_id."'";
		$get_query = $obj->getconn()->query($query);
		
		if($get_query->num_rows == 0 ) {
			return false;
		}
		else
		{		
			for($i=1; $i<=$get_query->num_rows; $i++)
			{
				$order_details = $get_query->fetch_assoc();
				
				$query_books = "SELECT * FROM `books` WHERE id = '".$order_details['book_id']."'";
				$get_book = $obj->getconn()->query($query_books);
				$book_details = $get_book->fetch_assoc();
				echo
				( 
					"<div class='saved_books'>
						<table id='saved_books_table'>
							<tr>
								<td><img src='../img/".$book_details['image']."' alt='kits' width='100px' height='100px'></td>
								<td>".$book_details['title']."</td>
								<td>".$book_details['price']." euro</td>
								<form action='orders.php' method='POST'>
									<input type='hidden' name='order_id' value='".$order_details['id']."'/>
									<td><button id='cancel_order' name='cancel_order'>Cancel order</button></td>
								</form>
							</tr>
						</table>
					</div>"
				);
			}
		}
	}
	
	public function getTotalPriceAndNumberOfOrders($user_id) {
		$obj = new DB_Connect('localhost', 'root', '', 'bookshop');
		
		$query = "SELECT * FROM `orders` WHERE user_id = '".$user_id."'";
		$get_query = $obj->getconn()->query($query);
		
		if($get_query->num_rows == 0 ) {
			return false;
		}
		else
		{	
			$total_books = 0;
			$total_price = 0;
			for($i=1; $i<=$get_query->num_rows; $i++)
			{
				$cart_details = $get_query->fetch_assoc();
				
				$query_books = "SELECT * FROM `books` WHERE id = '".$cart_details['book_id']."'";
				$get_book = $obj->getconn()->query($query_books);
				$book_details = $get_book->fetch_assoc();
				
				$total_price += $book_details['price'];
			}
			echo
			( 
				"<tr>
					<td>Total books:</td>
					<td>".$get_query->num_rows."</td>
				</tr>
				<tr>
					<td>Total price:</td>
					<td>".$total_price." euro </td>
				</tr>"
			);
		}
	}
	
	
	public function makeOrder($city, $address, $phoneNumber, $password)
	{
		$obj = new DB_Connect('localhost', 'root', '', 'bookshop');
	
		$check_order = "SELECT * FROM `orders` WHERE user_id = '".$_SESSION['u_id']."' AND book_id = '".$_SESSION['book_id']."'";
		$get_orders = $obj->getconn()->query($check_order);
		
		if($get_orders->num_rows == 0)
		{
			$query = "SELECT * FROM `users` WHERE `id` = '".$_SESSION['u_id']."' AND `password` = '".$obj->getconn()->real_escape_string($password)."'";
		
			$get_query = $obj->getconn()->query($query);
			
			if($get_query->num_rows == 0) 
			{
				return 0;
			}
			else if($get_query->num_rows == 1)
			{
				$create_query = "INSERT INTO `orders` VALUES('', '".$_SESSION['u_id']."', '".$_SESSION['book_id']."', '".$city."', '".$address."', '".$phoneNumber."')";
				$create_order = $obj->getconn()->query($create_query);
				unset($_SESSION['book_id']);
				return 1;
			}
		}
		else {
			return 2;
		}
	}
	
	public function deleteOrder($order_id)
	{
		$obj = new DB_Connect('localhost', 'root', '', 'bookshop');
		
		$query = "DELETE FROM `orders` WHERE id = '".$order_id."'";
		$execute_query = $obj->getconn()->query($query);
		
		if($execute_query)
		{
			return true;
		}else{
			return false;
		}
	}
}
	
?>





























