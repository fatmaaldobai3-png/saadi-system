<?php
include 'config.php';
checkAdminLogin();

$message = '';
$message_type = '';

// تفعيل/إلغاء تفعيل عضو
if (isset($_GET['toggle'])) {
    $id = intval($_GET['toggle']);
    $current = $conn->query("SELECT status FROM members WHERE member_id = $id")->fetch_assoc()['status'];
    $new_status = ($current == 'فعال') ? 'غير فعال' : 'فعال';
    $conn->query("UPDATE members SET status = '$new_status' WHERE member_id = $id");
    header("Location: admin_members.php");
    exit();
}

// حذف عضو
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM members WHERE member_id = $id");
    header("Location: admin_members.php");
    exit();
}

// البحث
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sql = "SELECT m.*, v.village_name FROM members m LEFT JOIN villages v ON m.village_id = v.village_id";
if ($search) {
    $sql .= " WHERE m.full_name LIKE '%$search%' OR m.phone LIKE '%$search%'";
}
$sql .= " ORDER BY m.member_id DESC";
$members = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الأعضاء - جمعية السعدي</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            animation: modalIn 0.3s ease;
        }
        @keyframes modalIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
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
                <li><a href="admin_members.php" class="active"><span class="icon">👥</span> الأعضاء</a></li>
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

        <main class="main-content">
            <div class="page-header">
                <h1>👥 إدارة الأعضاء</h1>
                <a href="register.php" target="_blank" class="btn btn-success">➕ إضافة عضو</a>
            </div>

            <!-- Search -->
            <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 25px; box-shadow: var(--shadow);">
                <form method="GET" action="" style="display: flex; gap: 15px;">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="ابحث بالاسم أو رقم الجوال..." style="flex: 1; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; font-family: inherit;">
                    <button type="submit" class="btn btn-success">🔍 بحث</button>
                    <?php if ($search): ?><a href="admin_members.php" class="btn btn-outline" style="border: 2px solid #ddd; color: var(--text);">مسح</a><?php endif; ?>
                </form>
            </div>

            <div class="table-card">
                <div class="table-header">
                    <h3>قائمة الأعضاء (<?php echo $members->num_rows; ?>)</h3>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الجوال</th>
                            <th>القرية</th>
                            <th>نوع العضوية</th>
                            <th>🎯 المساهمة</th>
                            <th>الحالة</th>
                            <th>تاريخ الانضمام</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $counter = 1;
                        while($m = $members->fetch_assoc()): 
                        ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><strong><?php echo $m['full_name']; ?></strong></td>
                            <td><?php echo $m['phone']; ?></td>
                            <td><?php echo $m['village_name'] ?: '<span style="color:#e74c3c">غير محدد</span>'; ?></td>
                            <td><?php echo $m['membership_type'] ?: '-'; ?></td>
                            <td>
                                <?php if ($m['contribution_goal']): ?>
                                    <span style="font-size: 12px; display: block; color: var(--primary); font-weight: 700;"><?php echo $m['contribution_goal']; ?></span>
                                    <?php if ($m['contribution_qty']): ?>
                                    <span style="font-size: 11px; color: var(--text-light);"><?php echo $m['contribution_qty']; ?></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span style="color: #999; font-size: 12px;">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="status-badge <?php echo $m['status'] == 'فعال' ? 'status-active' : 'status-inactive'; ?>">
                                    <?php echo $m['status']; ?>
                                </span>
                            </td>
                            <td><?php echo formatDate($m['join_date']); ?></td>
                            <td>
                                <div class="table-actions">
                                    <a href="admin_members.php?toggle=<?php echo $m['member_id']; ?>" class="btn btn-sm <?php echo $m['status'] == 'فعال' ? 'btn-outline' : 'btn-success'; ?>" style="font-size: 12px; padding: 5px 10px;">
                                        <?php echo $m['status'] == 'فعال' ? 'إلغاء' : 'تفعيل'; ?>
                                    </a>
                                    <a href="admin_subscriptions.php?member=<?php echo $m['member_id']; ?>" class="btn btn-sm btn-primary" style="font-size: 12px; padding: 5px 10px;">اشتراك</a>
                                    <button type="button" class="btn btn-sm btn-danger" style="font-size: 12px; padding: 5px 10px;" onclick="openDeleteModal('<?php echo $m['member_id']; ?>', '<?php echo htmlspecialchars($m['full_name'], ENT_QUOTES); ?>')">حذف</button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div style="font-size: 50px; margin-bottom: 15px;">⚠️</div>
            <h3>تأكيد الحذف</h3>
            <p>هل أنت متأكد من حذف العضو <strong id="deleteMemberName"></strong>؟<br>هذا الإجراء لا يمكن التراجع عنه.</p>
            <div class="modal-actions">
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">نعم، احذف</a>
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()" style="border: 2px solid #ddd; color: var(--text);">إلغاء</button>
            </div>
        </div>
    </div>

    <script>
    function openDeleteModal(memberId, memberName) {
        document.getElementById('deleteMemberName').textContent = memberName;
        document.getElementById('confirmDeleteBtn').href = 'admin_members.php?delete=' + memberId;
        document.getElementById('deleteModal').classList.add('active');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }
    // Close on overlay click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
    </script>
</body>
</html>