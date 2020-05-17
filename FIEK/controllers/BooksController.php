<?php

//include_once '../config/db_connection.php';

class BooksController
{
	public function showAllBooks() {
		
		$conn = new DB_Connect('localhost', 'root', '', 'bookshop');
		$query = "SELECT * FROM `books`";
		$get_query = $conn->getconn()->query($query);
		$user_id=null;
		if(isset($_SESSION['u_id'])){
			$user_id = $_SESSION['u_id'];
		}
		
		if($get_query->num_rows == 0 ) {
			return false;
		}
		else
		{
			for($i=0; $i<$get_query->num_rows; $i++)
			{
				$book = $get_query->fetch_assoc();
				//$_SESSION['book'.$i] = $book['id'];

				echo 
				(
					"<figure>
						<img src='../img/".$book['image']."' alt='Image could not be shown' width='400px' height='290px'>
						<figcaption>
							".$book['title']."
						</figcaption>
						<h2>".$book['price']." euro</h2>
						<form action='home.php' method='POST'>
							<input type='hidden' name='book1' value=".$book['id']." />
							<input type='hidden' name='user1' value=".$user_id." />
							<button class='buy_now' name='order_now'>Order now</button><br>
						</form>
						<form action='home.php' method='POST'>
							<input type='hidden' name='book2' value=".$book['id']." />
							<input type='hidden' name='user2' value=".$user_id." />
							<button class='shopping_cart' name='add_to_cart'>Add to cart</button>
						</form>
					</figure>"
				);
			}
			
		}
	}
}

?>