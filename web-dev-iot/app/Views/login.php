<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet" crossorigin="anonymous"
  >
</head>
<body class="bg-light d-flex align-items-center" style="height:100vh">
  <div class="container" style="max-width:400px">
    <div class="card shadow">
      <div class="card-body">
        <h5 class="card-title text-center mb-4">Anmelden</h5>
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>
        <form method="post" action="/login">
          <div class="mb-3">
            <label for="u" class="form-label">Benutzername</label>
            <input id="u" name="username" class="form-control" required autofocus>
          </div>
          <div class="mb-3">
            <label for="p" class="form-label">Passwort</label>
            <input id="p" type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
