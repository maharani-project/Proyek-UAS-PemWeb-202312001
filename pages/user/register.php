<?php
session_start();
require '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // Default untuk yang daftar sendiri

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();

    header("Location: login.php");
    exit;
}
?>

<?php include '../../includes/header.php'; ?>
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; background-color: #fff5fb; border-radius: 1rem;">
        <h4 class="text-center mb-4" style="color: #c77dff;">Daftar Akun Baru</h4>

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
                <button class="btn btn-primary rounded-pill" style="background-color: #f78fb3; border: none;">Daftar</button>
                <a href="login.php" class="btn btn-link text-center">Sudah punya akun?</a>
            </div>
        </form>
    </div>
</div>
<?php include '../../includes/footer.php'; ?>
