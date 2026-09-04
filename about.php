<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عن الجمعية - جمعية السعدي الخيرية التنموية - عدن</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <a href="index.php" class="logo">
            <img src="logo.jpg" alt="شعار جمعية السعدي" class="logo-img">
            <span>جمعية السعدي</span>
        </a>
        <ul class="nav-links">
            <li><a href="index.php">الرئيسية</a></li>
            <li><a href="about.php" class="active">عن الجمعية</a></li>
            <li><a href="activities.php">أنشطتنا</a></li>
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
            <h1>عن <span>جمعية السعدي</span></h1>
            <p>جمعية خيرية تنموية تأسست بهدف خدمة المجتمع وبناء الإنسان في عدن</p>
        </div>
    </section>

    <section class="section">
        <div style="max-width: 900px; margin: 0 auto;">
            <!-- Vision -->
            <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow); margin-bottom: 30px; border-right: 5px solid var(--primary);">
                <h2 style="color: var(--primary); margin-bottom: 20px; font-size: 26px;">👁️ رؤيتنا</h2>
                <p style="font-size: 17px; color: var(--text-light); line-height: 2;">
                    مجتمع متكافل ومتعاون، تتحسن فيه الظروف المعيشية للأسر المحتاجة، وتتوفر فيه فرص التعليم والصحة والتنمية والتمكين الاقتصادي.
                </p>
            </div>

            <!-- Mission -->
            <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow); margin-bottom: 30px; border-right: 5px solid var(--secondary);">
                <h2 style="color: var(--primary); margin-bottom: 20px; font-size: 26px;">📜 رسالتنا</h2>
                <p style="font-size: 17px; color: var(--text-light); line-height: 2;">
                    تقديم المساعدات الإنسانية وتنفيذ البرامج والمشاريع التنموية التي تستهدف الأسر المحتاجة والأيتام والنساء والشباب، وتعزيز التكافل والشراكة المجتمعية بصورة مستدامة وشفافة.
                </p>
            </div>

            <!-- Goals -->
            <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow); margin-bottom: 30px;">
                <h2 style="color: var(--primary); margin-bottom: 25px; font-size: 26px;">🎯 أهدافنا</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">
                    <div style="padding: 15px 20px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 24px;">🏠</span>
                        <span>رعاية الأسر الفقيرة والمحتاجة وتقديم المساعدات لها</span>
                    </div>
                    <div style="padding: 15px 20px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 24px;">👶</span>
                        <span>كفالة ورعاية الأيتام والأرامل والفئات الأشد احتياجًا</span>
                    </div>
                    <div style="padding: 15px 20px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 24px;">📚</span>
                        <span>دعم الطلاب المحتاجين وتشجيع التعليم والتأهيل</span>
                    </div>
                    <div style="padding: 15px 20px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 24px;">🏥</span>
                        <span>المساهمة في توفير الرعاية الصحية والعلاج للمحتاجين</span>
                    </div>
                    <div style="padding: 15px 20px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 24px;">💼</span>
                        <span>تمكين الأسر اقتصاديًا من خلال المشاريع الصغيرة</span>
                    </div>
                    <div style="padding: 15px 20px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 24px;">🎓</span>
                        <span>تدريب وتأهيل الشباب والنساء وإكسابهم مهارات مهنية</span>
                    </div>
                    <div style="padding: 15px 20px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 24px;">💧</span>
                        <span>تنفيذ مشاريع المياه والإصحاح البيئي والخدمات المجتمعية</span>
                    </div>
                    <div style="padding: 15px 20px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 24px;">🚨</span>
                        <span>المساهمة في مواجهة الكوارث وتقديم الإغاثة العاجلة</span>
                    </div>
                    <div style="padding: 15px 20px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 24px;">🤝</span>
                        <span>تشجيع المبادرات التطوعية وروح التكافل والتعاون</span>
                    </div>
                    <div style="padding: 15px 20px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 24px;">🤲</span>
                        <span>إقامة شراكات مع المؤسسات لدعم البرامج التنموية</span>
                    </div>
                </div>
            </div>

            <!-- Values -->
            <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow); margin-bottom: 30px;">
                <h2 style="color: var(--primary); margin-bottom: 25px; font-size: 26px;">⭐ قيمنا</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px;">
                    <div style="text-align: center; padding: 20px;">
                        <div style="font-size: 40px; margin-bottom: 10px;">🤲</div>
                        <h4 style="color: var(--primary); margin-bottom: 8px;">الإخلاص</h4>
                        <p style="font-size: 14px; color: var(--text-light);">العمل بإخلاص لوجه الله</p>
                    </div>
                    <div style="text-align: center; padding: 20px;">
                        <div style="font-size: 40px; margin-bottom: 10px;">🤝</div>
                        <h4 style="color: var(--primary); margin-bottom: 8px;">التعاون</h4>
                        <p style="font-size: 14px; color: var(--text-light);">العمل الجماعي لتحقيق الأهداف</p>
                    </div>
                    <div style="text-align: center; padding: 20px;">
                        <div style="font-size: 40px; margin-bottom: 10px;">💡</div>
                        <h4 style="color: var(--primary); margin-bottom: 8px;">الإبداع</h4>
                        <p style="font-size: 14px; color: var(--text-light);">التفكير المبتكر في الحلول</p>
                    </div>
                    <div style="text-align: center; padding: 20px;">
                        <div style="font-size: 40px; margin-bottom: 10px;">⚖️</div>
                        <h4 style="color: var(--primary); margin-bottom: 8px;">الشفافية</h4>
                        <p style="font-size: 14px; color: var(--text-light);">الوضوح في كل عملياتنا</p>
                    </div>
                    <div style="text-align: center; padding: 20px;">
                        <div style="font-size: 40px; margin-bottom: 10px;">💚</div>
                        <h4 style="color: var(--primary); margin-bottom: 8px;">الإنسانية</h4>
                        <p style="font-size: 14px; color: var(--text-light);">خدمة الإنسان أولويتنا</p>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 40px; border-radius: 20px; text-align: center;">
                <h2 style="margin-bottom: 15px; font-size: 28px;">انضم إلينا اليوم</h2>
                <p style="font-size: 17px; opacity: 0.95; margin-bottom: 25px;">كن جزءاً من أسرة جمعية السعدي وساهم في خدمة مجتمعك</p>
                <a href="register.php" class="btn btn-primary" style="font-size: 18px;">سجل عضويتك الآن</a>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>
</body>
</html>
