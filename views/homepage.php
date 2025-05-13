<?php
$page_title = "Home - CitrusApp";
include 'includes/header.php';
?>

<section class="section">
    <h1 class="section-title">Welcome to CitrusApp</h1>
    <p>This is the homepage of our application. Please login or register to continue.</p>
</section>

<div class="form-container">
    <div class="form-card">
        <h3 class="form-title">Login</h3>
        <form action="/login" method="POST">
            <div class="form-group">
                <label for="login-username">Username</label>
                <input type="text" id="login-username" class="form-control" placeholder="Enter your username" name="username" required>
            </div>
            <div class="form-group">
                <label for="login-password">Password</label>
                <input type="password" id="login-password" class="form-control" placeholder="Enter your password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
    
    <div class="form-card">
        <h3 class="form-title">Register</h3>
        <form action="/register" method="POST">
            <div class="form-group">
                <label for="register-username">Username</label>
                <input type="text" id="register-username" class="form-control" placeholder="Choose a username" name="username" required>
            </div>
            <div class="form-group">
                <label for="register-password">Password</label>
                <input type="password" id="register-password" class="form-control" placeholder="Choose a password" name="password" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>