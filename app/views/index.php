<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loan Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f6f9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
    .card { border: none; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    .avatar { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd; }
    .profile-card { background: white; padding: 20px; margin-bottom: 30px; }
    .table thead { background-color: #0d6efd; color: white; }
    .btn-custom { border-radius: 8px; }
  </style>
</head>
<body>
  <div class="container py-5">
    <!-- Profile Section with Upload/Modify Picture and Logout -->
    <div class="profile-card">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Your Profile</h4>
        <form action="/logout" method="POST">
          <button class="btn btn-outline-danger btn-custom" type="submit">Logout</button>
        </form>
      </div>
      <div class="d-flex align-items-center gap-3">
        <img src="<?= htmlspecialchars($user['avatar'] ? BASE_URL . $user['avatar'] : BASE_URL . '/default-avatar.svg'); ?>" class="avatar" alt="Avatar">
        <div>
          <h5><?= htmlspecialchars($user['name']); ?></h5>
          <p class="text-muted"><?= htmlspecialchars($user['email']); ?></p>
        </div>
      </div>
      <form action="/profile/avatar" method="POST" enctype="multipart/form-data" class="mt-3">
        <div class="input-group">
          <input type="file" name="avatar" class="form-control" accept="image/*" required>
          <button class="btn btn-outline-primary btn-custom" type="submit">Upload/Modify Picture</button>
        </div>
      </form>
    </div>

    <!-- Messages -->
    <div class="mb-3"><?php getErrors(); ?><?php getMessage(); ?></div>

    <!-- Loan Management -->
    <h2 class="text-center mb-4">Loan Management</h2>
    <div class="d-flex justify-content-end mb-3">
      <button class="btn btn-primary btn-custom" data-bs-toggle="modal" data-bs-target="#addModal">Add Loan</button>
    </div>
    <div class="card">
      <div class="card-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Borrower Name</th>
              <th>Loan Amount</th>
              <th>Interest Rate (%)</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($loans)): ?>
              <?php foreach ($loans as $loan): ?>
                <tr>
                  <td><?= htmlspecialchars($loan['borrower_name']); ?></td>
                  <td>₱<?= number_format($loan['loan_amount'], 2); ?></td>
                  <td><?= htmlspecialchars($loan['interest_rate']); ?></td>
                  <td><?= htmlspecialchars($loan['created_at']); ?></td>
                  <td><?= htmlspecialchars($loan['updated_at']); ?></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $loan['id']; ?>">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $loan['id']; ?>">Delete</button>
                  </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal<?= $loan['id']; ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit Loan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <form action="/update-loan/<?= $loan['id']; ?>" method="POST">
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">Borrower Name</label>
                            <input type="text" name="borrower_name" class="form-control" value="<?= htmlspecialchars($loan['borrower_name']); ?>" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Loan Amount</label>
                            <input type="number" name="loan_amount" class="form-control" value="<?= $loan['loan_amount']; ?>" step="0.01" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Interest Rate (%)</label>
                            <input type="number" name="interest_rate" class="form-control" value="<?= $loan['interest_rate']; ?>" step="0.01" required>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Update</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal<?= $loan['id']; ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Delete Loan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <p>Are you sure you want to delete this loan?</p>
                      </div>
                      <div class="modal-footer">
                        <form action="/delete-loan/<?= $loan['id']; ?>" method="POST">
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted">No loans found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Add Loan Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Loan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="/create-loan" method="POST">
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Borrower Name</label>
                <input type="text" name="borrower_name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Loan Amount</label>
                <input type="number" name="loan_amount" class="form-control" step="0.01" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Interest Rate (%)</label>
                <input type="number" name="interest_rate" class="form-control" step="0.01" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Add</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
