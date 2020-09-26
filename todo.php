<?php 
	
	$errors = "";
	$servername = "localhost"; 
	$username ="root";
	$password = '';
	$dbname = 'todo';

	// connect to database
	$conn = mysqli_connect( $servername,$username ,$password);

	// check connection 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error().'<br>');
	}

	// Create database
	$sql = "CREATE DATABASE IF NOT EXISTS todo";
	if (mysqli_query($conn, $sql)) {
	echo " ".'<br>';
	} else {
	echo "Error creating database: " . mysqli_error($conn).'<br>';
	}
	
	// Create table
	$sql = "CREATE TABLE IF NOT EXISTS list(
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		task VARCHAR(255)
	)";
	
    $conn = mysqli_connect($servername, $username, $password, $dbname);
	if (mysqli_query($conn, $sql)){
	  echo  " ".'<br>';
	} else {
	echo "Error creating table: " . mysqli_error($conn).'<br>';
	}

	
	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {

		if (empty($_POST['task'])) {
			$errors = "Put at least one item for the TO-DO list";
		}else{
			$task = $_POST['task'];			
			$query = "INSERT INTO list(task) VALUES('$task')";

			if (mysqli_query($conn, $query)){
				echo 'task logged to database <br>';
			}else {
				echo 'error logging task:'.mysqli_error($conn).'<br>';
			};
			header('location: todo.php');
		}
	}	

	// delete task
	if (isset($_GET['del_task'])) {
		$id = $_GET['del_task'];

		mysqli_query($conn, "DELETE FROM list WHERE id=".$id);
		header('location: todo.php');
	}

	// select all tasks if page is visited or refreshed
	$tasks = mysqli_query($conn, "SELECT * FROM list");


	// mysqli_close($conn);

?>
<!DOCTYPE html>
<html>

<head>
	<title>ToDo List Application PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="todo.css">
</head>

<body>

	<div class="heading">
		<h2 style="font-style: 'Hervetica';">ToDo List Application Using PHP and MySQL database</h2>
	</div>


	<form method="post" action="todo.php" class="input_form">
		<?php if (isset($errors)) { ?>
			<p><?php echo $errors; ?></p>
		<?php } ?>
		<input type="text" name="task" class="task_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add activity</button>
	</form>

		<?php 
		$sql = "SELECT id, task FROM list  ";
		$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		// $result = mysqli_result();
		
		while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){ 			
		?>
			<ul style='list-style: none;'>	
				<li>			
				<?php echo  $row['task'] ?> 
				
				<span class="delete">
					<a href="todo.php?del_task=<?php echo $row['id'] ?>">x</a> 
				</span>
				
				</li>  	
			</ul>
		<?php }  ?> 
			<?php mysqli_close($conn);  ?> 	
	
	</body>
</html>