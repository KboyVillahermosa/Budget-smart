<?php
  class User extends Base {
    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Removes extra space and html code from input
    public function checkInput($var) {
        $var = htmlspecialchars($var);
        $var = trim($var);
        $var = stripslashes($var);
        return $var;
    }

    // Logs a user in
    public function login($username, $password) {
        if ($this->pdo !== null) {
            $stmt = $this->pdo->prepare("SELECT UserId FROM user WHERE Username = :username AND Password = :password");
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $hash = md5($password);
            $stmt->bindParam(":password", $hash, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();

            if ($count > 0) {
                $_SESSION['UserId'] = $user->UserId;
                header("Location: templates/3-Dashboard.php");
            } else {
                return false;
            }
        } else {
            // Handle the case where $this->pdo is null
            return false;
        }
    }

    // Checks if email already exists
    public function checkEmail($email) {
        if ($this->pdo !== null) {
            $stmt = $this->pdo->prepare("SELECT UserId FROM user WHERE Email = :email");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            return ($count > 0);
        } else {
            // Handle the case where $this->pdo is null
            return false;
        }
    }

    // Checks if username already exists
    public function checkUsername($username) {
        if ($this->pdo !== null) {
            $stmt = $this->pdo->prepare("SELECT UserId FROM user WHERE Username = :username");
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            return ($count > 0);
        } else {
            // Handle the case where $this->pdo is null
            return false;
        }
    }

    // Returns the path of profile picture from database by user id
    public function Photofetch($UserId) {
        if ($this->pdo !== null) {
            try {
                // Prepare the SQL statement
                $stmt = $this->pdo->prepare("SELECT Photo FROM user WHERE UserId = :UserId");

                // Bind parameters and execute
                $stmt->bindParam(":UserId", $UserId, PDO::PARAM_INT);
                $stmt->execute();

                // Fetch the result
                $user = $stmt->fetch(PDO::FETCH_OBJ);

                // Return the photo
                return $user->Photo;
            } catch (PDOException $e) {
                // Handle the error (e.g., log it, display an error message)
                echo "Error: " . $e->getMessage();
                // Optionally, rethrow the exception to propagate it further
                // throw $e;
            }
        } else {
            // Handle the case where $this->pdo is null
            return false;
        }
    }

    // Logs a user out
    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . 'index.php');
    }

    // Checks if a user is logged in
    public function loggedIn() {
        if (isset($_SESSION['UserId'])) {
            return true;
        }
        return false;
    }
// Returns data of the currently logged-in user
public function currentUserData($userId, $fetchMode = PDO::FETCH_ASSOC) {
    if ($this->pdo !== null) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE UserId = :UserId");
            $stmt->bindParam(":UserId", $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll($fetchMode);
        } catch (PDOException $e) {
            // Handle the error
            echo "Error: " . $e->getMessage();
            return false;
        }
    } else {
        // Handle the case where $this->pdo is null
        return false;
    }
}

    // Returns all users' data
    public function userData($fetchMode = PDO::FETCH_OBJ) {
        if ($this->pdo !== null) {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM user");
                $stmt->execute();
                return $stmt->fetchAll($fetchMode); // Fetch all rows
            } catch (PDOException $e) {
                // Handle the error
                echo "Error: " . $e->getMessage();
                return false;
            }
        } else {
            // Handle the case where $this->pdo is null
            return false;
        }
    }
}

?>