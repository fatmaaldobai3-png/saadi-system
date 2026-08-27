<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جمعية السعدي الخيرية التنموية - عدن</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="index.php" class="logo">
            <img src="images/logo.jpg" alt="شعار جمعية السعدي" class="logo-img">
            <span>جمعية السعدي</span>
        </a>
        <ul class="nav-links">
            <li><a href="index.php" class="active">الرئيسية</a></li>
            <li><a href="about.php">عن الجمعية</a></li>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>معاً نبني <span>مجتمعاً متكافلاً</span></h1>
            <p>جمعية السعدي الخيرية التنموية - عدن<br>نسعى لتقديم المساعدات الإنسانية وتنفيذ البرامج والمشاريع التنموية للأسر المحتاجة والأيتام والنساء والشباب</p>
            <div class="hero-btns">
                <a href="register.php" class="btn btn-primary">📝 سجل عضويتك الآن</a>
                <a href="about.php" class="btn btn-outline">تعرف علينا أكثر</a>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="stat-item">
            <h3>+500</h3>
            <p>أسرة مستفيدة</p>
        </div>
        <div class="stat-item">
            <h3>+200</h3>
            <p>يتيم مكفول</p>
        </div>
        <div class="stat-item">
            <h3>+50</h3>
            <p>مشروع منفذ</p>
        </div>
        <div class="stat-item">
            <h3>+1000</h3>
            <p>متطوع</p>
        </div>
    </div>

    <!-- Vision & Mission -->
    <section class="section">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; max-width: 1000px; margin: 0 auto;">
            <div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 40px; border-radius: 20px; text-align: center;">
                <div style="font-size: 50px; margin-bottom: 15px;">👁️</div>
                <h2 style="font-size: 24px; margin-bottom: 15px;">رؤيتنا</h2>
                <p style="font-size: 16px; line-height: 2; opacity: 0.95;">
                    مجتمع متكافل ومتعاون، تتحسن فيه الظروف المعيشية للأسر المحتاجة، وتتوفر فيه فرص التعليم والصحة والتنمية والتمكين الاقتصادي.
                </p>
            </div>
            <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow); text-align: center; border-top: 4px solid var(--secondary);">
                <div style="font-size: 50px; margin-bottom: 15px;">📜</div>
                <h2 style="font-size: 24px; margin-bottom: 15px; color: var(--primary);">رسالتنا</h2>
                <p style="font-size: 16px; line-height: 2; color: var(--text-light);">
                    تقديم المساعدات الإنسانية وتنفيذ البرامج والمشاريع التنموية التي تستهدف الأسر المحتاجة والأيتام والنساء والشباب، وتعزيز التكافل والشراكة المجتمعية بصورة مستدامة وشفافة.
                </p>
            </div>
        </div>
    </section>

    <!-- Goals Section -->
    <section class="section" style="background: white; margin: 0; max-width: 100%; padding: 80px 5%;">
        <div class="section-header">
            <h2>أهدافنا</h2>
            <p>نسعى لتحقيق رسالة سامية تخدم المجتمع وتنمية الموارد البشرية والمادية</p>
            <div class="line"></div>
        </div>
        <div class="goals-grid">
            <div class="goal-card">
                <div class="goal-icon">🏠</div>
                <h3>رعاية الأسر الفقيرة</h3>
                <p>رعاية الأسر الفقيرة والمحتاجة وتقديم المساعدات لها</p>
            </div>
            <div class="goal-card">
                <div class="goal-icon">👶</div>
                <h3>كفالة الأيتام</h3>
                <p>كفالة ورعاية الأيتام والأرامل والفئات الأشد احتياجًا</p>
            </div>
            <div class="goal-card">
                <div class="goal-icon">📚</div>
                <h3>دعم التعليم</h3>
                <p>دعم الطلاب المحتاجين وتشجيع التعليم والتأهيل</p>
            </div>
            <div class="goal-card">
                <div class="goal-icon">🏥</div>
                <h3>الرعاية الصحية</h3>
                <p>المساهمة في توفير الرعاية الصحية والعلاج للمحتاجين</p>
            </div>
            <div class="goal-card">
                <div class="goal-icon">💼</div>
                <h3>التمكين الاقتصادي</h3>
                <p>تمكين الأسر اقتصاديًا من خلال المشاريع الصغيرة والأسر المنتجة</p>
            </div>
            <div class="goal-card">
                <div class="goal-icon">🎓</div>
                <h3>التدريب والتأهيل</h3>
                <p>تدريب وتأهيل الشباب والنساء وإكسابهم مهارات مهنية</p>
            </div>
            <div class="goal-card">
                <div class="goal-icon">💧</div>
                <h3>مشاريع المياه</h3>
                <p>تنفيذ مشاريع المياه والإصحاح البيئي والخدمات المجتمعية</p>
            </div>
            <div class="goal-card">
                <div class="goal-icon">🚨</div>
                <h3>الإغاثة العاجلة</h3>
                <p>المساهمة في مواجهة الكوارث والأزمات وتقديم الإغاثة العاجلة</p>
            </div>
            <div class="goal-card">
                <div class="goal-icon">🤝</div>
                <h3>التطوع والتكافل</h3>
                <p>تشجيع المبادرات التطوعية وروح التكافل والتعاون</p>
            </div>
            <div class="goal-card">
                <div class="goal-icon">🤲</div>
                <h3>الشراكات</h3>
                <p>إقامة شراكات مع المؤسسات الحكومية والأهلية والقطاع الخاص</p>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="section">
        <div class="section-header">
            <h2>أنشطتنا ومشاريعنا</h2>
            <p>برامج ومشاريع نوعية تلامس احتياجات المجتمع</p>
            <div class="line"></div>
        </div>
        <div class="activities-grid">
            <div class="activity-card">
                <div class="activity-img" style="background: linear-gradient(135deg, #e74c3c, #c0392b);">👶</div>
                <div class="activity-content">
                    <h3>مشروع كفالة الأيتام</h3>
                    <p>كفالة الأيتام وتوفير احتياجاتهم الأساسية من غذاء وكساء وتعليم</p>
                </div>
            </div>
            <div class="activity-card">
                <div class="activity-img" style="background: linear-gradient(135deg, #27ae60, #1e8449);">🏠</div>
                <div class="activity-content">
                    <h3>مشروع رعاية الأسر الأشد احتياجًا</h3>
                    <p>دعم الأسر الفقيرة وتقديم المساعدات المالية والعينية لهم</p>
                </div>
            </div>
            <div class="activity-card">
                <div class="activity-img" style="background: linear-gradient(135deg, #f39c12, #d68910);">🍞</div>
                <div class="activity-content">
                    <h3>مشروع السلال الغذائية</h3>
                    <p>توزيع السلال الغذائية والمساعدات الموسمية للأسر المحتاجة</p>
                </div>
            </div>
            <div class="activity-card">
                <div class="activity-img" style="background: linear-gradient(135deg, #9b59b6, #8e44ad);">👕</div>
                <div class="activity-content">
                    <h3>مشروع كسوة العيد</h3>
                    <p>توفير الملابس الجديدة للأيتام والأسر الفقيرة في المناسبات</p>
                </div>
            </div>
            <div class="activity-card">
                <div class="activity-img" style="background: linear-gradient(135deg, #3498db, #2980b9);">🎒</div>
                <div class="activity-content">
                    <h3>مشروع الحقيبة والزي المدرسي</h3>
                    <p>توفير الأدوات المدرسية والزي للطلاب المحتاجين</p>
                </div>
            </div>
            <div class="activity-card">
                <div class="activity-img" style="background: linear-gradient(135deg, #1abc9c, #16a085);">📖</div>
                <div class="activity-content">
                    <h3>مشروع المنح التعليمية</h3>
                    <p>دعم الطلاب الجامعيين والمتفوقين بالمنح الدراسية</p>
                </div>
            </div>
            <div class="activity-card">
                <div class="activity-img" style="background: linear-gradient(135deg, #e67e22, #d35400);">🏥</div>
                <div class="activity-content">
                    <h3>مشروع العلاج والعمليات</h3>
                    <p>توفير العلاج والعمليات الجراحية للمرضى المحتاجين</p>
                </div>
            </div>
            <div class="activity-card">
                <div class="activity-img" style="background: linear-gradient(135deg, #2c3e50, #34495e);">💼</div>
                <div class="activity-content">
                    <h3>مشروع الأسر المنتجة</h3>
                    <p>دعم الأسر بمشاريع صغيرة تدر دخلاً مستداماً</p>
                </div>
            </div>
            <div class="activity-card">
                <div class="activity-img" style="background: linear-gradient(135deg, #16a085, #1abc9c);">🎓</div>
                <div class="activity-content">
                    <h3>برامج التدريب المهني</h3>
                    <p>تأهيل الشباب والنساء وإكسابهم مهارات مهنية للعمل</p>
                </div>
            </div>
            <div class="activity-card">
                <div class="activity-img" style="background: linear-gradient(135deg, #2980b9, #3498db);">💧</div>
                <div class="activity-content">
                    <h3>مشاريع المياه</h3>
                    <p>حفر الآبار وإنشاء خزانات المياه للمجتمعات المحتاجة</p>
                </div>
            </div>
            <div class="activity-card">
                <div class="activity-img" style="background: linear-gradient(135deg, #8e44ad, #9b59b6);">🏚️</div>
                <div class="activity-content">
                    <h3>ترميم المساكن</h3>
                    <p>ترميم وتحسين مساكن الأسر المحتاجة</p>
                </div>
            </div>
            <div class="activity-card">
                <div class="activity-img" style="background: linear-gradient(135deg, #c0392b, #e74c3c);">🚨</div>
                <div class="activity-content">
                    <h3>حملات الإغاثة</h3>
                    <p>الاستجابة السريعة للكوارث وتقديم الإغاثة العاجلة</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>كن عضواً فاعلاً في جمعيتنا</h2>
        <p>اشتراكك الشهري يصنع فرقاً حقيقياً في حياة الأسر المحتاجة<br>ساهم معنا في بناء مجتمع متكافل</p>
        <a href="register.php" class="btn btn-primary" style="font-size: 18px; padding: 16px 40px;">سجل الآن وكن جزءاً من التغيير</a>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>
