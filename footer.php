<?php
// جلب الإعدادات
$site_name    = getSetting('site_name', 'جمعية السعدي الخيرية التنموية');
$site_email   = getSetting('site_email', 'info@saadi-charity.org');
$site_phone   = getSetting('site_phone', '+967-xxx-xxx-xxx');
$site_address = getSetting('site_address', 'عدن - الجمهورية اليمنية');
?>
<footer class="footer">
    <div class="footer-grid">
        <div class="footer-brand">
            <h3><img src="images/logo.jpg" alt="" style="width: 40px; height: 40px; border-radius: 50%; vertical-align: middle; margin-left: 10px;"> <?php echo htmlspecialchars($site_name); ?></h3>
            <p>جمعية خيرية تنموية تأسست بهدف خدمة المجتمع وتنميته من خلال برامج وأنشطة نوعية تلامس احتياجات الأسر المحتاجة والأيتام والنساء والشباب في عدن.</p>
        </div>
        <div>
            <h4>روابط سريعة</h4>
            <ul class="footer-links">
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="about.php">عن الجمعية</a></li>
                <li><a href="activities.php">الأنشطة</a></li>
                <li><a href="register.php">تسجيل عضوية</a></li>
            </ul>
        </div>
        <div>
            <h4>مشاريعنا</h4>
            <ul class="footer-links">
                <li><a href="#">كفالة الأيتام</a></li>
                <li><a href="#">السلال الغذائية</a></li>
                <li><a href="#">المنح التعليمية</a></li>
                <li><a href="#">مشاريع المياه</a></li>
            </ul>
        </div>
        <div>
            <h4>تواصل معنا</h4>
            <ul class="footer-links">
                <li>📍 <?php echo htmlspecialchars($site_address); ?></li>
                <li>📧 <?php echo htmlspecialchars($site_email); ?></li>
                <li>📱 <?php echo htmlspecialchars($site_phone); ?></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2026 <?php echo htmlspecialchars($site_name); ?> - عدن - جميع الحقوق محفوظة</p>
    </div>
</footer>