
<!-- <h1>My name is max</h1> -->

<form action="#" method="post">
    <input type="text" name="firstName" placeholder="first name">
    <input type="text" name="lastName" placeholder="last name">
    <input type="text" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input type="submit" name="submit" id="submit">
</form>

<?php
    //connect to the database
    //hostname, username, password, database
    $dbc = new mysqli('localhost','root','','myPhotoApp');
    // echo $_GET['email'];

    //check to see if the form has been submitted
    if(isset($_POST['submit'])) {
        //turn array keys into variables
        extract($_POST);
        
        // echo $firstName . ' <br />';
        // echo $lastName . ' <br />';
        // echo $email . ' <br />';
        // echo $password . ' <br />';
        $query = "INSERT INTO users_table VALUES(NULL,'$firstName','$lastName','$email','$password','16-02-2020','photo.png')";
        
        //ready to send our query
        $dbc -> query($query);
    }

    // 1: write a select query to get user information
    $getUsers = "SELECT usersID, firstName, lastName, email FROM users_table";
    
    // 2: store that information into a variable called resultObject
    $resultObject = $dbc -> query($getUsers);
    
    // 3: convert the object into an array
    $usersInfo = [];
    while($row = $resultObject -> fetch_assoc()) {
        $usersInfo[] = $row;
    }
   
    echo '<h2>Users:</h2>';
    foreach($usersInfo as $user) {    
        echo '<ul>';
        echo '<li>First Name: '.$user['firstName'].'</li>';
        echo '<li>Last Name: '.$user['lastName'].'</li>';
        echo '<li>Email: '.$user['email'].'</li>';
        echo '<li><a href="index.php?delete=y&usersID='.$user['usersID'].'">delete</a></li>';
        echo '</ul>';
    }
    

    // echo '<pre>';
    //     print_r($usersInfo);
    // echo '</pre>';


    //delete the user from the table according to the 'delete' link
    if(isset($_GET['delete']) && $_GET['delete'] == 'y') {
        $usersID = $_GET['usersID'];
        $query = "DELETE FROM users_table WHERE usersID=$usersID";
        //send the query!
        $result = $dbc -> query($query);
        if($result) {
            header('Location:index.php?');
        }

       
    }

    