<?php
// signup view
ob_start();
?>
<div class="row justify-content-center">
  <div class="col-12 col-md-6">
    <div class="card form-card compact-form card-body">
      <h3 class="mb-3">Create your account</h3>
      <p class="muted mb-3">Get started — it's quick and free.</p>
      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger bg-danger text-white"><?php echo implode('<br>', $errors); ?></div>
      <?php endif; ?>
      <form method="post" action="">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" placeholder="Your display name" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Create a strong password" required>
        </div>
        <div class="d-grid">
          <button class="btn btn-primary btn-lg">Create Account</button>
        </div>
      </form>
      <div class="mt-3 text-center">
        <small class="muted">Already have an account? <a class="text-accent" href="/auth/login">Sign in</a></small>
      </div>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require APP_DIR . 'views/layout.php';
?>
