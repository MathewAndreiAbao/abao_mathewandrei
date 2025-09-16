<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f5f7fb; }
    .card { border: 0; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,.05); }
    .avatar { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; }
  </style>
</head>
<body>
  <nav class="navbar navbar-light bg-white border-bottom">
    <div class="container">
      <a class="navbar-brand" href="/profile">User System</a>
      <form class="d-inline" action="/logout" method="POST">
        <button class="btn btn-outline-danger btn-sm">Logout</button>
      </form>
    </div>
  </nav>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="mb-3"><?php getErrors(); ?><?php getMessage(); ?></div>
        <div class="card p-4 p-md-5 mb-4">
          <div class="d-flex align-items-center gap-3">
            <?php 
              $avatar = !empty($user['avatar']) 
                ? (BASE_URL . $user['avatar']) 
                : (BASE_URL . PUBLIC_DIR . '/default-avatar.svg');
            ?>
            <img src="<?= htmlspecialchars($avatar); ?>" class="avatar" alt="Avatar">
            <div>
              <h4 class="mb-1">Hello, <?= htmlspecialchars($user['name']); ?></h4>
              <div class="text-muted"><?= htmlspecialchars($user['email']); ?></div>
            </div>
          </div>
          <form action="/profile/avatar" method="POST" enctype="multipart/form-data" class="mt-3">
            <div class="input-group">
              <input class="form-control" type="file" name="avatar" accept="image/*" required>
              <button class="btn btn-outline-primary" type="submit">Upload new photo</button>
            </div>
          </form>
        </div>

        <div class="card p-4 p-md-5">
          <h5 class="mb-3">Edit profile</h5>
          <form action="/profile/update" method="POST">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']); ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
              </div>
            </div>
            <div class="mt-3">
              <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

