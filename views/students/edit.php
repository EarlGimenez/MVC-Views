<?php
$page_title = "Edit Student - CitrusApp";
include dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <h1 class="section-title">Edit Student</h1>
    
    <div class="card">
        <form action="/students/<?= $student['id'] ?>/update" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($student['username']) ?>" required>
            </div>
            
            <div class="form-actions">
                <a href="/students" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn">Update Student</button>
            </div>
        </form>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>