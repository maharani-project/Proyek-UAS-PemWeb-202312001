<?php
session_start();
require '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif ($user['role'] === 'kasir') {
            header("Location: ../kasir/dashboard.php");
        } else {
            header("Location: dashboard.php"); // dashboard pelanggan
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<?php include '../../includes/header.php'; ?>
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; background-color: #fff5fb; border-radius: 1rem;">
        <h4 class="text-center mb-4" style="color: #c77dff;">Login MbetaRO</h4>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary rounded-pill" style="background-color: #f78fb3; border: none;">Login</button>
                <a href="register.php" class="btn btn-link text-center">Belum punya akun?</a>
            </div>
        </form>
    </div>
</div>
<?php include '../../includes/footer.php'; ?>
