<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/motorist.css"/>
    <link rel="stylesheet" href="css/Core.min.css"/>
    <link rel="stylesheet" href="css/38110691971776138.css"/>
    <link rel="stylesheet" href="css/Theme-Standard.min.css"/>
    <link rel="stylesheet" href="css/signup.css"/>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="login-form" action="#" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit" name="login_btn">Login</button>
            
            <div id="error-message" class="error-message"></div>
        </form>
    </div>

    <script src="login.js"></script>
</body>
</html>
