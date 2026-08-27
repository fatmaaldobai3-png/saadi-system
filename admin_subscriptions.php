<?php
include 'config.php';
checkAdminLogin();

$member_filter = isset($_GET['member']) ? intval($_GET['member']) : 0;

// إضافة دفعة جديدة
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_payment'])) {
    $sub_id = intval($_POST['subscription_id']);
    $amount = floatval($_POST['amount']);
    $method = $_POST['payment_method'];
    $date = $_POST['payment_date'];
    $receipt = trim($_POST['receipt_number']);
    $admin_id = $_SESSION['admin_id'];

    // جلب المبلغ المتبقي قبل الحفظ
    $paid_before = $conn->query("SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE subscription_id = $sub_id")->fetch_assoc()['total'];
    $sub_info = $conn->query("SELECT amount FROM subscriptions WHERE subscription_id = $sub_id")->fetch_assoc();
    $total_amount = $sub_info['amount'];
    $remaining_before = $total_amount - $paid_before;

    // التحقق من أن المبلغ المدفوع لا يتجاوز المتبقي
    if ($amount > $remaining_before) {
        $error_msg = "❌ المبلغ المدفوع أكبر من المبلغ المتبقي! المتبقي هو: " . formatMoney($remaining_before);
    } else {
        $stmt = $conn->prepare("INSERT INTO payments (subscription_id, payment_date, amount, payment_method, receipt_number, received_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isdssi", $sub_id, $date, $amount, $method, $receipt, $admin_id);
        if ($stmt->execute()) {
            // التحقق بعد الحفظ إذا تم السداد الكامل
            $paid_after = $paid_before + $amount;
            if ($paid_after >= $total_amount) {
                // تحديث حالة الاشتراك إلى "مدفوع"
                $conn->query("UPDATE subscriptions SET status = 'منتهي' WHERE subscription_id = $sub_id");
                $success_msg = "💰 تم استلام الدفعة بنجاح! <strong>تم سداد المبلغ المطلوب بالكامل.</strong>";
            } else {
                $success_msg = "✅ تم استلام الدفعة بنجاح! المتبقي: " . formatMoney($total_amount - $paid_after);
            }
        } else {
            $error_msg = "❌ حدث خطأ أثناء الحفظ: " . $conn->error;
        }
    }
}

// حذف اشتراك
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM subscriptions WHERE subscription_id = $id");
    header("Location: admin_subscriptions.php");
    exit();
}

