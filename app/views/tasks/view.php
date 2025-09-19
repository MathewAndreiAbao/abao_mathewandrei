<?php
ob_start();
$page_title = $task['title'] ?? 'Task';
$page_actions = '<a class="btn btn-outline-secondary" href="/tasks">Back</a>';
?>
<div class="card task-card compact-form">
  <div class="card-body">
    <h3 class="mb-2 task-title"><?php echo htmlentities($task['title']); ?></h3>
    <div class="muted mb-3">Due: <?php echo htmlentities($task['due_date']); ?> · Status: <?php echo htmlentities($task['status']); ?></div>
    <div class="mb-4"><?php echo nl2br(htmlentities($task['description'])); ?></div>
    <?php if (!empty($task['file_path'])): ?>
      <div class="mb-3">Attachment: <a class="text-accent" href="/<?php echo $task['file_path']; ?>" target="_blank"><?php echo basename($task['file_path']); ?></a></div>
    <?php endif; ?>
    <div class="d-flex gap-2">
      <a class="btn btn-outline-primary" href="/tasks/edit/<?php echo $task['id']; ?>">Edit</a>
      <form method="post" action="<?php echo site_url('/tasks/delete/' . $task['id']); ?>" style="display:inline-block">
        <button class="btn btn-outline-danger">Delete</button>
      </form>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require APP_DIR . 'views/layout.php';
?>
