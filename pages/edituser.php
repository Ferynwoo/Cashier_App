<?php
session_start();
require '../config/db.php'; // Koneksi ke database

// Pastikan user sudah login
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// Ambil data user yang login
$user_id = $_SESSION['role'];

// Query untuk mendapatkan informasi pengguna
$stmt = mysqli_prepare($koneksi, "SELECT username FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    $error = "User tidak ditemukan.";
    $user = null; // Pastikan $user null jika data tidak ada
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (empty($new_username) || empty($new_password) || empty($confirm_password)) {
        $error = "Semua kolom harus diisi.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok.";
    } else {
        // Cek apakah username sudah digunakan oleh user lain
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM users WHERE username = ? AND id != ?");
        mysqli_stmt_bind_param($stmt, 'si', $new_username, $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $existingUser = mysqli_fetch_assoc($result);

        if ($existingUser) {
            $error = "Username sudah digunakan.";
        } else {
            // Update username dan password
            $stmt = mysqli_prepare($koneksi, "UPDATE users SET username = ?, password = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'ssi', $new_username, $new_password, $user_id);
            $execute = mysqli_stmt_execute($stmt);

            if ($execute) {
                echo "Profil berhasil diperbarui!";
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Gagal memperbarui profil.";
            }
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>
    <h2>Edit Profile</h2>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form action="edit_profile.php" method="POST">
        <div>
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($users['username']); ?>" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required>
        </div>
        <button type="submit">Update Profile</button>
    </form>
</body>
</html>
