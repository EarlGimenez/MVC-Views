<?php
// Determine current page for active nav link
$current_page = basename($_SERVER['PHP_SELF']);
$current_dir = basename(dirname($_SERVER['PHP_SELF']));

// Check if we're in the students directory
$is_student_page = ($current_dir === 'students');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'CitrusApp'; ?></title>
    <!-- Adjust the path based on your folder structure -->
    <link rel="stylesheet" href="/views/assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="/" class="logo">CitrusApp</a>
                <div class="menu-toggle" id="menuToggle">☰</div>
                <ul class="nav-links" id="navLinks">
                    <li><a href="/" class="<?php echo $current_page == 'homepage.php' ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="/services" class="<?php echo $current_page == 'services.php' ? 'active' : ''; ?>">Services</a></li>
                    <li><a href="/about-us" class="<?php echo $current_page == 'about-us.php' ? 'active' : ''; ?>">About Us</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="/dashboard" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="/students" class="<?php echo $is_student_page ? 'active' : ''; ?>">Students</a></li>
                    <li>
                        <form action="/logout" method="POST">
                            <button type="submit" class="btn btn-outline">Logout</button>
                        </form>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main">
        <div class="container">