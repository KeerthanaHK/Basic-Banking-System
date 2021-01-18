<?php
  

  $db = mysqli_connect("localhost", "root", "", "basicbank");
                    
  // Check connection
  if($db === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
  }
  
?>