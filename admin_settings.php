<?php
include 'config.php';
checkAdminLogin();

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $settings = [
        'site_name'    => trim($_POST['site_name'] ?? ''),
        'site_email'   => trim($_POST['site_email'] ?? ''),
        'site_phone'   => trim($_POST['site_phone'] ?? ''),
        'site_address' => trim($_POST['site_address'] ?? '')
    ];

    foreach ($settings as $key => $value) {
        $stmt = $conn->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
        $stmt->bind_param("ss", $key, $value);
        $stmt->execute();
    }

    $message = '✅ تم حفظ الإعدادات بنجاح!';
    $message_type = 'success';
}

$site_name    = getSetting('site_name', 'جمعية السعدي الخيرية التنموية');
$site_email   = getSetting('site_email', 'info@saadi-charity.org');
$site_phone   = getSetting('site_phone', '+967-xxx-xxx-xxx');
$site_address = getSetting('site_address', 'عدن - الجمهورية اليمنية');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إعدادات الموقع - جمعية السعدي</title>
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
                <li><a href="admin_settings.php" class="active"><span class="icon">⚙️</span> إعدادات الموقع</a></li>
            </ul>
            <div class="sidebar-footer">
                <a href="admin_change_password.php"><span>🔐</span> تغيير الباسورد</a>
                <a href="logout.php" style="margin-top: 10px; color: #ff6b6b;"><span>🚪</span> خروج</a>
            </div>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>⚙️ إعدادات الموقع</h1>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>" style="margin-bottom: 20px;"><?php echo $message; ?></div>
            <?php endif; ?>

            <div style="max-width: 600px; background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow);">
                <form method="POST" action="">
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label>اسم الجمعية</label>
                        <input type="text" name="site_name" value="<?php echo htmlspecialchars($site_name); ?>" required style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; font-family: inherit;">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="site_email" value="<?php echo htmlspecialchars($site_email); ?>" required style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; font-family: inherit;">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label>رقم الجوال / الهاتف</label>
                        <input type="text" name="site_phone" value="<?php echo htmlspecialchars($site_phone); ?>" required style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; font-family: inherit;">
                    </div>

                    <div class="form-group" style="margin-bottom: 25px;">
                        <label>العنوان</label>
                        <input type="text" name="site_address" value="<?php echo htmlspecialchars($site_address); ?>" required style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; font-family: inherit;">
                    </div>

                    <button type="submit" class="btn btn-success btn-block" style="font-size: 17px; padding: 14px; background: #1e5631; color: white; border: none; border-radius: 10px; cursor: pointer; width: 100%;">💾 حفظ الإعدادات</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>