<?php
	require('../config/connect.php');
	session_start();
	try
	{
		if ($_SESSION['loggedin'] == false)
		{
			$username = $_POST['username'];
			$password = $_POST['password'];

			$query = $connection->prepare("SELECT password FROM users WHERE username = ?");
			$query->execute(array($username));
			if (password_verify($password, $query->fetchColumn()))
			{
				$count = $query->rowCount();
				if ($count > 0)
				{
					$_SESSION["loggedin"] = true;
					$_SESSION["username"] = $username;
					header("location: ../index.php");
				}
				else
				{
					$message = '<label>Wrong Data</label>';
					echo $message;
				}
			}
		}
		else
			echo "You are already logged in";
	}
	catch(PDOException $e) {
		echo "Connecation Failed:" . $sql . "<br>" . $e->getMessage();
	}
	$connection = null;
?>