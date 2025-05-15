<?php
$page_title = "Dashboard - MVC Views";
include 'includes/header.php';
?>

<section class="section">
    <h1 class="section-title">Dashboard</h1>
    <p class="welcome-message">Welcome back, <span class="username"><?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>!</p>
</section>

<div class="dashboard-grid">
    <!-- Account Summary Card -->
    <div class="dashboard-card">
        <div class="card-header">
            <div class="card-icon account-icon">
                <i class="icon">👤</i>
            </div>
            <h3>Your Account</h3>
        </div>
        <div class="card-body">
            <p>This is your personal dashboard where you can manage your account and access our services.</p>
        </div>
    </div>
    
    <!-- Student Management Card -->
    <div class="dashboard-card">
        <div class="card-header">
            <div class="card-icon student-icon">
                <i class="icon">🎓</i>
            </div>
            <h3>Student Management</h3>
        </div>
        <div class="card-body">
            <p>Manage student records and information.</p>
            <div class="feature-list">
                <a href="/students" class="feature-item">
                    <span class="feature-icon">📋</span>
                    <span class="feature-text">View All Students</span>
                    <span class="feature-arrow">→</span>
                </a>
                <a href="/students/create" class="feature-item">
                    <span class="feature-icon">➕</span>
                    <span class="feature-text">Add New Student</span>
                    <span class="feature-arrow">→</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="logout-container">
    <form action="/logout" method="POST">
        <button type="submit" class="btn btn-outline">Logout</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>