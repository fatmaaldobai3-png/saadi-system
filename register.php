<?php
include 'config.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $gender = $_POST['gender'];
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $membership_type = trim($_POST['membership_type']);
    $notes = trim($_POST['notes'] ?? '');
    $subscription_amount = floatval($_POST['subscription_amount']);
    $currency = $_POST['currency'];
    $contribution_goal = trim($_POST['contribution_goal'] ?? '');
    $contribution_qty = trim($_POST['contribution_qty'] ?? '');

    if (empty($email)) $email = null;

    // التحقق من عدم تكرار رقم الجوال
    $check = $conn->prepare("SELECT member_id FROM members WHERE phone = ?");
    $check->bind_param("s", $phone);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = 'رقم الجوال مسجل مسبقاً!';
        $message_type = 'error';
    } else {
        $conn->begin_transaction();
        try {
            $village_id = null;

            if (isset($_POST['village_id']) && $_POST['village_id'] !== 'other' && !empty($_POST['village_id'])) {
                $village_id = intval($_POST['village_id']);
            } 
            elseif (isset($_POST['village_name_other']) && !empty(trim($_POST['village_name_other']))) {
                $village_name = trim($_POST['village_name_other']);
                $v_stmt = $conn->prepare("SELECT village_id FROM villages WHERE village_name = ?");
                $v_stmt->bind_param("s", $village_name);
                $v_stmt->execute();
                $v_result = $v_stmt->get_result();
                if ($v_result->num_rows > 0) {
                    $village_id = $v_result->fetch_assoc()['village_id'];
                } else {
                    $v_insert = $conn->prepare("INSERT INTO villages (village_name) VALUES (?)");
                    $v_insert->bind_param("s", $village_name);
                    $v_insert->execute();
                    $village_id = $conn->insert_id;
                }
            }

            if (!$village_id) {
                throw new Exception('يجب اختيار القرية / المنطقة!');
            }

            $stmt = $conn->prepare("INSERT INTO members (village_id, full_name, gender, phone, email, address, join_date, membership_type, notes, contribution_goal, contribution_qty) VALUES (?, ?, ?, ?, ?, ?, CURDATE(), ?, ?, ?, ?)");
            $stmt->bind_param("isssssssss", $village_id, $full_name, $gender, $phone, $email, $address, $membership_type, $notes, $contribution_goal, $contribution_qty);
            $stmt->execute();
            $member_id = $conn->insert_id;

            $current_year = date('Y');
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d', strtotime('+1 year'));

            $sub_stmt = $conn->prepare("INSERT INTO subscriptions (member_id, subscription_year, amount, currency, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)");
            $sub_stmt->bind_param("iidsss", $member_id, $current_year, $subscription_amount, $currency, $start_date, $end_date);
            $sub_stmt->execute();

            $conn->commit();

            $message = '✅ تم تسجيل عضويتك بنجاح! يمكنك الآن تسجيل الدخول باستخدام رقم جوالك.';
            $message_type = 'success';
        } catch (Exception $e) {
            $conn->rollback();
            $message = '❌ حدث خطأ: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل عضوية - جمعية السعدي</title>
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
            <li><a href="activities.php">أنشطتنا</a></li>
            <li><a href="register.php" class="active">تسجيل عضوية</a></li>
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

    <section style="padding: 60px 5%;">
        <div class="form-container">
            <div class="form-title">
                <div class="logo-icon" style="margin: 0 auto 15px; width: 60px; height: 60px; font-size: 28px;">📝</div>
                <h2>تسجيل عضوية جديدة</h2>
                <p>املأ البيانات التالية للانضمام إلى جمعية السعدي</p>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>الاسم الكامل <span class="required">*</span></label>
                        <input type="text" name="full_name" required placeholder="أدخل اسمك الكامل">
                    </div>

                    <div class="form-group">
                        <label>الجنس <span class="required">*</span></label>
                        <select name="gender" required>
                            <option value="">-- اختر --</option>
                            <option value="ذكر">ذكر</option>
                            <option value="أنثى">أنثى</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>رقم الجوال <span class="required">*</span></label>
                        <input type="tel" name="phone" required placeholder="+967771234567" pattern="^\+?[0-9]{10,15}$" title="أدخل رقم الجوال مع رمز الدولة (مثال: +967771234567)">
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 5px;">أدخل رمز الدولة (+967) ثم الرقم</small>
                    </div>

                    <div class="form-group">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" placeholder="اختياري - يمكن تركه فارغاً">
                    </div>

                    <div class="form-group">
                        <label>القرية / المنطقة <span class="required">*</span></label>
                        <select name="village_id" id="village_select" required onchange="toggleOtherVillage(this)">
                            <option value="">-- اختر القرية --</option>
                            <?php 
                            $villages_list = $conn->query("SELECT village_id, village_name, district FROM villages ORDER BY village_name");
                            while($v = $villages_list->fetch_assoc()): 
                            ?>
                            <option value="<?php echo $v['village_id']; ?>">
                                <?php echo htmlspecialchars($v['village_name']); ?> 
                                <?php echo $v['district'] ? '(' . htmlspecialchars($v['district']) . ')' : ''; ?>
                            </option>
                            <?php endwhile; ?>
                            <option value="other">➕ قرية أخرى (اكتب اسمها)</option>
                        </select>
                    </div>

                    <div class="form-group" id="other_village_div" style="display:none;">
                        <label>اسم القرية الجديدة <span class="required">*</span></label>
                        <input type="text" name="village_name_other" id="village_name_other" placeholder="اكتب اسم القرية/المنطقة">
                    </div>

                    <div class="form-group">
                        <label>العنوان</label>
                        <input type="text" name="address" placeholder="اختياري">
                    </div>

                    <div class="form-group">
                        <label>نوع العضوية <span class="required">*</span></label>
                        <select name="membership_type" required>
                            <option value="">-- اختر --</option>
                            <option value="عضو فعال">عضو فعال</option>
                            <option value="عضو منتسب">عضو منتسب</option>
                            <option value="متطوع">متطوع</option>
                            <option value="داعم">داعم</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label>🎯 هدف المساهمة <span class="required">*</span></label>
                        <select name="contribution_goal" required onchange="toggleContributionQty(this)">
                            <option value="">-- اختر نوع المساهمة --</option>
                            <option value="كفالة أيتام">👶 كفالة أيتام</option>
                            <option value="كسوة العيد">👕 كسوة العيد</option>
                            <option value="السلال الغذائية">🍞 السلال الغذائية</option>
                            <option value="الحقيبة المدرسية">🎒 الحقيبة والزي المدرسي</option>
                            <option value="المنح التعليمية">📖 المنح التعليمية</option>
                            <option value="العلاج والعمليات">🏥 العلاج والعمليات</option>
                            <option value="الأسر المنتجة">💼 الأسر المنتجة</option>
                            <option value="مشاريع المياه">💧 مشاريع المياه</option>
                            <option value="ترميم المساكن">🏚️ ترميم المساكن</option>
                            <option value="الإغاثة العاجلة">🚨 الإغاثة العاجلة</option>
                            <option value="تبرع عام">🤲 تبرع عام</option>
                        </select>
                    </div>

                    <div class="form-group" id="qty_div">
                        <label id="qty_label">العدد / المبلغ</label>
                        <input type="text" name="contribution_qty" id="contribution_qty" placeholder="مثال: 3 أيتام أو 5000 ريال">
                    </div>

                    <div class="form-group">
                        <label>مبلغ الاشتراك الشهري <span class="required">*</span></label>
                        <input type="number" name="subscription_amount" required min="100" step="100" value="1000" placeholder="مثال: 1000">
                    </div>

                    <div class="form-group">
                        <label>العملة <span class="required">*</span></label>
                        <select name="currency" required>
                            <option value="ريال يمني">🇾🇪 ريال يمني</option>
                            <option value="ريال سعودي">🇸🇦 ريال سعودي</option>
                            <option value="دولار أمريكي">🇺🇸 دولار أمريكي</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label>ملاحظات</label>
                        <textarea name="notes" rows="3" placeholder="أي ملاحظات إضافية..."></textarea>
                    </div>

                    <div class="form-group full-width">
                        <button type="submit" class="btn btn-success btn-block" style="font-size: 18px; padding: 16px;">
                            ✅ تأكيد التسجيل
                        </button>
                    </div>
                </div>
            </form>

            <div class="login-footer">
                لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول</a>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
    function toggleOtherVillage(select) {
        var otherDiv = document.getElementById('other_village_div');
        var otherInput = document.getElementById('village_name_other');
        if (select.value === 'other') {
            otherDiv.style.display = 'flex';
            otherDiv.style.flexDirection = 'column';
            otherInput.required = true;
        } else {
            otherDiv.style.display = 'none';
            otherInput.required = false;
            otherInput.value = '';
        }
    }

    function toggleContributionQty(select) {
        var qtyLabel = document.getElementById('qty_label');
        var qtyInput = document.getElementById('contribution_qty');
        var val = select.value;
        if (val === 'كفالة أيتام') {
            qtyLabel.textContent = 'عدد الأيتام المراد كفالتهم';
            qtyInput.placeholder = 'مثال: 3 أيتام';
        } else if (val === 'كسوة العيد') {
            qtyLabel.textContent = 'عدد الأطفال';
            qtyInput.placeholder = 'مثال: 5 أطفال';
        } else if (val === 'السلال الغذائية') {
            qtyLabel.textContent = 'عدد السلال';
            qtyInput.placeholder = 'مثال: 10 سلال';
        } else if (val === 'الحقيبة المدرسية') {
            qtyLabel.textContent = 'عدد الطلاب';
            qtyInput.placeholder = 'مثال: 20 طالب';
        } else if (val === 'المنح التعليمية') {
            qtyLabel.textContent = 'عدد الطلاب / المبلغ';
            qtyInput.placeholder = 'مثال: 5 طلاب أو 50000 ريال';
        } else if (val === 'العلاج والعمليات') {
            qtyLabel.textContent = 'عدد الحالات / المبلغ';
            qtyInput.placeholder = 'مثال: 3 حالات';
        } else if (val === 'الأسر المنتجة') {
            qtyLabel.textContent = 'عدد الأسر';
            qtyInput.placeholder = 'مثال: 2 أسرة';
        } else if (val === 'مشاريع المياه') {
            qtyLabel.textContent = 'عدد الآبار / المبلغ';
            qtyInput.placeholder = 'مثال: بئر واحد';
        } else if (val === 'ترميم المساكن') {
            qtyLabel.textContent = 'عدد المساكن';
            qtyInput.placeholder = 'مثال: بيت واحد';
        } else if (val === 'الإغاثة العاجلة') {
            qtyLabel.textContent = 'المبلغ / عدد المستفيدين';
            qtyInput.placeholder = 'مثال: 100000 ريال';
        } else if (val === 'تبرع عام') {
            qtyLabel.textContent = 'المبلغ أو الوصف';
            qtyInput.placeholder = 'مثال: 10000 ريال';
        }
    }
    </script>
</body>
</html>