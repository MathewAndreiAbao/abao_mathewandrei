<?php
// tasks dashboard view
ob_start();
$page_title = 'Task Manager';
$page_actions = '';
?>
<div class="dashboard-hero text-center mb-4">
  <h1 class="h3 mb-1">Task Manager</h1>
  <p class="muted mb-0">Add, edit, and manage your tasks efficiently.</p>
</div>

<div class="d-flex justify-content-between align-items-center mb-3 search-row">
  <form class="d-flex align-items-center" method="get" action="/tasks">
    <div class="input-group">
      <input class="form-control" name="q" value="<?php echo htmlentities($search ?? ''); ?>" placeholder="Search by borrower name...">
      <button class="btn btn-primary" type="submit">Search</button>
    </div>
  </form>

  <div>
    <?php if (!empty($_SESSION['user_id'])): ?>
      <a class="btn btn-primary" href="/tasks/create">Add Task</a>
      <a class="btn btn-outline-secondary" href="/logout">Logout</a>
    <?php endif; ?>
  </div>
</div>

<?php if (empty($tasks)): ?>
  <div class="card p-4 text-center">
    <h5 class="mb-2">No tasks yet</h5>
    <p class="text-muted">Use the "Add Task" button to create your first task.</p>
  </div>
<?php else: ?>
  <div class="card table-card">
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead class="table-light">
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Due</th>
            <th class="text-center">Status</th>
            <th>Created At</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tasks as $t): ?>
            <tr>
              <td><?php echo htmlentities($t['title']); ?></td>
              <td class="text-muted"><?php echo htmlentities(substr($t['description'] ?? '',0,80)); ?><?php echo strlen($t['description'] ?? '')>80? '...':''; ?></td>
              <td><?php echo htmlentities($t['due_date'] ?? 'N/A'); ?></td>
              <td class="text-center"><?php echo htmlentities(ucfirst($t['status'] ?? '')); ?></td>
              <td><?php echo htmlentities($t['created_at']); ?></td>
              <td class="text-end">
                <a href="/tasks/edit/<?php echo $t['id']; ?>" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                <form method="post" action="<?php echo site_url('/tasks/delete/' . $t['id']); ?>" style="display:inline-block">
                  <button class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="d-flex justify-content-center mt-4">
    <nav>
      <ul class="pagination">
      <?php if ($pagination['current_page'] > 1): ?>
        <li class="page-item"><a class="page-link" href="/tasks?page=<?php echo $pagination['current_page']-1; ?>">Previous</a></li>
      <?php endif; ?>

      <?php for ($i=1;$i<=$pagination['last_page'];$i++): ?>
        <li class="page-item <?php echo $i==$pagination['current_page']? 'active':''; ?>"><a class="page-link" href="/tasks?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
      <?php endfor; ?>

      <?php if ($pagination['current_page'] < $pagination['last_page']): ?>
        <li class="page-item"><a class="page-link" href="/tasks?page=<?php echo $pagination['current_page']+1; ?>">Next</a></li>
      <?php endif; ?>
      </ul>
    </nav>
  </div>

<?php endif; ?>

<?php
$content = ob_get_clean();
require APP_DIR . 'views/layout.php';
?>
