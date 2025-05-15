<?php
$page_title = "Create Student - MVC Views";
include dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <h1 class="section-title">Create Student</h1>
    
    <div class="card">
        <form action="/students" method="POST">
            <div class="form-group">
                <?php
                    foreach ($columns as $column) {
                        echo "
                        <label for=\"".$column."\">".$column."</label>
                        <input type=\"text\" id=\"".$column."\" name=\"".$column."\" class=\"form-control\" placeholer=\"Enter student". $column ."\" required>
                        ";
                    }
                ?>
            </div>
            
            <div class="form-actions">
                <a href="/students" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn">Create Student</button>
            </div>
        </form>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>


