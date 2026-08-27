<?php
include 'config.php';
checkAdminLogin();

// إحصائيات
$stats = [
    'members' => $conn->query("SELECT COUNT(*) as c FROM members")->fetch_assoc()['c'],
    'active_members' => $conn->query("SELECT COUNT(*) as c FROM members WHERE status = 'فعال'")->fetch_assoc()['c'],
    'villages' => $conn->query("SELECT COUNT(*) as c FROM villages")->fetch_assoc()['c'],
    'activities' => $conn->query("SELECT COUNT(*) as c FROM activities")->fetch_assoc()['c'],
    'subscriptions' => $conn->query("SELECT COUNT(*) as c FROM subscriptions WHERE status = 'نشط'")->fetch_assoc()['c'],
    'payments_total' => $conn->query("SELECT COALESCE(SUM(amount), 0) as total FROM payments")->fetch_assoc()['total'],
    'pending_payments' => $conn->query("SELECT COUNT(*) as c FROM subscriptions s LEFT JOIN payments p ON s.subscription_id = p.subscription_id WHERE s.status = 'نشط' AND p.payment_id IS NULL")->fetch_assoc()['c']
];

// آخر الأعضاء
$latest_members = $conn->query("SELECT m.*, v.village_name FROM members m LEFT JOIN villages v ON m.village_id = v.village_id ORDER BY m.created_at DESC LIMIT 5");

// آخر المدفوعات
$latest_payments = $conn->query("SELECT p.*, m.full_name, s.subscription_year FROM payments p JOIN subscriptions s ON p.subscription_id = s.subscription_id JOIN members m ON s.member_id = m.member_id ORDER BY p.payment_date DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم - جمعية السعدي</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-layout">
        <!-- Sidebar -->
                                <aside class="sidebar">
            <div class="sidebar-brand"><span>🕌</span> جمعية السعدي</div>
            <ul class="sidebar-menu">
                <li><a href="dashboard.php" class="active"><span class="icon">📊</span> لوحة التحكم</a></li>
                <li><a href="admin_members.php"><span class="icon">👥</span> الأعضاء</a></li>
                <li><a href="admin_subscriptions.php"><span class="icon">📅</span> الاشتراكات</a></li>
                <li><a href="admin_payments.php"><span class="icon">💰</span> المدفوعات</a></li>
                <li><a href="admin_activities.php"><span class="icon">🎯</span> الأنشطة</a></li>
                <li><a href="villages.php"><span class="icon">🏘️</span> القرى</a></li>
                <li><a href="admin_settings.php"><span class="icon">⚙️</span> إعدادات الموقع</a></li>
            </ul>
            <div class="sidebar-footer">
                <a href="admin_change_password.php"><span>🔐</span> تغيير الباسورد</a>
                <a href="logout.php" style="margin-top: 10px; color: #ff6b6b;"><span>🚪</span> خروج</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1>لوحة التحكم</h1>
                <div style="color: var(--text-light);">
                    👤 <?php echo $_SESSION['admin_name']; ?> | <?php echo date('Y/m/d'); ?>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="dash-stats">
                <div class="dash-card">
                    <div class="dash-card-icon blue">👥</div>
                    <div class="dash-card-info">
                        <h3><?php echo $stats['members']; ?></h3>
                        <p>إجمالي الأعضاء</p>
                    </div>
                </div>
                <div class="dash-card">
                    <div class="dash-card-icon green">✅</div>
                    <div class="dash-card-info">
                        <h3><?php echo $stats['active_members']; ?></h3>
                        <p>الأعضاء الفعالين</p>
                    </div>
                </div>
                <div class="dash-card">
                    <div class="dash-card-icon orange">📅</div>
                    <div class="dash-card-info">
                        <h3><?php echo $stats['subscriptions']; ?></h3>
                        <p>اشتراكات نشطة</p>
                    </div>
                </div>
                <div class="dash-card">
                    <div class="dash-card-icon purple">💰</div>
                    <div class="dash-card-info">
                        <h3><?php echo formatMoney($stats['payments_total']); ?></h3>
                        <p>إجمالي المدفوعات</p>
                    </div>
                </div>
            </div>

            <!-- Pending Payments Alert -->
            <?php if ($stats['pending_payments'] > 0): ?>
            <div class="alert alert-info" style="margin-bottom: 25px;">
                ⚠️ يوجد <?php echo $stats['pending_payments']; ?> اشتراك لم تسدد بعد. <a href="admin_subscriptions.php" style="color: var(--primary); font-weight: 700;">عرض التفاصيل</a>
            </div>
            <?php endif; ?>

            <!-- Latest Members -->
            <div class="table-card" style="margin-bottom: 30px;">
                <div class="table-header">
                    <h3>📋 آخر الأعضاء المسجلين</h3>
                    <a href="admin_members.php" class="btn btn-sm btn-success">عرض الكل</a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الجوال</th>
                            <th>القرية</th>
                            <th>الحالة</th>
                            <th>تاريخ التسجيل</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($m = $latest_members->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $m['member_id']; ?></td>
                            <td><strong><?php echo $m['full_name']; ?></strong></td>
                            <td><?php echo $m['phone']; ?></td>
                            <td><?php echo $m['village_name'] ?: '-'; ?></td>
                            <td>
                                <span class="status-badge <?php echo $m['status'] == 'فعال' ? 'status-active' : 'status-inactive'; ?>">
                                    <?php echo $m['status']; ?>
                                </span>
                            </td>
                            <td><?php echo formatDate($m['created_at']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Latest Payments -->
            <div class="table-card">
                <div class="table-header">
                    <h3>💳 آخر المدفوعات</h3>
                    <a href="admin_payments.php" class="btn btn-sm btn-success">عرض الكل</a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العضو</th>
                            <th>السنة</th>
                            <th>المبلغ</th>
                            <th>التاريخ</th>
                            <th>طريقة الدفع</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($p = $latest_payments->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $p['payment_id']; ?></td>
                            <td><strong><?php echo $p['full_name']; ?></strong></td>
                            <td><?php echo $p['subscription_year']; ?></td>
                            <td style="color: var(--primary); font-weight: 700;"><?php echo formatMoney($p['amount']); ?></td>
                            <td><?php echo formatDate($p['payment_date']); ?></td>
                            <td><?php echo $p['payment_method']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
