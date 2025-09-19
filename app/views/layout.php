<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/app.css">
    <script>
      // Theme toggle removed - app uses single minimalist light theme
    </script>
</head>
<body>
<?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } ?>
<!-- header removed as requested -->

<main class="container app-container py-4" role="main">
  <div class="dashboard-wrapper">
  <?php if (!empty($_SESSION['flash_success'])): ?>
    <div class="alert alert-success bg-success text-white border-0"><?php echo $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?></div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['flash_error'])): ?>
    <div class="alert alert-danger bg-danger text-white border-0"><?php echo $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></div>
  <?php endif; ?>

    <?php echo isset($content) ? $content : ''; ?>
  </div>
  </main>

<footer class="py-3">
  <div class="container text-center muted small">
    <?php echo $footer_pagination ?? ''; ?>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
