<?php
include 'config.php';
checkAdminLogin();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_activity'])) {
    $name = trim($_POST['activity_name']);
    $desc = trim($_POST['description']);
    $date = $_POST['activity_date'];
    $location = trim($_POST['location']);
    $status = $_POST['status'];
    $admin_id = $_SESSION['admin_id'];
    $stmt = $conn->prepare("INSERT INTO activities (activity_name, description, activity_date, location, status, created_by) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $name, $desc, $date, $location, $status, $admin_id);
    if ($stmt->execute()) $message = '✅ تم إضافة النشاط!';
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM activities WHERE activity_id = $id");
    header("Location: admin_activities.php");
    exit();
}

$activities = $conn->query("SELECT a.*, u.full_name as creator FROM activities a LEFT JOIN users u ON a.created_by = u.user_id ORDER BY a.activity_date DESC");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الأنشطة - جمعية السعدي</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 2000; align-items: center; justify-content: center; }
        .modal-overlay.active { display: flex; }
        .modal-box { background: white; padding: 40px; border-radius: 20px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.2); animation: modalIn 0.3s ease; }
        @keyframes modalIn { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .modal-box h3 { color: var(--primary); margin-bottom: 15px; font-size: 22px; }
        .modal-box p { color: var(--text-light); margin-bottom: 25px; font-size: 16px; }
        .modal-actions { display: flex; gap: 10px; justify-content: center; }
        .modal-actions .btn { padding: 12px 30px; font-size: 15px; }
    </style>
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
                <li><a href="admin_activities.php" class="active"><span class="icon">🎯</span> الأنشطة</a></li>
                <li><a href="villages.php"><span class="icon">🏘️</span> القرى</a></li>
                <li><a href="admin_settings.php"><span class="icon">⚙️</span> إعدادات الموقع</a></li>
            </ul>
            <div class="sidebar-footer"><a href="admin_change_password.php"><span>🔐</span> تغيير الباسورد</a><a href="logout.php" style="margin-top: 10px; color: #ff6b6b;"><span>🚪</span> خروج</a></div>
        </aside>

        <main class="main-content">
            <div class="page-header"><h1>🎯 إدارة الأنشطة</h1></div>
            <?php if ($message): ?><div class="alert alert-success" style="margin-bottom: 20px;"><?php echo $message; ?></div><?php endif; ?>

            <div style="background: white; padding: 25px; border-radius: 12px; margin-bottom: 25px; box-shadow: var(--shadow);">
                <form method="POST" action="" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                    <div class="form-group"><label>اسم النشاط</label><input type="text" name="activity_name" required></div>
                    <div class="form-group"><label>التاريخ</label><input type="date" name="activity_date" required value="<?php echo date('Y-m-d'); ?>"></div>
                    <div class="form-group"><label>المكان</label><input type="text" name="location"></div>
                    <div class="form-group"><label>الحالة</label><select name="status"><option value="مخطط">مخطط</option><option value="منفذ">منفذ</option><option value="ملغي">ملغي</option></select></div>
                    <div class="form-group" style="grid-column: 1 / -1;"><label>الوصف</label><textarea name="description" rows="2"></textarea></div>
                    <div class="form-group"><button type="submit" name="add_activity" class="btn btn-success" style="width: 100%;">💾 حفظ</button></div>
                </form>
            </div>

            <div class="table-card">
                <div class="table-header"><h3>الأنشطة المسجلة</h3></div>
                <table class="data-table">
                    <thead><tr><th>#</th><th>النشاط</th><th>التاريخ</th><th>المكان</th><th>الحالة</th><th>إجراء</th></tr></thead>
                    <tbody>
                        <?php while($a = $activities->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $a['activity_id']; ?></td>
                            <td><strong><?php echo $a['activity_name']; ?></strong></td>
                            <td><?php echo formatDate($a['activity_date']); ?></td>
                            <td><?php echo $a['location'] ?: '-'; ?></td>
                            <td><span class="status-badge <?php echo $a['status'] == 'منفذ' ? 'status-active' : ($a['status'] == 'مخطط' ? 'status-pending' : 'status-inactive'); ?>"><?php echo $a['status']; ?></span></td>
                            <td><button type="button" class="btn btn-sm btn-danger" onclick="openDeleteModal(<?php echo $a['activity_id']; ?>)">حذف</button></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div style="font-size: 50px; margin-bottom: 15px;">⚠️</div>
            <h3>تأكيد الحذف</h3>
            <p>هل أنت متأكد من حذف هذا النشاط نهائياً؟</p>
            <div class="modal-actions">
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">نعم، احذف</a>
                <button type="button" class="btn btn-outline" onclick="closeModal()" style="border: 2px solid #ddd; color: var(--text);">إلغاء</button>
            </div>
        </div>
    </div>
    <script>
        function openDeleteModal(id) { document.getElementById('confirmDeleteBtn').href = 'admin_activities.php?delete=' + id; document.getElementById('deleteModal').classList.add('active'); }
        function closeModal() { document.getElementById('deleteModal').classList.remove('active'); }
    </script>
</body>
</html>