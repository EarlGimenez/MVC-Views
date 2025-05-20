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

    <!-- bootstrap hehehe -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="/" class="logo">MVC Views</a>
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

    <?php if (isset($_SESSION['message']) && isset($_SESSION['message_type'])): ?>
            <div class="modal show" id="messageModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header <?= $_SESSION['message_type'] === 'success' ? 'modal-success' : 'modal-error'; ?>" style="color: #fff;">                        <h5 class="modal-title"><?php echo ucfirst($_SESSION['message_type']) ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $_SESSION['message'] ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php 
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    endif; 
    ?>


    <main class="main">
        <div class="container">