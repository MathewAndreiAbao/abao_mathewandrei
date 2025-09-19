<?php
ob_start();
$page_title = 'Edit Task';
$page_actions = '<a class="btn btn-outline-secondary" href="/tasks">Back</a>';
?>
<div class="card task-card compact-form">
  <div class="card-body">
    <?php if (!empty($errors)): ?><div class="alert alert-danger bg-danger text-white"><?php echo implode('<br>',$errors); ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('/tasks/edit/' . ($task['id'] ?? '')); ?>">
      <div class="mb-2">
        <label class="form-label">Title</label>
        <input name="title" class="form-control" value="<?php echo htmlentities($task['title']); ?>" required>
      </div>
      <div class="mb-2">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4"><?php echo htmlentities($task['description']); ?></textarea>
      </div>
      <div class="row g-4">
        <div class="col-md-4">
          <label class="form-label">Due Date</label>
          <input type="date" name="due_date" class="form-control" value="<?php echo htmlentities($task['due_date']); ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="pending" <?php echo $task['status']=='pending'?'selected':''; ?>>Pending</option>
            <option value="completed" <?php echo $task['status']=='completed'?'selected':''; ?>>Completed</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Attachment</label>
          <input type="file" name="attachment" class="form-control">
        </div>
      </div>
      <?php if (!empty($task['file_path'])): ?>
        <div class="mt-3">Current file: <a class="text-accent" href="/<?php echo $task['file_path']; ?>" target="_blank"><?php echo basename($task['file_path']); ?></a></div>
      <?php endif; ?>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Save</button>
        <a class="btn btn-outline-secondary" href="/tasks">Cancel</a>
      </div>
    </form>
  </div>
</div>
<?php
$content = ob_get_clean();
require APP_DIR . 'views/layout.php';
?>
