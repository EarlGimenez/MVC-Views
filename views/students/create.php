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
                    $columns = array_unique($columns);
                    if (!empty($students)) {
                        $ordered = array_keys($students[0]);
                        $columns = array_merge(
                            $ordered,
                            array_diff($columns, $ordered)
                        );
                    }
                    
                    foreach ($columns as $column) {
                        echo "
                        <label for=\"".$column."\">".ucfirst($column)."</label>
                        <input type=\"text\" id=\"".$column."\" name=\"".$column."\" class=\"form-control\" placeholder=\"Enter student " . $column . "\">
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