
<html>
<title>Manage Comments</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
	
	<link rel="icon" href="peaspod.jpeg" type="image/png" sizes="16x16">
	<script>
	function ValidateComment(){ 
	    var username = document.forms["episodeForm"]["username"]; 
		var pTitle = document.forms["episodeForm"]["pTitle"]; 
		var eTitle = document.forms["episodeForm"]["eTitle"]; 
		var description = document.forms["episodeForm"]["description"];
   
	
		if (username.value.length < 0 || username.value.length > 20 || username.value == "")                                  
	    { 
	        window.alert("Username is either empty or too long."); 
	        email.focus(); 
	        return false; 
	    }
	}
	</script>
</head>

<body>
<h1> Two Peas in a Podcast Manage Topics Page </h1>

<div id="main">

<div class="container"> <!-- beginning of the forms-->
	
	
	
	<div class = "Manage Topics">

	<h4>Enter Your Username to Topic Suggestions</h4>
	<form name = "manageTopicsForm" onsubmit="return ValidateTopics()" method = "post">
	
	<table width= "40%">
	<tr><td> Your Username: <input type="text" size=20 name="username" value = "enter username"> 
	</td><td><input type = "submit" name = "submit" value="Submit here"/>
	</table>
	</form>
	</div><!--end manage comment div-->		  	 
</div> <!--end of the forms -->

<?php


 		$servername = "mydb.itap.purdue.edu";
 		$username = "g1117061";
 		$password = "!@Pod2020";
 		$dbname = "g1117061"; 
 		// Create connection
 		$conn = mysqli_connect($servername, $username, $password , $dbname);
 		// Check connection
 		if (!$conn) {
 		die("Connection failed: " . mysqli_connect_error());
 		}
 		//echo "Connected successfully<br><br>";
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
		   $u_username = test_input($_POST["username"]);
		}
		
		function test_input($data) 
		{
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
  
		  return $data;
		}
		
 		/////////////////////////////////////////////////////
 		//print topic and  topicID related to the username
		$sql = 'SELECT T.topicID, T.description FROM TopicSuggestions T JOIN Podcast P ON P.podcastTitle = T.PodcastTitle WHERE P.username = \''. $u_username . '\';';
		
		
		
 		$result = mysqli_query($conn, $sql);
 		if($result){
			
 			echo "<h3 style= 'text-align:left;'>Topic Suggestions on Your Podcast:</h3>";
			
			echo '<table border = 1, class = "popular List">';
		
			//prints the table row by row
			if(!(mysqli_num_rows($result) > 0)){
 				echo "The username may not have any associated topics.";
			} else {
				echo "<th> Topic ID </th>";
				echo "<th> Topic </th>";
	 			while($row = mysqli_fetch_assoc($result)) {
					
	 					echo "<tr style = text-align:center>"; // start row
	 					echo "<td style='height:100px, width:100px'>" . $row['topicID']. "</td>";
						echo "<td style='height:100px, width:100px'>" . $row['description']. "</td>";
	 					echo "</tr>"; // end row
	 			} //end while
	 			echo "</table>";
				
				
				//if there are comments, give then the option to delete the comments
				?>
				<div class = "Delete Topics">

				<h4>Enter the topic ID you would like to delete:</h4>
				<form name = "deleteTopicsForm" action="deleteTopic.php" method = "post">
	
				<table width= "40%">
				<tr><td> Your Username: <input type="text" size=20 name="username" value = "enter username"> 
				</td><td> Topic ID: <input type="number" size=20 name="TopicNumber" value = "12"> 
				</td><td><input type = "submit" name = "submit" value="Submit here"/>
				</table>
				</form>
				</div><!--end delete comment div-->
<?php		
				
	 		} //end  else 
 		} else {
 			 echo "Error: " . $sql . "<br>" . mysqli_error($conn) . "<br>";
 		} // end if
		

?>


</div> <!--end main-->


</body>
</html>