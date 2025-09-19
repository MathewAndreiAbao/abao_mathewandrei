<?php
ob_start();
$page_title = 'Create Task';
$page_actions = '<a class="btn btn-outline-secondary" href="/tasks">Back</a>';
?>
<div class="card task-card compact-form">
  <div class="card-body">
    <?php if (!empty($errors)): ?><div class="alert alert-danger bg-danger text-white"><?php echo implode('<br>',$errors); ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" action="">
      <div class="mb-2">
        <label class="form-label">Title</label>
        <input name="title" class="form-control" required>
      </div>
      <div class="mb-2">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4"></textarea>
      </div>
      <div class="row g-4">
        <div class="col-md-4">
          <label class="form-label">Due Date</label>
          <input type="date" name="due_date" class="form-control">
        </div>
        <div class="col-md-4">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Attachment</label>
          <input type="file" name="attachment" class="form-control">
          <small class="muted">PDF, JPG, PNG — max 5MB</small>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">Create</button>
        <a class="btn btn-outline-secondary" href="/tasks">Cancel</a>
      </div>
    </form>
  </div>
</div>
<?php
$content = ob_get_clean();
require APP_DIR . 'views/layout.php';
?>
