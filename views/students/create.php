<?php
$page_title = "Create Student - MVC Views";
include dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <h1 class="section-title">Create Student</h1>
    
    <div class="card">
        <form action="/students" method="POST">
            <div class="form-group">
                <label for="id">id</label>
                <input type="text" id="id" name="id" class="form-control" placeholder="Enter student id" required>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter student username" required>
                <label for="email">email</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Enter student email" required>
            </div>
            
            <div class="form-actions">
                <a href="/students" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn">Create Student</button>
            </div>
        </form>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>

<!-- $keys = array_keys($student);
foreach ($keys as $key) {
    echo "
    <label for=\"".$key."\">".$key."</label>
    <input type=\"text\" id=\"".$key."\" name=\"".$key."\" class=\"form-control\" placeholer=\"Enter student". $key ."\" required>
    ";
} -->
