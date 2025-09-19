<?php
// login view
ob_start();
?>
<div class="row justify-content-center">
  <div class="col-12 col-md-6">
       <div class="card form-card compact-form card-body">
      <h3 class="mb-3">Welcome back</h3>
      <p class="muted mb-3">Sign in to manage your tasks</p>
      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger bg-danger text-white"><?php echo implode('<br>', $errors); ?></div>
      <?php endif; ?>
      <form method="post" action="">
        <div class="mb-3">
          <label class="form-label">Email</label>
           <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
           <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <div class="d-grid">
          <button class="btn btn-primary btn-lg">Sign in</button>
        </div>
      </form>
      <div class="mt-3 text-center">
        <small class="muted">Don't have an account? <a class="text-accent" href="/auth/signup">Sign up</a></small>
      </div>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require APP_DIR . 'views/layout.php';
?>
