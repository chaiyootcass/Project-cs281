<?php
session_start();
if (!isset($_SESSION['name'])) {
	header("location: ../admin.php");
	exit();
}
include_once '../scripts/connect.php';
require_once "Mail.php";
?>


<?php
$radio = $_POST["select"];
if ($radio == "all") {
	$sql = "SELECT email FROM `users`";



	if ($query_run = mysqli_query(mysqli_connect("localhost", "root", "", "cd"), $sql)) {
		while ($row = mysqli_fetch_array($query_run)) {
			// echo $row["email"];

			$host = "ssl://smtp.gmail.com";
			$username = "ClothesShopByCs281@gmail.com";
			$password = "a123b456c";
			$port = "465";
			$to = $row["email"];
			$email_from = "ClothesShopByCs281@gmail.com";
			$email_subject = $_POST["subject"];
			$email_body = $_POST['message'] ;
			$email_address = "ClothesShopByCs281@gmail.com";

			$headers = array ('From' => $email_from, 'To' => $to, 'Subject' => $email_subject, 'Reply-To' => $email_address);
			$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
			$mail = $smtp->send($to, $headers, $email_body);


			if (PEAR::isError($mail)) {
				echo("<p>" . $mail->getMessage() . "</p>");
			} else {
				echo("<p>Message successfully sent!</p>");
			}

		}
	}
}
else{
	if (empty($_POST['to'])) {
		header("location: ../admin/notification.php");
	}

	$recep = $_POST['to'];
	$recep = explode(";", $recep);
	for($i = 0 ; $i < sizeof($recep) ; $i++){
		// echo " ".$recep[$i];

		$host = "ssl://smtp.gmail.com";
		$username = "ClothesShopByCs281@gmail.com";
		$password = "a123b456c";
		$port = "465";
		$to = $recep[$i];
		$email_from = "ClothesShopByCs281@gmail.com";
		$email_subject = $_POST["subject"] ;
		$email_body = $_POST['message'] ;
		$email_address = "ClothesShopByCs281@gmail.com";

		$headers = array ('From' => $email_from, 'To' => $to, 'Subject' => $email_subject, 'Reply-To' => $email_address);
		$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
		$mail = $smtp->send($to, $headers, $email_body);


		if (PEAR::isError($mail)) {
			echo("<p>" . $mail->getMessage() . "</p>");
		} else {
			echo("<p>Message successfully sent!</p>");
		}
	}
}
?>

</style>

