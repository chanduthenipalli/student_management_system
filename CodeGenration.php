<!DOCTYPE html>
<html>

<head>
    <style>
        button{
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
         button:hover {
            background-color: hsl(123, 40%, 45%);
        }
        </style>
</head>

<body>
    <div class="collapse navbar-collapse navbar-responsive-collapse">
        <div class="res-container">
            <ul class="nav navbar-nav">
                <!-- Collect the nav links, forms, and other content for toggling -->
                <!-- Home  -->
                    <a href="Index.html">
                        <Button href="Index.html">BACK</Button>
                    </a>
                </li>
                <!-- End Home-->
            </ul>
        </div>
    </div>

    <?php
    session_start();

    // Check if the secret code is already generated and within the valid time
    if (isset($_SESSION['secret_code'])) {
        $current_time = time();
        $expiry_time = $_SESSION['expiry_time'];
        if ($current_time > $expiry_time) {
            unset($_SESSION['secret_code']);
            unset($_SESSION['expiry_time']);
        } else {
            $secret_code = $_SESSION['secret_code'];
            echo '<p style="font-family: Times New Roman; font-size: 18px; font-weight: bold;">Your Code Is Generated:</p>';
            echo '<p style="font-family: Times New Roman; font-size: 16px; ">' . $secret_code . '</p>';
            exit;
        }
    }

    // Generate a new secret code
    $secret_code = generateCode();
    $_SESSION['secret_code'] = $secret_code;
    $_SESSION['expiry_time'] = time() + 60; // Set the expiry time for 2 minutes

    exit;
    //Genrating Secret Code
    function generateCode() 
	{
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = '';
        for ($i = 0; $i < 6; $i++) 
        {
            $index = rand(0, strlen($characters) - 1);
            $random_string .= $characters[$index];
        }
        return $random_string;
    }
    ?>
</body>

</html>
