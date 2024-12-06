<?php 
    session_start();
    if (isset($_SESSION['admin_id'])) {
        header('location:home.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ReadHub</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            height: 100vh;
            color: #E0E0E0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('images/library.jpeg') no-repeat center center fixed;
            background-size: cover;
            overflow: hidden;
        }

        /* Blur Effect */
        .background-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Dark overlay */
            filter: blur(8px);
            z-index: 1;
        }

        /* Centered Card */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            flex-direction: column;
            z-index: 2;
        }

        .login-card {
            background-color: #2D2D2D;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 100%;
            text-align: left;
        }

        .login-card h4 {
            color: #FF8A00;
            font-size: 32px; /* Larger font size */
            font-weight: 600;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            text-align: left;
            color: #E0E0E0;
            font-weight: 500;
            font-size: 16px;
        }

        .form-control {
            background-color: #3C3C3C;
            color: #E0E0E0;
            border: 1px solid #555;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
        }

        .form-control:focus {
            border-color: #FF8A00;
            box-shadow: 0 0 5px rgba(255, 138, 0, 0.7);
        }

        .btn-primary {
            background-color: #FF8A00;
            border: none;
            color: #E0E0E0;
            font-size: 18px;
            padding: 14px;
            width: 100%;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #FF6600;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 16px;
            color: #E0E0E0;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .login-card {
                padding: 30px;
            }
            .login-card h4 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="background-overlay"></div> <!-- Overlay for background blur -->

    <div class="login-container">
        <div class="login-card">
            <h4>ReadHub Login</h4>
            <form id="frm-login" enctype="multipart/form-data">
                <div id="username_warning" class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="Enter your username" required>
                </div>
                <div id="password_warning" class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" id="login" class="btn btn-primary">
                    <span class="glyphicon glyphicon-log-in"></span> Login
                </button>
            </form>
            <div id="result"></div>
        </div>

        <div class="footer">
            <label>&copy; 2025 ReadHub. All rights reserved.</label>
        </div>
    </div>
</body>
	<script src = "js/jquery.js"></script>
	<script src = "js/bootstrap.js"></script>
	<script src = "js/login.js"></script>
</html>