// جلب الاشتراكات
$sql = "SELECT s.*, m.full_name, m.phone, m.status as member_status FROM subscriptions s JOIN members m ON s.member_id = m.member_id";
if ($member_filter) {
    $sql .= " WHERE s.member_id = $member_filter";
}
$sql .= " ORDER BY s.subscription_year DESC, m.full_name";
$subscriptions = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الاشتراكات - جمعية السعدي</title>
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
                <li><a href="admin_subscriptions.php" class="active"><span class="icon">📅</span> الاشتراكات</a></li>
                <li><a href="admin_payments.php"><span class="icon">💰</span> المدفوعات</a></li>
                <li><a href="admin_activities.php"><span class="icon">🎯</span> الأنشطة</a></li>
                <li><a href="villages.php"><span class="icon">🏘️</span> القرى</a></li>
                <li><a href="admin_settings.php"><span class="icon">⚙️</span> إعدادات الموقع</a></li>
            </ul>
            <div class="sidebar-footer"><a href="admin_change_password.php"><span>🔐</span> تغيير الباسورد</a><a href="logout.php" style="margin-top: 10px; color: #ff6b6b;"><span>🚪</span> خروج</a></div>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>📅 متابعة الاشتراكات</h1>
                <?php if ($member_filter): ?><a href="admin_subscriptions.php" class="btn btn-outline" style="border: 2px solid #ddd; color: var(--text);">عرض الكل</a><?php endif; ?>
            </div>

            <?php if (isset($success_msg)): ?>
            <div class="alert alert-success" style="margin-bottom: 20px;"><?php echo $success_msg; ?></div>
            <?php endif; ?>
            <?php if (isset($error_msg)): ?>
            <div class="alert alert-error" style="margin-bottom: 20px;"><?php echo $error_msg; ?></div>
            <?php endif; ?>

            <div style="background: white; padding: 25px; border-radius: 12px; margin-bottom: 25px; box-shadow: var(--shadow);">
                <h3 style="margin-bottom: 20px; color: var(--primary);">💳 تسجيل دفعة جديدة</h3>
                <form method="POST" action="" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; align-items: end;">
                    <div class="form-group">
                        <label>الاشتراك</label>
                        <select name="subscription_id" required>
                            <option value="">-- اختر --</option>
                            <?php 
                            $subs = $conn->query("SELECT s.subscription_id, m.full_name, s.subscription_year, s.currency FROM subscriptions s JOIN members m ON s.member_id = m.member_id WHERE s.status = 'نشط' ORDER BY m.full_name");
                            while($sub = $subs->fetch_assoc()): ?>
                            <option value="<?php echo $sub['subscription_id']; ?>"><?php echo $sub['full_name']; ?> - <?php echo $sub['subscription_year']; ?> (<?php echo $sub['currency']; ?>)</option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group"><label>المبلغ</label><input type="number" name="amount" step="0.01" required></div>
                    <div class="form-group"><label>طريقة الدفع</label><select name="payment_method" required><option value="نقدي">نقدي</option><option value="تحويل">تحويل بنكي</option></select></div>
                    <div class="form-group"><label>التاريخ</label><input type="date" name="payment_date" required value="<?php echo date('Y-m-d'); ?>"></div>
                    <div class="form-group"><label>رقم الإيصال</label><input type="text" name="receipt_number"></div>
                    <div class="form-group"><button type="submit" name="add_payment" class="btn btn-success" style="width: 100%;">💾 حفظ</button></div>
                </form>
            </div>

            <div class="table-card">
                <div class="table-header"><h3>الاشتراكات</h3></div>
                <table class="data-table">
                    <thead>
                        <tr><th>#</th><th>العضو</th><th>السنة</th><th>المبلغ المستحق</th><th>المدفوع</th><th>المتبقي</th><th>الحالة</th><th>إجراء</th></tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($sub = $subscriptions->fetch_assoc()):
                            $paid = $conn->query("SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE subscription_id = {$sub['subscription_id']}")->fetch_assoc()['total'];
                            $remaining = $sub['amount'] - $paid;
                            $currency = $sub['currency'] ?? 'ريال يمني';
                        ?>
                        <tr>
                            <td><?php echo $sub['subscription_id']; ?></td>
                            <td><strong><?php echo $sub['full_name']; ?></strong><br><small style="color: var(--text-light);"><?php echo $sub['phone']; ?></small></td>
                            <td><?php echo $sub['subscription_year']; ?></td>
                            <td><?php echo formatMoney($sub['amount']) . ' ' . $currency; ?></td>
                            <td style="color: var(--primary); font-weight: 700;"><?php echo formatMoney($paid) . ' ' . $currency; ?></td>
                            <td style="color: <?php echo $remaining > 0 ? '#e74c3c' : '#27ae60'; ?>; font-weight: 700;">
                                <?php echo $remaining > 0 ? formatMoney($remaining) . ' ' . $currency : '<span style="color:#27ae60;">تم السداد ✔</span>'; ?>
                            </td>
                            <td>
                                <span class="status-badge <?php echo $sub['status'] == 'منتهي' ? 'status-active' : ($sub['status'] == 'نشط' ? 'status-pending' : 'status-inactive'); ?>">
                                    <?php echo $sub['status'] == 'منتهي' ? 'تم السداد ✔' : $sub['status']; ?>
                                </span>
                            </td>
                            <td><button type="button" class="btn btn-sm btn-danger" onclick="openDeleteModal(<?php echo $sub['subscription_id']; ?>)">حذف</button></td>
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
            <p>هل أنت متأكد من حذف هذا الاشتراك نهائياً؟</p>
            <div class="modal-actions">
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">نعم، احذف</a>
                <button type="button" class="btn btn-outline" onclick="closeModal()" style="border: 2px solid #ddd; color: var(--text);">إلغاء</button>
            </div>
        </div>
    </div>
    <script>
        function openDeleteModal(id) { document.getElementById('confirmDeleteBtn').href = 'admin_subscriptions.php?delete=' + id; document.getElementById('deleteModal').classList.add('active'); }
        function closeModal() { document.getElementById('deleteModal').classList.remove('active'); }
    </script>
</body>
</html>