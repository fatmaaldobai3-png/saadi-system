<?php 
include 'config.php';

// تسجيل مشاركة العضو في نشاط
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register_activity']) && isMemberLoggedIn()) {
    $activity_id = intval($_POST['register_activity']);
    $member_id = $_SESSION['member_id'];

    // Check if already registered
    $check = $conn->prepare("SELECT reg_id FROM activity_registrations WHERE activity_id = ? AND member_id = ?");
    $check->bind_param("ii", $activity_id, $member_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO activity_registrations (activity_id, member_id, registered_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $activity_id, $member_id);
        $stmt->execute();
    }
    header("Location: activities.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أنشطتنا - جمعية السعدي</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <a href="index.php" class="logo">
            <img src="images/logo.jpg" alt="شعار جمعية السعدي" class="logo-img">
            <span>جمعية السعدي</span>
        </a>
        <ul class="nav-links">
            <li><a href="index.php">الرئيسية</a></li>
            <li><a href="about.php">عن الجمعية</a></li>
            <li><a href="activities.php" class="active">أنشطتنا</a></li>
            <li><a href="register.php">تسجيل عضوية</a></li>
            <?php if (isMemberLoggedIn()): ?>
            <li class="member-menu" style="position: relative;">
                <a href="#" class="btn-nav" onclick="event.preventDefault();" style="display: flex; align-items: center; gap: 6px;">👤 <?php echo htmlspecialchars(getMemberName()); ?> <span style="font-size: 10px;">▼</span></a>
                <ul class="member-dropdown" style="position: absolute; top: calc(100% + 8px); left: 0; background: white; box-shadow: 0 8px 25px rgba(0,0,0,0.15); border-radius: 12px; padding: 8px 0; min-width: 180px; display: none; z-index: 1001; list-style: none; border: 1px solid #eee;">
                    <li><a href="member_dashboard.php" style="display: block; padding: 10px 18px; color: var(--text); text-decoration: none; font-size: 14px; transition: 0.2s;">📋 حسابي</a></li>
                    <li><a href="member_subscriptions.php" style="display: block; padding: 10px 18px; color: var(--text); text-decoration: none; font-size: 14px; transition: 0.2s;">📅 اشتراكاتي</a></li>
                    <li><a href="member_payments.php" style="display: block; padding: 10px 18px; color: var(--text); text-decoration: none; font-size: 14px; transition: 0.2s;">💳 مدفوعاتي</a></li>
                    <li style="border-top: 1px solid #eee; margin-top: 5px;"><a href="logout.php" style="display: block; padding: 10px 18px; color: #e74c3c; text-decoration: none; font-size: 14px; font-weight: 700;">🚪 تسجيل الخروج</a></li>
                </ul>
            </li>
            <?php else: ?>
            <li><a href="login.php" class="btn-nav">تسجيل الدخول</a></li>
            <?php endif; ?>
        </ul>
        <button class="mobile-menu-btn">☰</button>
    </nav>
    <style>
        .member-menu:hover .member-dropdown { display: block !important; }
        .member-dropdown a:hover { background: var(--accent); color: var(--primary) !important; }
    </style>

    <section class="hero" style="padding: 80px 5%;">
        <div class="hero-content">
            <h1>أنشطة <span>جمعية السعدي</span></h1>
            <p>برامج وأنشطة نوعية تلامس احتياجات المجتمع</p>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2>أنشطتنا المنفذة والمخططة</h2>
            <p>نفذنا العديد من الأنشطة ونخطط للمزيد من البرامج المتميزة</p>
            <div class="line"></div>
        </div>

        <div class="activities-grid">
            <?php
            $activities = $conn->query("SELECT a.*, u.full_name as creator_name FROM activities a LEFT JOIN users u ON a.created_by = u.user_id ORDER BY a.activity_date DESC");
            if ($activities && $activities->num_rows > 0):
                while($act = $activities->fetch_assoc()):
                    $status_class = '';
                    $status_text = '';
                    if($act['status'] == 'منفذ') { $status_class = 'badge-done'; $status_text = 'منفذ'; }
                    elseif($act['status'] == 'مخطط') { $status_class = 'badge-planning'; $status_text = 'مخطط'; }
                    else { $status_class = 'badge-cancelled'; $status_text = 'ملغي'; }

                    // Check if member already registered
                    $is_registered = false;
                    if (isMemberLoggedIn()) {
                        $mid = $_SESSION['member_id'];
                        $aid = $act['activity_id'];
                        $reg_check = $conn->query("SELECT reg_id FROM activity_registrations WHERE activity_id = $aid AND member_id = $mid");
                        $is_registered = ($reg_check && $reg_check->num_rows > 0);
                    }

                    // Count participants
                    $aid = $act['activity_id'];
                    $participants = $conn->query("SELECT COUNT(*) as c FROM activity_registrations WHERE activity_id = $aid")->fetch_assoc()['c'];
            ?>
            <div class="activity-card">
                <div class="activity-img">
                    <?php echo $act['status'] == 'منفذ' ? '✅' : ($act['status'] == 'مخطط' ? '📋' : '❌'); ?>
                </div>
                <div class="activity-content">
                    <span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                    <h3><?php echo htmlspecialchars($act['activity_name']); ?></h3>
                    <p><?php echo htmlspecialchars($act['description'] ?: 'لا يوجد وصف'); ?></p>
                    <div class="activity-meta">
                        <span>📅 <?php echo formatDate($act['activity_date']); ?></span>
                        <span>📍 <?php echo htmlspecialchars($act['location'] ?: 'غير محدد'); ?></span>
                    </div>
                    <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 13px; color: var(--text-light);">👥 <?php echo $participants; ?> مشارك</span>
                        <?php if (isMemberLoggedIn()): ?>
                            <?php if ($is_registered): ?>
                                <span style="font-size: 13px; color: #27ae60; font-weight: 700;">✓ مسجل</span>
                            <?php elseif ($act['status'] == 'مخطط'): ?>
                                <form method="POST" action="" style="display: inline;">
                                    <input type="hidden" name="register_activity" value="<?php echo $act['activity_id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-success" style="font-size: 12px; padding: 6px 14px;">📝 سجل مشاركتي</button>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-sm btn-outline" style="font-size: 12px; padding: 6px 14px; border: 1px solid var(--primary); color: var(--primary);">سجل دخول للمشاركة</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                endwhile;
            else:
            ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                <p style="font-size: 60px; margin-bottom: 20px;">📋</p>
                <h3 style="color: var(--primary); margin-bottom: 10px;">لا توجد أنشطة مسجلة حالياً</h3>
                <p style="color: var(--text-light);">سيتم إضافة الأنشطة قريباً</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="cta-section">
        <h2>هل تريد المشاركة في أنشطتنا؟</h2>
        <p>سجل عضويتك الآن وكن جزءاً من فعالياتنا القادمة</p>
        <a href="register.php" class="btn btn-primary">سجل الآن</a>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>