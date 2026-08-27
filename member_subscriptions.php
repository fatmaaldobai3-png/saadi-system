<?php
include 'config.php';
checkMemberLogin();

$member_id = $_SESSION['member_id'];
$subscriptions = $conn->query("SELECT * FROM subscriptions WHERE member_id = $member_id ORDER BY subscription_year DESC");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>اشتراكاتي - جمعية السعدي</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .member-sidebar {
            width: 260px;
            background: var(--primary-dark);
            color: white;
            padding: 25px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            right: 0;
            top: 0;
        }
        .member-sidebar-brand {
            padding: 0 25px 25px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 800;
        }
        .member-sidebar-menu {
            list-style: none;
            padding: 0 15px;
        }
        .member-sidebar-menu li {
            margin-bottom: 5px;
        }
        .member-sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
        }
        .member-sidebar-menu a:hover,
        .member-sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .member-sidebar-menu .icon {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }
        .member-sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .member-sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ff6b6b;
            text-decoration: none;
            font-weight: 600;
        }
        .member-main {
            flex: 1;
            margin-right: 260px;
            padding: 30px;
            background: var(--bg);
            min-height: 100vh;
        }
        @media (max-width: 992px) {
            .member-sidebar {
                transform: translateX(100%);
                transition: 0.3s;
                z-index: 1000;
            }
            .member-sidebar.open {
                transform: translateX(0);
            }
            .member-main {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        <aside class="member-sidebar">
            <div class="member-sidebar-brand">
                <span>👤</span> حسابي
            </div>
            <ul class="member-sidebar-menu">
                <li><a href="member_dashboard.php"><span class="icon">📋</span> معلوماتي</a></li>
                <li><a href="member_subscriptions.php" class="active"><span class="icon">📅</span> اشتراكاتي</a></li>
                <li><a href="member_payments.php"><span class="icon">💳</span> مدفوعاتي</a></li>
            </ul>
            <div class="member-sidebar-footer">
                <a href="logout.php"><span>🚪</span> تسجيل الخروج</a>
            </div>
        </aside>

        <main class="member-main">
            <div class="page-header">
                <h1>📅 اشتراكاتي</h1>
                <div style="color: var(--text-light);">
                    <?php echo $_SESSION['member_name']; ?> | <?php echo date('Y/m/d'); ?>
                </div>
            </div>

            <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>السنة</th>
                            <th>المبلغ المستحق</th>
                            <th>العملة</th>
                            <th>تاريخ البدء</th>
                            <th>تاريخ الانتهاء</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($sub = $subscriptions->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $sub['subscription_year']; ?></td>
                            <td style="font-weight: 700;"><?php echo formatMoney($sub['amount']); ?></td>
                            <td><?php echo $sub['currency'] ?? 'ريال يمني'; ?></td>
                            <td><?php echo formatDate($sub['start_date']); ?></td>
                            <td><?php echo formatDate($sub['end_date']); ?></td>
                            <td>
                                <span style="padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; background: <?php echo $sub['status'] == 'نشط' ? '#d4edda' : '#f8d7da'; ?>; color: <?php echo $sub['status'] == 'نشط' ? '#155724' : '#721c24'; ?>;">
                                    <?php echo $sub['status']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>