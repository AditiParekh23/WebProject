<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventify | User Role Selection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        .role-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .role-button {
            background-color: #C78665;
            color: whitesmoke;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-bottom: 10px;
            width: 200px;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .role-button:last-child {
            margin-bottom: 0;
        }

        .role-button:hover {
            background-color: #e9e5e5;
            color: #C78665;
        }

        .role-button:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .role-button a {
            color: whitesmoke;
            text-decoration: none;
        }

        .role-button a:hover {
            color: #C78665;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Select Your User Role</h1>
        <div class="role-buttons">
            <a href="CustomerRegistration.php" class="role-button">Customer</a>
            <a href="VendorRegistration.php" class="role-button">Vendor</a>
        </div>
    </div>
</body>
</html>
