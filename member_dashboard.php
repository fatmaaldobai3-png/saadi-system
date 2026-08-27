<?php
include 'config.php';
checkMemberLogin();

$member_id = $_SESSION['member_id'];

// معلومات العضو
$member = $conn->query("SELECT m.*, v.village_name FROM members m LEFT JOIN villages v ON m.village_id = v.village_id WHERE m.member_id = $member_id")->fetch_assoc();

// الاشتراكات
$subscriptions = $conn->query("SELECT * FROM subscriptions WHERE member_id = $member_id ORDER BY subscription_year DESC");

// المدفوعات
$payments = $conn->query("SELECT p.*, s.subscription_year FROM payments p JOIN subscriptions s ON p.subscription_id = s.subscription_id WHERE s.member_id = $member_id ORDER BY p.payment_date DESC");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>حسابي - جمعية السعدي</title>
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
        .back-to-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: var(--primary);
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            font-size: 14px;
            transition: all 0.3s;
            border: 1px solid var(--primary);
        }
        .back-to-home:hover {
            background: var(--primary);
            color: white;
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
        <!-- Sidebar للعضو -->
        <aside class="member-sidebar">
            <div class="member-sidebar-brand">
                <span>👤</span> حسابي
            </div>
            <ul class="member-sidebar-menu">
                <!-- زر العودة للرئيسية -->
                <li>
                    <a href="index.php"><span class="icon">🏠</span> العودة للرئيسية</a>
                </li>
                <li><a href="member_dashboard.php" class="active"><span class="icon">📋</span> معلوماتي</a></li>
                <li><a href="member_subscriptions.php"><span class="icon">📅</span> اشتراكاتي</a></li>
                <li><a href="member_payments.php"><span class="icon">💳</span> مدفوعاتي</a></li>
            </ul>
            <div class="member-sidebar-footer">
                <a href="logout.php"><span>🚪</span> تسجيل الخروج</a>
            </div>
        </aside>

        <main class="member-main">
            <div class="page-header">
                <h1>👤 حسابي</h1>
                <div style="color: var(--text-light);">
                    <?php echo $_SESSION['member_name']; ?> | <?php echo date('Y/m/d'); ?>
                </div>
            </div>

            <!-- زر رجوع سريع (سهم للانتقال للرئيسية) -->
            <a href="index.php" class="back-to-home">← العودة إلى الرئيسية</a>

            <!-- معلوماتي -->
            <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 30px;">
                <h2 style="color: #1e5631; margin-bottom: 20px; font-size: 22px;">📋 معلوماتي الشخصية</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <div style="padding: 15px; background: #f8faf9; border-radius: 10px;">
                        <small style="color: #5a6c7d;">الاسم</small>
                        <p style="font-weight: 700; margin-top: 5px;"><?php echo $member['full_name']; ?></p>
                    </div>
                    <div style="padding: 15px; background: #f8faf9; border-radius: 10px;">
                        <small style="color: #5a6c7d;">رقم الجوال</small>
                        <p style="font-weight: 700; margin-top: 5px;"><?php echo $member['phone']; ?></p>
                    </div>
                    <div style="padding: 15px; background: #f8faf9; border-radius: 10px;">
                        <small style="color: #5a6c7d;">القرية/المنطقة</small>
                        <p style="font-weight: 700; margin-top: 5px;"><?php echo $member['village_name'] ?: '-'; ?></p>
                    </div>
                    <div style="padding: 15px; background: #f8faf9; border-radius: 10px;">
                        <small style="color: #5a6c7d;">نوع العضوية</small>
                        <p style="font-weight: 700; margin-top: 5px;"><?php echo $member['membership_type'] ?: '-'; ?></p>
                    </div>
                    <div style="padding: 15px; background: #f8faf9; border-radius: 10px;">
                        <small style="color: #5a6c7d;">الحالة</small>
                        <p style="font-weight: 700; margin-top: 5px; color: <?php echo $member['status'] == 'فعال' ? '#27ae60' : '#e74c3c'; ?>"><?php echo $member['status']; ?></p>
                    </div>
                    <div style="padding: 15px; background: #f8faf9; border-radius: 10px;">
                        <small style="color: #5a6c7d;">تاريخ الانضمام</small>
                        <p style="font-weight: 700; margin-top: 5px;"><?php echo formatDate($member['join_date']); ?></p>
                    </div>
                    <?php if ($member['contribution_goal']): ?>
                    <div style="padding: 15px; background: linear-gradient(135deg, #e8f5e9, #d4edda); border-radius: 10px; border: 1px solid #c3e6cb;">
                        <small style="color: #155724;">🎯 هدف المساهمة</small>
                        <p style="font-weight: 700; margin-top: 5px; color: #1e5631;"><?php echo $member['contribution_goal']; ?></p>
                        <?php if ($member['contribution_qty']): ?>
                        <p style="font-size: 13px; color: #155724; margin-top: 3px;"><?php echo $member['contribution_qty']; ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- الاشتراكات -->
            <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 30px;">
                <h2 style="color: #1e5631; margin-bottom: 20px; font-size: 22px;">📅 اشتراكاتي</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>السنة</th>
                            <th>المبلغ</th>
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

            <!-- المدفوعات -->
            <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <h2 style="color: #1e5631; margin-bottom: 20px; font-size: 22px;">💳 مدفوعاتي</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>التاريخ</th>
                            <th>المبلغ</th>
                            <th>طريقة الدفع</th>
                            <th>رقم الإيصال</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($payments && $payments->num_rows > 0):
                            while($pay = $payments->fetch_assoc()): 
                        ?>
                        <tr>
                            <td><?php echo $pay['payment_id']; ?></td>
                            <td><?php echo formatDate($pay['payment_date']); ?></td>
                            <td style="color: #1e5631; font-weight: 700;"><?php echo formatMoney($pay['amount']); ?></td>
                            <td><?php echo $pay['payment_method']; ?></td>
                            <td><?php echo $pay['receipt_number'] ?: '-'; ?></td>
                        </tr>
                        <?php 
                            endwhile;
                        else:
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: #5a6c7d;">
                                <p style="font-size: 40px; margin-bottom: 10px;">📋</p>
                                <p>لا توجد مدفوعات مسجلة حالياً</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>