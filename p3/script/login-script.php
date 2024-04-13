<?php

$errors = array();

$prevURL = $_GET['prevURL'];

function verify($token) {
    //The url you wish to send the POST request to
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    
    
    //The data you want to send via POST
    $fields = [
        'secret'    =>  '6LfUyZ4pAAAAAL8jRJqmzZ-xXMT81NHjRxTFEzOj',
        'response'  =>  $token
    ];
    
    //url-ify the data for the POST
    $fields_string = http_build_query($fields);
    
    //open connection
    $ch = curl_init();
    
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    //execute post
    $result = curl_exec($ch);
    return json_decode($result, true);
    
}

function generateLoginKey() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 254; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function login($username) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        
        // Get user access key
        $userAccessKey = generateLoginKey();
        
        // Set user access cookies based on 'stayLoggedIn' checkbox
        if (isset($_POST['stayLoggedIn'])) {
            setcookie('username', $username, time() + (86400 * 30), "/");
            setcookie('userAccessToken', $userAccessKey, time() + (86400 * 30), "/");
        } else {
            setcookie('userAccessToken', $userAccessKey, "/");
            setcookie('userAccessToken', $userAccessKey, "/");
        }
        
        // Update userLastLogin and userAccessKey
        $sql = "UPDATE Users SET userLastLogin = CURRENT_TIMESTAMP, userAccesskey = ? WHERE username=?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("ss", $userAccessKey, $username);
        
        if ($prepStmt->execute() === TRUE) {
            printConsole("Successfully updated timestamp");
        } else {
            printConsole("Error updating timestamp: " . $prepStmnt->errorInfo());
        }

        $conn->close();
    }
}

function loginVerify($username, $password) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $errors;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        $sql = "SELECT * FROM Users WHERE username=?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("s", $username);
        
        $prepStmt->execute();
        
        $result = $prepStmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return true;
            } else {
                $errors[] = "Incorrect Username or Password!";
                return false;
            }
        } else {
            $errors[] = "Incorrect Username or Password!";
            printConsole("No User Found");
            return false;
        }
        
        $conn->close();
    }
}

if (isset($_POST['login'])) {
    global $prevURL;
    //validate recaptcha
    if (!empty($_POST['recaptcha-token'])) {
        printConsole("Recaptcha Token Found");
        
        $results = verify($_POST['recaptcha-token']);
        if ($results['success'] == 1) {
            printConsole("Recaptcha Token Valid");
        } else {
            $recaptchaError = "Could not validate reCaptcha: ";
            foreach($results['error-codes'] as $key => $code) {
                if ($key == count($results['error-codes']) - 1) {
                    $recaptchaError .= $code;
                } else {
                    $recaptchaError .= $code . ', ';
                }
                
            }
            $errors[] = $recaptchaError;
        }
        
        
    } else {
        $errors[] = 'Please validate the reCaptcha';
    }
    
    if (loginVerify($_POST['username'], $_POST['password']) && empty($errors)) {
        login($_POST['username']);
        if ($prevURL) {
            header("Location: " . $prevURL);
        } else {
            header("Location: https://voidfyre.space/userpage");
        }
        
    }
}

if (isset($_POST['logout'])) {
    logout();
}

?>