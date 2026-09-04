<?php
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = trim($_POST['phone']);

    $stmt = $conn->prepare("SELECT member_id, full_name, phone, status FROM members WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $member = $result->fetch_assoc();
        if ($member['status'] == 'فعال') {
            $_SESSION['member_id'] = $member['member_id'];
            $_SESSION['member_name'] = $member['full_name'];
            $_SESSION['member_phone'] = $member['phone'];
            header("Location: member_dashboard.php");
            exit();
        } else {
            $error = 'عضويتك غير فعالة، تواصل مع الإدارة!';
        }
    } else {
        $error = 'رقم الجوال غير مسجل! تأكد من التسجيل أولاً.';
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - جمعية السعدي</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">
    <div class="login-box">
        <img src="logo.jpg" alt="شعار جمعية السعدي" style="width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 15px; display: block; border: 3px solid #d4a843;">
        <h2>تسجيل الدخول</h2>
        <p>أهلاً بكِ في جمعية السعدي الخيرية</p>

        <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group" style="margin-bottom: 20px; text-align: right;">
                <label>رقم الجوال</label>
                <input type="tel" name="phone" required placeholder="05xxxxxxxx" style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px;">
            </div>

            <button type="submit" class="btn btn-success btn-block" style="font-size: 17px; padding: 14px; background: #1e5631; color: white; border: none; border-radius: 10px; cursor: pointer; width: 100%;">دخول</button>
        </form>

        <div style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee; font-size: 15px; color: #5a6c7d;">
            <p>ليس لديك عضوية؟ <a href="register.php" style="color: #1e5631; font-weight: 700; text-decoration: none;">سجل الآن</a></p>
            <p style="margin-top: 10px; font-size: 13px;"><a href="index.php" style="color: #5a6c7d;">← العودة للموقع</a></p>
        </div>
    </div>
</body>
</html>
