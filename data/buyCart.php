<?php
$username = "root";
$password = "root";
$hostname = "localhost"; 
$database = "Shop";


$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$newOrder = "INSERT INTO OrdersBig (buyer)
	VALUES ('John')";

$data = json_decode(file_get_contents("php://input"), true);

if ($conn->query($newOrder) === TRUE) {

    echo "New order successfully";

    $currOrder = mysqli_insert_id($conn);

	foreach ($data as $value){  

		$id = $value['Id'];
		$qInCart = $value['qInCart'];

	    $newOrderLine = "INSERT INTO Orders ( id, productId, quantity) VALUES ('$currOrder','$id','$qInCart')";
	    if ($conn->query($newOrderLine) === TRUE) {
	    	echo "New line inserted";
	    }
	    else{
	    	echo "Error: " . $newOrderLine . "<br>" . $conn->error;
	    }
	}

} 
else {
    echo "Error: " . $newOrder . "<br>" . $conn->error;
}

$conn->close();

/*
test sql
SELECT name, price, quantity, (price*quantity) as total from Products INNER JOIN Orders on Products.Id = Orders.productId where name = "Berk" UNION ALL SELECT 'TOTAL', '', '', Sum(price*quantity) from Products INNER JOIN Orders on Products.Id = Orders.productId where name = "Berk" GROUP BY 1
*/

?> 
