<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f5f7fb; }
    .card { border: 0; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,.05); }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card p-4 p-md-5">
          <h3 class="mb-1">Create account</h3>
          <p class="text-muted mb-4">Join us and get started</p>
          <div class="mb-3"><?php getErrors(); ?><?php getMessage(); ?></div>
          <form action="/register" method="POST" novalidate>
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Confirm Password</label>
              <input type="password" name="password_confirm" class="form-control" required>
            </div>
            <div class="d-grid gap-2">
              <button class="btn btn-primary" type="submit">Create account</button>
            </div>
          </form>
          <div class="mt-3 text-center">
            <small>Already have an account? <a href="/login">Sign in</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

