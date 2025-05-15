<?php
$page_title = "Student Details - MVC Views";
include dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <h1 class="section-title">Student Details</h1>
    
    <div class="card">

        <?php
            $keys = array_keys($student);
            foreach ($keys as $key) {
                echo "
                <div class=\"detail-item\">
                <strong>".$key.":</strong> 
                <span>".htmlspecialchars($student[$key])."</span>
                </div>
                ";
            }
        ?>
        
        <div class="action-buttons" style="margin-top: 1.5rem;">
            <a href="/students" class="btn btn-outline">Back to List</a>
            <a href="/students/<?= $student['id'] ?>/edit" class="btn">Edit Student</a>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>

