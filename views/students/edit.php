<?php
$page_title = "Edit Student - MVC Views";
include dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <h1 class="section-title">Edit Student</h1>
    
    <div class="card">
        <form action="/students/<?= $student['id'] ?>/update" method="POST">
            
            <div class="form-group">
                <?php 
                    $keys = array_keys($student);
                    foreach ($keys as $key) {
                        echo "
                        <label for=\"".$key."\">".ucfirst($key)."</label>
                        <input type=\"text\" id=\"".$key."\" name=\"".$key."\" class=\"form-control\" value=\"". htmlspecialchars($student[$key] ?? '')."\">
                        ";
                    }
                ?>
            </div>
            
            <div class="form-actions">
                <a href="/students" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn">Update Student</button>
            </div>
        </form>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>