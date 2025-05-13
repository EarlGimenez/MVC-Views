<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
    <h1>This is the homepage</h1>
    <div style="border: 3px black solid">
        <form action="/login" method="POST">
            <h3>Login</h3>
            Username<input type="text" placeholder="Username" name="username"><br>
            Password<input type="password" placeholder="Password" name="password"><br>
            <input type="submit" placeholder="submit">
        </form>
    </div>
    <div style="border: 3px black solid">
        <form action="/register" method="POST">
            <h3>Register</h3>
            Username<input type="text" placeholder="Username" name="username"><br>
            Password<input type="text" placeholder="Password" name="password"><br>
            <!-- Confirm Password<input type="text" placeholder="Confirm Password"><br> -->
            <button>Submit</button>
        </form>
    </div>
</body>
</html>