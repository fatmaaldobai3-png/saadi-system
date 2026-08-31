<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// إعدادات الجلسة: الحفاظ على تسجيل الدخول لمدة 30 يوم
$lifetime = 30 * 24 * 60 * 60;

ini_set('session.cookie_lifetime', $lifetime);
ini_set('session.gc_maxlifetime', $lifetime);

session_set_cookie_params($lifetime);

session_start();


// =====================================================
// قراءة متغيرات البيئة من Railway
// =====================================================

function envValue($key, $default = '')
{
    // المحاولة الأولى: $_ENV
    if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
        return $_ENV[$key];
    }

    // المحاولة الثانية: getenv()
    $value = getenv($key);

    if ($value !== false && $value !== '') {
        return $value;
    }

    return $default;
}


// بيانات الاتصال بقاعدة البيانات
$host = envValue('MYSQLHOST', 'localhost');
$user = envValue('MYSQLUSER', 'root');
$pass = envValue('MYSQLPASSWORD', '');
$db   = envValue('MYSQLDATABASE', 'railway');
$port = envValue('MYSQLPORT', '3306');


// =====================================================
// إنشاء الاتصال بقاعدة البيانات
// =====================================================

$conn = new mysqli(
    $host,
    $user,
    $pass,
    $db,
    (int)$port
);


// التحقق من الاتصال
if ($conn->connect_error) {
    die(
        "فشل الاتصال بقاعدة البيانات: " .
        $conn->connect_error
    );
}


// ترميز قاعدة البيانات
$conn->set_charset("utf8mb4");


// =====================================================
// دالة التحقق من تسجيل دخول الإدارة
// =====================================================

function checkAdminLogin()
{
    if (!isset($_SESSION['admin_id'])) {
        header("Location: admin_login.php");
        exit();
    }
}


// =====================================================
// دالة التحقق من تسجيل دخول العضو
// =====================================================

function checkMemberLogin()
{
    if (!isset($_SESSION['member_id'])) {
        header("Location: login.php");
        exit();
    }
}


// =====================================================
// التحقق من تسجيل دخول العضو للقائمة
// =====================================================

function isMemberLoggedIn()
{
    return isset($_SESSION['member_id']);
}


// =====================================================
// جلب اسم العضو
// =====================================================

function getMemberName()
{
    return $_SESSION['member_name'] ?? '';
}


// =====================================================
// تنسيق التاريخ
// =====================================================

function formatDate($date)
{
    return date('Y/m/d', strtotime($date));
}


// =====================================================
// تنسيق المبلغ
// =====================================================

function formatMoney($amount)
{
    return number_format($amount, 2);
}


// =====================================================
// جلب الإعدادات
// =====================================================

function getSetting($key, $default = '')
{
    global $conn;

    $stmt = $conn->prepare(
        "SELECT setting_value FROM settings WHERE setting_key = ?"
    );

    $stmt->bind_param("s", $key);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc()['setting_value'];
    }

    return $default;
}

?>
