<?php 
include_once "../init.php";

// User login check
if ($getFromU->loggedIn() === false) {
    header('Location: ../index.php');
    exit; // Exit script
}

include_once 'skeleton.php'; 

// Get current user's data
$userId = $_SESSION['UserId'];
$userData = $getFromU->currentUserData($userId);

// Check if user data is available
if (!$userData || empty($userData)) {
    echo "User data not available.";
    exit; // Exit script
}

// Extract user data
$fullname = isset($userData[0]['Full_Name']) ? htmlspecialchars($userData[0]['Full_Name']) : '';
$usr_name = isset($userData[0]['Username']) ? htmlspecialchars($userData[0]['Username']) : '';
$emailid = isset($userData[0]['Email']) ? htmlspecialchars($userData[0]['Email']) : '';
$JoinDate = isset($userData[0]['RegDate']) ? $userData[0]['RegDate'] : '';
$picture = isset($userData[0]['Photo']) ? $userData[0]['Photo'] : '';
?>      

<div class="wrapper">
    <div class="row">
        <div class="col-12 col-m-12 col-sm-12">
            <div class="card">
                <div class="counter" style="display: flex; align-items: center; justify-content: center;">
                
                <form action="">
                    <h1 style="font-family: 'Source Sans Pro'">Profile</h1>

                    <div>
                        <img style="width:100px; height:100px; object-fit: cover; border-radius: 50%;" src="<?= $picture ?>" alt="">
                    </div>
                    <div>
                        <label for="fullname">Full Name:</label>
                        <input type="text" id="fullname" class="text-input" style="width: 100%;" value="<?= $fullname ?>" readonly><br>
                    </div>
                    <div>
                        <label for="username">User Name:</label>
                        <input type="text" id="username" class="text-input" style="width: 100%;" value="<?= $usr_name ?>" readonly><br>
                    </div>

                    <div>
                        <label for="email">Email Id:</label>
                        <input type="email" id="email" style="width: 100%;" class="text-input" value="<?= $emailid ?>" readonly><br>
                    </div>

                    <div>
                        <label for="regdate">Registration Date:</label>
                        <input type="datetime" id="regdate" class="text-input" style="width: 100%; font-size: 1.1em; padding-left: 45px;" value="<?= $JoinDate ?>" readonly><br>
                    </div>
                    <br>
                                                    
                    <div><br>
                        <a href="11-changepass.php"><button type="button" class="pressbutton" name="submit">Change Password</button></a>
                    </div>								
                    
                </form>
                </div>
            </div>
        </div>       
    </div>
</div>

<script src="../static/js/10-Profile.js"></script>
