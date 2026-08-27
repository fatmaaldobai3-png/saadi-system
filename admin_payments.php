<?php
include 'config.php';
checkAdminLogin();

// حذف دفعة
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM payments WHERE payment_id = $id");
    header("Location: admin_payments.php");
    exit();
}

$payments = $conn->query("SELECT p.*, m.full_name, s.subscription_year FROM payments p JOIN subscriptions s ON p.subscription_id = s.subscription_id JOIN members m ON s.member_id = m.member_id ORDER BY p.payment_date DESC");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>المدفوعات - جمعية السعدي</title>
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
                <li><a href="admin_payments.php" class="active"><span class="icon">💰</span> المدفوعات</a></li>
                <li><a href="admin_activities.php"><span class="icon">🎯</span> الأنشطة</a></li>
                <li><a href="villages.php"><span class="icon">🏘️</span> القرى</a></li>
                <li><a href="admin_settings.php"><span class="icon">⚙️</span> إعدادات الموقع</a></li>
            </ul>
            <div class="sidebar-footer"><a href="admin_change_password.php"><span>🔐</span> تغيير الباسورد</a><a href="logout.php" style="margin-top: 10px; color: #ff6b6b;"><span>🚪</span> خروج</a></div>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>💰 إدارة المدفوعات</h1>
                <a href="admin_subscriptions.php" class="btn btn-success">➕ تسجيل دفعة جديدة</a>
            </div>

            <div class="table-card">
                <div class="table-header"><h3>سجل المدفوعات</h3></div>
                <table class="data-table">
                    <thead>
                        <tr><th>#</th><th>العضو</th><th>السنة</th><th>المبلغ</th><th>التاريخ</th><th>الطريقة</th><th>رقم الإيصال</th><th>إجراء</th></tr>
                    </thead>
                    <tbody>
                        <?php while($p = $payments->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $p['payment_id']; ?></td>
                            <td><strong><?php echo $p['full_name']; ?></strong></td>
                            <td><?php echo $p['subscription_year']; ?></td>
                            <td style="color: var(--primary); font-weight: 700;"><?php echo formatMoney($p['amount']); ?></td>
                            <td><?php echo formatDate($p['payment_date']); ?></td>
                            <td><?php echo $p['payment_method']; ?></td>
                            <td><?php echo $p['receipt_number'] ?: '-'; ?></td>
                            <td><button type="button" class="btn btn-sm btn-danger" onclick="openDeleteModal(<?php echo $p['payment_id']; ?>)">حذف</button></td>
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
            <p>هل أنت متأكد من حذف هذه الدفعة نهائياً؟</p>
            <div class="modal-actions">
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">نعم، احذف</a>
                <button type="button" class="btn btn-outline" onclick="closeModal()" style="border: 2px solid #ddd; color: var(--text);">إلغاء</button>
            </div>
        </div>
    </div>
    <script>
        function openDeleteModal(id) { document.getElementById('confirmDeleteBtn').href = 'admin_payments.php?delete=' + id; document.getElementById('deleteModal').classList.add('active'); }
        function closeModal() { document.getElementById('deleteModal').classList.remove('active'); }
    </script>
</body>
</html>