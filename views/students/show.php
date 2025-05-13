<?php
$page_title = "Student Details - CitrusApp";
include dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <h1 class="section-title">Student Details</h1>
    
    <div class="card">
        <div class="detail-item">
            <strong>ID:</strong> 
            <span><?= htmlspecialchars($student['id']) ?></span>
        </div>
        <div class="detail-item">
            <strong>Username:</strong> 
            <span><?= htmlspecialchars($student['username']) ?></span>
        </div>
        
        <div class="action-buttons" style="margin-top: 1.5rem;">
            <a href="/students" class="btn btn-outline">Back to List</a>
            <a href="/students/<?= $student['id'] ?>/edit" class="btn">Edit Student</a>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>