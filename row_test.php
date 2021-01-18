<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
    <title>Basic Banking System</title>
</head>
<body style="background-color:lightblue;"> 
    <div id="navhome">
    <nav id="navbar" class="navi" style="background-color: #950740; overflow: hidden; padding: 0px; margin: 0px;">
        <ul style="list-style-type: none;">
            <li style="margin-bottom: 10px; text-align: center; float: right; overflow: hidden; padding-right: 15px;">
            <a href="./index.php#view" style="color: white; text-decoration: none; font-size:20px">View Customers</a></li>
            <li style="margin-bottom: 10px; text-align: center; float: right; overflow: hidden; padding-right: 15px;">
            <a href="./index.php" style="color: white; text-decoration: none; font-size:20px">Home</a></li>
            
        </ul>
    </nav>
    
        
    </div>

<center style="padding: 30px; margin-top: 15rem;">

    <?php
$con=mysqli_connect("localhost","root","","basicbank");
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
 } else {
   $id=NULL;
 }
 
 $sql = "SELECT * FROM customers WHERE id = '".$id."'";
 $result = mysqli_query($con,$sql);
 $row = mysqli_fetch_assoc($result);
 if(mysqli_num_rows($result) == 1) {
  
    echo "<table border=2>";
        echo "<tr style='background-color: #950740'>";
            echo "<th>ID</th><th>Name</th><th>Email</th><th>Balance</th>";
        echo "</tr>";
        echo "<tr style='background-color: #ddd'>";
            echo "<td>" .$row['id']. "</td><td>" .$row['name']. "</td><td>" .$row['email']. "</td><td>"  .$row['balance']. "</td>";
        echo "</tr>";
    
    echo "</table>";

 } else {
   echo "no records found with this id";
 }


mysqli_close($con);
?>
<br>
<div>
<form method="post" action="">
<a href="./transfer.php?id=<?php echo $row['id']; ?>"> 
<button type=button id="btn">TRANSFER</button>
</a></form>
</div>

</center>
<style>
        h1{
        font-size: 40px;
        
        top: 40%;
        left: 20%;
        
        }
        
        .container-fluid{
            background-color: #ddd;
            font-size: 20px;
            text-align: center;
            padding-top:2rem;
            padding-left:10%;
            padding-right:10%;
            padding-bottom: 5rem;
        }
        center{
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        font-size: 25px;

        }

        #btn{
            background-color:  #950740;
            color: white;
            cursor: pointer;
            border-radius: 10px;
            font-size: 20px;
        }


       
::-webkit-scrollbar {
  width: 10px;
}


::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px #950740; 
  border-radius: 10px;
}
 

::-webkit-scrollbar-thumb {
  background: #950740; 
  border-radius: 10px;
}


::-webkit-scrollbar-thumb:hover {
  background: #950740; 
}
    </style>

     
</body>
</html>
