<?php
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, username, password, full_name, role FROM users WHERE username = ? AND status = 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['user_id'];
            $_SESSION['admin_name'] = $user['full_name'];
            $_SESSION['admin_role'] = $user['role'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = 'كلمة المرور غير صحيحة!';
        }
    } else {
        $error = 'اسم المستخدم غير موجود!';
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - جمعية السعدي</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">
    <div class="login-box">
        <img src="logo.jpg" alt="شعار جمعية السعدي" style="width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 15px; display: block; border: 3px solid var(--secondary);">
        <h2>لوحة الإدارة</h2>
        <p>تسجيل دخول المدير فقط</p>

        <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group" style="margin-bottom: 20px; text-align: right;">
                <label>اسم المستخدم</label>
                <input type="text" name="username" required placeholder="أدخل اسم المستخدم" style="width: 100%;">
            </div>

            <div class="form-group" style="margin-bottom: 20px; text-align: right;">
                <label>كلمة المرور</label>
                <input type="password" name="password" required placeholder="أدخل كلمة المرور" style="width: 100%;">
            </div>

            <button type="submit" class="btn btn-success btn-block" style="font-size: 17px;">دخول</button>
        </form>

        <div class="login-footer">
            <p><a href="index.php">← العودة للموقع الرئيسي</a></p>
        </div>
    </div>
</body>
</html>
