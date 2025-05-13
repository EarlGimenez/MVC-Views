<?php
$page_title = "Create Student - CitrusApp";
include dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <h1 class="section-title">Create Student</h1>
    
    <div class="card">
        <form action="/students" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter student username" required>
            </div>
            
            <div class="form-actions">
                <a href="/students" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn">Create Student</button>
            </div>
        </form>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>