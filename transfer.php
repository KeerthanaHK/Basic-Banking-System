<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
    <title>Transfer page</title>
</head>
<body style="background-color:lightblue">
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
        
        <center>
        <?php
        include './config.php';
        if (isset($_REQUEST['id'])) {
            $sid = $_GET['id'];
            $sql = "SELECT * FROM  customers where id=$sid";
            $result = mysqli_query($db, $sql);
            if (!$result) {
                echo "Error : " . $sql . "<br>" . mysqli_error($db);
            }
            $rows = mysqli_fetch_assoc($result);
        }
        ?>
        <form method="post" name="tcredit" class="tabletext"><br>

            <div>
                <table class="table table-sm table-striped table-condensed table-bordered" id="customers">
                    <tr>
                        <th class="text-center">Id</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Balance</th>
                    </tr>
                    <tr>
                        <td class="center py-2"><?php echo (isset($rows['id']) ? $rows['id'] : ''); ?></td>
                        <td class="center py-2"><?php echo (isset($rows['name']) ? $rows['name'] : ''); ?></td>
                        <td class="center py-2"><?php echo (isset($rows['email']) ? $rows['email'] : ''); ?></td>
                        <td class="center py-2"><?php echo (isset($rows['balance']) ? $rows['balance'] : ''); ?></td>
                    </tr>
                </table>
            </div>
        <div id="box">
            <div class="container">
                <br><br>
                <label for="to">Select a recepient to transfer:</label><br>
                <select id="to" name="to" class="form-control" required>
                    <option value="" disabled selected>Choose</option>
                    <?php
                    include 'config.php';
                    $sid = $_REQUEST['id'];
                    $sql = "SELECT * FROM customers where id!=$sid";
                    $result = mysqli_query($db, $sql);
                    if (!$result) {
                        echo "Error " . $sql . "<br>" . mysqli_error($db);
                    }
                    while ($rows = mysqli_fetch_assoc($result)) {
                    ?>
                        <option id="customers" class="table" value="<?php echo $rows['id']; ?>">

                            <?php echo $rows['name']; ?> (Balance:
                            <?php echo $rows['balance']; ?> )

                        </option>
                    <?php
                    }
                    ?>
            </div>
            </select>
            <br><br>
            <label for="amount">Amount:</label><br>
            <input type="number" class="form-control" name="amount" id="amount" required>

            <br><br>
            <div class="text-center">
                <button class="btn mt-3 waves-effect waves-light" name="submit" type="submit" id="btn">Transfer</button>
                
            </div>
            <br>
        </div>    
           
        </form>
    </div>
    </div>
    </center>  
</body>

    <style>
    .container-fluid{
            background-color: #ddd;
            font-size: 20px;
            margin-left: 15rem;
            margin-right: 15rem;
            padding: 10px;
            
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



        #customers td, #customers th {
        border: 1px solid black;
        padding: 8px;
        }

        #customers tr{background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #950740;
        color: white;
        }

        #box{
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ddd;
            margin: 8rem 31rem;
            border: 1px solid black;
            border-radius: 50px;
        }
        
        

    </style>





</html>
<?php
include './config.php';

if (isset($_POST['submit'])) {

    $from = $_GET['id'];
    $to = $_POST['to'];
    $amount = $_POST['amount'];

    $sql = "SELECT * from customers where id=$from";
    $query = mysqli_query($db, $sql);
    $sql1 = mysqli_fetch_array($query); // returns array from which the amount is to be transferred.

    // check input of negative value by user
    if (($amount) < 0) {
        echo '<script>';
            echo ' alert("Please enter correct amount.")';  // showing an alert box.
        echo '</script>';
    }

    // check insufficient balance.
    else if ($amount > $sql1['balance']) {
        echo '<script>';
            echo ' alert("Bad Luck! Insufficient Balance")';  // showing an alert box.
        echo '</script>';
    }

    // constraint to check zero values
    else if ($amount == 0) {

        echo "<script>";
            echo "alert('Oops! Zero value cannot be transferred')";
        echo "</script>";
    } else {
        $sql = "SELECT * from customers where id=$to";
        $query = mysqli_query($db, $sql);
        $sql2 = mysqli_fetch_array($query);

        $sender = $sql1['name'];
        $receiver = $sql2['name'];

        // subtracting amount 
        $newbalance = $sql1['balance'] - $amount;
        $sql = "UPDATE customers set balance=$newbalance where id=$from";
        mysqli_query($db, $sql);

        // adding amount 
        $newbalance = $sql2['balance'] + $amount;
        $sql = "UPDATE customers set balance=$newbalance where id=$to";
        mysqli_query($db, $sql);


        $sql = "INSERT INTO transaction(`sender`, `receiver`, `balance`) VALUES ('$sender','$receiver','$amount')";
        $query = mysqli_query($db, $sql);

        if ($query) {
            echo "<script> alert('Transaction Successful !!');
                                     window.location='./index.php#view';
                           </script>";
        }

        $newbalance = 0;
        $amount = 0;
    }
}
?>