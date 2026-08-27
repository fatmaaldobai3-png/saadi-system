<?php
include 'config.php';
checkAdminLogin();

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    // جلب الباسورد الحالي
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['admin_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!password_verify($current, $user['password'])) {
        $message = '❌ كلمة المرور الحالية غير صحيحة!';
        $message_type = 'error';
    } elseif ($new !== $confirm) {
        $message = '❌ كلمة المرور الجديدة غير متطابقة!';
        $message_type = 'error';
    } elseif (strlen($new) < 6) {
        $message = '❌ كلمة المرور يجب أن تكون 6 أحرف على الأقل!';
        $message_type = 'error';
    } else {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $update->bind_param("si", $hashed, $_SESSION['admin_id']);
        if ($update->execute()) {
            $message = '✅ تم تغيير كلمة المرور بنجاح!';
            $message_type = 'success';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تغيير الباسورد - جمعية السعدي</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-layout">
                        <aside class="sidebar">
            <div class="sidebar-brand"><span>🕌</span> جمعية السعدي</div>
            <ul class="sidebar-menu">
                <li><a href="dashboard.php"><span class="icon">📊</span> لوحة التحكم</a></li>
                <li><a href="admin_members.php"><span class="icon">👥</span> الأعضاء</a></li>
                <li><a href="admin_subscriptions.php"><span class="icon">📅</span> الاشتراكات</a></li>
                <li><a href="admin_payments.php"><span class="icon">💰</span> المدفوعات</a></li>
                <li><a href="admin_activities.php"><span class="icon">🎯</span> الأنشطة</a></li>
                <li><a href="villages.php"><span class="icon">🏘️</span> القرى</a></li>
                <li><a href="admin_settings.php"><span class="icon">⚙️</span> إعدادات الموقع</a></li>
            </ul>
            <div class="sidebar-footer">
                <a href="admin_change_password.php" class="active"><span>🔐</span> تغيير الباسورد</a>
                <a href="logout.php" style="margin-top: 10px; color: #ff6b6b;"><span>🚪</span> خروج</a>
            </div>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>🔐 تغيير كلمة المرور</h1>
            </div>

            <div style="max-width: 500px; background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow); margin: 0 auto;">
                <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>" style="margin-bottom: 25px;"><?php echo $message; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label>كلمة المرور الحالية</label>
                        <input type="password" name="current_password" required placeholder="أدخل الباسورد القديم" style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px;">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label>كلمة المرور الجديدة</label>
                        <input type="password" name="new_password" required placeholder="أدخل الباسورد الجديد" style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px;">
                    </div>

                    <div class="form-group" style="margin-bottom: 25px;">
                        <label>تأكيد كلمة المرور الجديدة</label>
                        <input type="password" name="confirm_password" required placeholder="أعد كتابة الباسورد الجديد" style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px;">
                    </div>

                    <button type="submit" class="btn btn-success btn-block" style="font-size: 17px; padding: 14px; background: #1e5631; color: white; border: none; border-radius: 10px; cursor: pointer; width: 100%;">💾 حفظ التغييرات</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
