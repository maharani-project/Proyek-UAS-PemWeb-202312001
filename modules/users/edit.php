<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $conn->query("UPDATE users SET username='$username', email='$email', password='$password', role='$role' WHERE id=$id");
    } else {
        $conn->query("UPDATE users SET username='$username', email='$email', role='$role' WHERE id=$id");
    }

    header("Location: index.php");
}
?>

<div class="container mt-5">
    <h3 class="mb-3 text-soft-purple">Edit Pengguna</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>">
        </div>
        <div class="mb-3">
            <label>Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="kasir" <?= $data['role'] === 'kasir' ? 'selected' : '' ?>>Kasir</option>
                <option value="user" <?= $data['role'] === 'user' ? 'selected' : '' ?>>User</option>
            </select>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
