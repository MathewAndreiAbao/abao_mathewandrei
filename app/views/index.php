Here is the complete previous version of `app/views/index.php` as it was before commit `72d295ef335d573f1cb2398a5ba639922dc2ede7`.  
You can copy and replace your current file contents with this to restore the last version and remove all new/modified lines.

```php
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Loan Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }
    .page-header {
      margin-bottom: 30px;
    }
    .card {
      border: none;
      border-radius: 12px;
    }
    .table thead {
      background-color: #0d6efd;
      color: #fff;
    }
    .table {
      table-layout: fixed;
      width: 100%;
    }
    .table th:nth-child(1), .table td:nth-child(1) { width: 20%; }
    .table th:nth-child(2), .table td:nth-child(2) { width: 20%; }
    .table th:nth-child(3), .table td:nth-child(3) { width: 15%; }
    .table th:nth-child(4), .table td:nth-child(4) { width: 20%; }
    .table th:nth-child(5), .table td:nth-child(5) { width: 20%; }
    .table th:nth-child(6), .table td:nth-child(6) { width: 25%; }
    .btn-custom {
      border-radius: 8px;
      font-weight: 500;
    }
    .modal-content {
      border-radius: 12px;
    }
    .modal-header {
      border-bottom: none;
    }
    .modal-footer {
      border-top: none;
    }
  </style>
</head>
<body>

  <div class="container py-5">

    <div class="page-header text-center">
      <h2 class="fw-bold text-dark">Loan Management</h2>
      <p class="text-muted">Add, edit, and manage your loan records efficiently.</p>
    </div>

    <div class="mb-3">
      <?php getErrors(); ?>
      <?php getMessage(); ?>
    </div>

    <div class="d-flex justify-content-between mb-3">
      <div class="input-group w-50">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by borrower name...">
        <button id="searchButton" class="btn btn-primary btn-custom shadow-sm" type="button">Search</button>
      </div>
      <button class="btn btn-primary btn-custom shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
        Add Loan
      </button>
    </div>

    <div class="card shadow-sm">
      <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0 text-center">
          <thead>
            <tr>
              <th>Borrower Name</th>
              <th>Loan Amount</th>
              <th>Interest Rate</th>
              <th>Date Created</th>
              <th>Last Updated</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($loans)): ?>
              <?php foreach ($loans as $loan): ?>
                <tr class="data-row">
                  <td><?= htmlspecialchars($loan['borrower_name']); ?></td>
                  <td>₱<?= number_format($loan['loan_amount'], 2); ?></td>
                  <td><?= htmlspecialchars($loan['interest_rate']); ?>%</td>
                  <td><?= htmlspecialchars($loan['created_at']); ?></td>
                  <td><?= htmlspecialchars($loan['updated_at']); ?></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editModal<?= $loan['id']; ?>">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $loan['id']; ?>">Delete</button>
                  </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal<?= $loan['id']; ?>" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <form action="/update-loan/<?= $loan['id']; ?>" method="POST">
                        <div class="modal-header bg-primary text-white rounded-top">
                          <h5 class="modal-title">Edit Loan</h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" name="id" value="<?= $loan['id']; ?>">
                          <div class="mb-3">
                            <label class="form-label">Borrower Name</label>
                            <input type="text" name="borrower_name" class="form-control" value="<?= htmlspecialchars($loan['borrower_name']); ?>" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Loan Amount</label>
                            <input type="number" name="loan_amount" class="form-control" value="<?= htmlspecialchars($loan['loan_amount']); ?>" step="0.01" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Interest Rate (%)</label>
                            <input type="number" name="interest_rate" class="form-control" value="<?= htmlspecialchars($loan['interest_rate']); ?>" step="0.01" required>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary btn-custom">Update</button>
                          <button type="button" class="btn btn-light btn-custom" data-bs-dismiss="modal">Cancel</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal<?= $loan['id']; ?>" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <form action="/delete-loan/<?= $loan['id']; ?>" method="POST">
                        <div class="modal-header bg-danger text-white rounded-top">
                          <h5 class="modal-title">Delete Loan</h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <p>Are you sure you want to delete the loan for <strong><?= htmlspecialchars($loan['borrower_name']); ?></strong>?</p>
                          <input type="hidden" name="id" value="<?= $loan['id']; ?>">
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-danger btn-custom">Delete</button>
                          <button type="button" class="btn btn-light btn-custom" data-bs-dismiss="modal">Cancel</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <tr class="no-results">
                <td colspan="6" class="text-muted">No loans found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div id="pagination" class="d-flex justify-content-center mt-3"></div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BASE_URL; ?>/public/js/alert.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const rowsPerPage = 6;
      const maxPages = 10;
      const allRows = document.querySelectorAll('.data-row');
      const noResults = document.querySelector('.no-results');
      const searchInput = document.getElementById('searchInput');
      const pagination = document.getElementById('pagination');
      let matchingRows = [];
      let currentPage = 1;

      function updateTable() {
        const filter = searchInput.value.toLowerCase();
        matchingRows = [];
        allRows.forEach(row => {
          const name = row.cells[0].textContent.toLowerCase();
          if (name.includes(filter)) {
            matchingRows.push(row);
          }
          row.style.display = 'none';
        });

        if (matchingRows.length === 0) {
          if (noResults) noResults.style.display = '';
        } else {
          if (noResults) noResults.style.display = 'none';
        }

        buildPagination();
        showPage(1);
      }

      function showPage(page) {
        currentPage = page;
        const start = (page - 1) * rowsPerPage;
        const end = Math.min(start + rowsPerPage, matchingRows.length);
        matchingRows.forEach((row, index) => {
          row.style.display = (index >= start && index < end) ? '' : 'none';
        });

        pagination.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
        const activeBtn = pagination.querySelector(`button[data-page="${page}"]`);
        if (activeBtn) activeBtn.classList.add('active');

        const prevBtn = pagination.querySelector('button:first-child');
        const nextBtn = pagination.querySelector('button:last-child');
        if (prevBtn) prevBtn.disabled = currentPage === 1;
        if (nextBtn) nextBtn.disabled = currentPage === Math.min(Math.ceil(matchingRows.length / rowsPerPage), maxPages);
      }

      function buildPagination() {
        const pageCount = Math.min(Math.ceil(matchingRows.length / rowsPerPage), maxPages);
        pagination.innerHTML = '';

        const prevBtn = document.createElement('button');
        prevBtn.classList.add('btn', 'btn-outline-primary', 'mx-1');
        prevBtn.textContent = 'Previous';
        prevBtn.disabled = currentPage === 1;
        prevBtn.addEventListener('click', () => {
          if (currentPage > 1) showPage(currentPage - 1);
        });
        pagination.appendChild(prevBtn);

        for (let i = 1; i <= pageCount; i++) {
          const btn = document.createElement('button');
          btn.classList.add('btn', 'btn-outline-primary', 'mx-1');
          btn.textContent = i;
          btn.dataset.page = i;
          if (i === currentPage) btn.classList.add('active');
          btn.addEventListener('click', () => showPage(i));
          pagination.appendChild(btn);
        }

        const nextBtn = document.createElement('button');
        nextBtn.classList.add('btn', 'btn-outline-primary', 'mx-1');
        nextBtn.textContent = 'Next';
        nextBtn.disabled = currentPage === pageCount;
        nextBtn.addEventListener('click', () => {
          if (currentPage < pageCount) showPage(currentPage + 1);
        });
        pagination.appendChild(nextBtn);
      }

      updateTable();

      const searchButton = document.getElementById('searchButton');
      searchButton.addEventListener('click', updateTable);
    });
  </script>
</body>
</html>
```

Let me know if you need a commit message, help with restoring via Git, or want this applied to a different file!
