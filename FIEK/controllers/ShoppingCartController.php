<?php

class ShoppingCartController
{		
	public function getAll($user_id)
	{
		$obj = new DB_Connect('localhost', 'root', '', 'bookshop');
		
		$query = "SELECT * FROM `shopping_cart` WHERE user_id = '".$user_id."'";
		$get_query = $obj->getconn()->query($query);
		
		if($get_query->num_rows == 0 ) {
			return false;
		}
		else
		{		
			for($i=1; $i<=$get_query->num_rows; $i++)
			{
				$cart_details = $get_query->fetch_assoc();
				
				$query_books = "SELECT * FROM `books` WHERE id = '".$cart_details['book_id']."'";
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
								<td>
									<form action='shoppingcart.php' method='POST'>
										<input type='hidden' name='book' value=".$book_details['id']." />
										<input type='hidden' name='user' value=".$user_id." />
										<button class='order_book' name='order_now'>Order</button>
									</form>
									<form action='shoppingcart.php' method='POST'>
										<input type='hidden' name='book' value=".$cart_details['id']." />
										<input type='hidden' name='user' value=".$user_id." />
										<button id='remove_book' name='remove_book'>Remove</button>
									</form>
								</td>
							</tr>
						</table>
					</div>"
				);
			}
		}
	}
	
	public function getTotalPriceAndNumberOfBooks($user_id) {
		$obj = new DB_Connect('localhost', 'root', '', 'bookshop');
		
		$query = "SELECT * FROM `shopping_cart` WHERE user_id = '".$user_id."'";
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
					<td style='float:right;'>".$get_query->num_rows."</td>
				</tr>
				<tr>
					<td>Total price:</td>
					<td style='float: right;'>".$total_price." euro</td>
				</tr>"
			);
		}
	}

	public function create($user_id, $book_id) {
		$obj = new DB_Connect('localhost', 'root', '', 'bookshop');
		
		$book_exists = "SELECT * FROM `shopping_cart` WHERE user_id='".$user_id."' AND book_id='".$book_id."'";
		$get_row = $obj->getconn()->query($book_exists);
		
		try{
			if($get_row->num_rows == 0) {
				$query = "INSERT INTO `shopping_cart` VALUES('', '".$user_id."', '".$book_id."')";
				$get_query = $obj->getconn()->query($query);
				return true;
			}
			else{
				throw new Exception("Book exists.");
			}
		}catch (Exception $e){
			return false;
		}
	}
	
	public function delete($id)
	{
		$obj = new DB_Connect('localhost', 'root', '', 'bookshop');

		$query = "DELETE FROM `shopping_cart` WHERE id = '".$id."'";
		$get_query = $obj->getconn()->query($query);
		return true;
	}
}

?>