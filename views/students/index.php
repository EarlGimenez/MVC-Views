<?php
$page_title = "Student List - MVC Views";
include dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <h1 class="section-title">Students</h1>
    <p>Manage all student records in the system.</p>
    
    <div class="action-bar">
        <a href="/students/create" class="btn">
            <span class="btn-icon-left">+</span> Add New Student
        </a>
    </div>
    
  <div class="card">
    <div class="table-responsive">
        <?php if (!empty($students)): ?>
        <table class="table">
            <thead>
                <tr>
                    <?php
                        $student = $students[0];
                        $keys = array_keys($student);
                        foreach ($keys as $key){
                            echo '<th>'. ucfirst($key) .'</th>';
                        }
                    ?>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <?php 
                        $keys = array_keys($student); 
                        foreach ($keys as $key){
                            echo '<td>'. htmlspecialchars($student[$key] ?? '').'</td>';
                        }
                    ?>
                    <td class="actions text-right">
                        <div class="action-buttons">
                            <a href="/students/<?= $student['id'] ?>" class="btn btn-sm btn-view" title="View">
                                View
                            </a>
                            <a href="/students/<?= $student['id'] ?>/edit" class="btn btn-sm btn-edit" title="Edit">
                                Edit
                            </a>
                            <form action="/students/<?= $student['id'] ?>/delete" method="POST" style="display:inline;">
                                <button type="submit" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this student?');" title="Delete">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="p-3 text-center text-muted">No students found.</div>
        <?php endif; ?>
    </div>
    
    <div class="pagination">
        <?php
        $totalPages = ceil($total / $perPage);
        for ($i = 1; $i <= $totalPages; $i++): 
            $activeClass = isset($_GET['page']) && $_GET['page'] == $i ? 'active' : '';
            if (!isset($_GET['page']) && $i == 1) $activeClass = 'active';
        ?>
            <a href="/students?page=<?= $i ?>" class="page-link <?= $activeClass ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>