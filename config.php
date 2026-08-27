<?php
// إعدادات الجلسة: الحفاظ على تسجيل الدخول لمدة 30 يوم (حتى بعد إغلاق المتصفح)
$lifetime = 30 * 24 * 60 * 60; 
ini_set('session.cookie_lifetime', $lifetime);
ini_set('session.gc_maxlifetime', $lifetime);
session_set_cookie_params($lifetime);

session_start();

$host = "sql302.infinityfree.com";
$user = "if0_42749265";
$pass = "z5DYVK2oLM8r";
$db   = "if0_42749265_saadi_charity";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// دالة للتحقق من تسجيل دخول الإدارة
function checkAdminLogin() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: admin_login.php");
        exit();
    }
}

// دالة للتحقق من تسجيل دخول العضو
function checkMemberLogin() {
    if (!isset($_SESSION['member_id'])) {
        header("Location: login.php");
        exit();
    }
}

// دالة للتحقق إذا كان العضو مسجل دخول أم لا (للقائمة المنسدلة)
function isMemberLoggedIn() {
    return isset($_SESSION['member_id']);
}

// دالة لجلب اسم العضو
function getMemberName() {
    return $_SESSION['member_name'] ?? '';
}

// دالة لتنسيق التاريخ
function formatDate($date) {
    return date('Y/m/d', strtotime($date));
}

// دالة لتنسيق المبلغ
function formatMoney($amount) {
    return number_format($amount, 2);
}

// دالة جلب الإعدادات
function getSetting($key, $default = '') {
    global $conn;
    $stmt = $conn->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc()['setting_value'];
    }
    return $default;
}
?>