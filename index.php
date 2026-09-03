<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>جمعية سعدي للتنمية الخيرية - عدن</title>

    <link rel="stylesheet" href="css/style.css">

    <!-- Mobile Navigation Fix -->
    <style>

        /* =========================================
           Mobile Navigation
        ========================================= */

        .mobile-menu-toggle {
            display: none;
        }

        .mobile-menu-label {
            display: none;
        }

        @media (max-width: 768px) {

            /* Hide normal navigation */
            .navbar .nav-links {
                display: none !important;
            }

            /* Mobile menu button */
            .mobile-menu-label {
                display: flex !important;

                width: 45px;
                height: 45px;

                align-items: center;
                justify-content: center;

                font-size: 30px;

                color: var(--primary);

                background: transparent;

                border: none;

                cursor: pointer;

                position: relative;

                z-index: 10001;

                user-select: none;

                -webkit-user-select: none;

                -webkit-tap-highlight-color: transparent;
            }

            /* Show navigation when menu is checked */
            .mobile-menu-toggle:checked ~ .nav-links {
                display: flex !important;
            }

            .navbar {
                position: sticky;

                top: 0;

                z-index: 10000;

                min-height: 75px;
            }

            /* Mobile navigation menu */
            .navbar .nav-links {
                position: absolute;

                top: 75px;

                left: 0;

                right: 0;

                width: 100%;

                box-sizing: border-box;

                background: var(--white);

                flex-direction: column;

                align-items: stretch;

                gap: 0;

                padding: 15px 20px;

                margin: 0;

                box-shadow: 0 10px 30px rgba(0,0,0,0.15);

                border-top: 1px solid #eee;

                z-index: 9999;
            }

            .navbar .nav-links li {
                width: 100%;

                margin: 0;

                padding: 0;

                list-style: none;
            }

            .navbar .nav-links li a {
                display: block;

                width: 100%;

                box-sizing: border-box;

                padding: 14px 15px;

                margin: 3px 0;

                border-radius: 8px;

                text-decoration: none;
            }

            .navbar .nav-links .btn-nav {
                margin: 5px 0;
            }

            /* Member menu on mobile */
            .member-menu {
                width: 100%;

                position: relative;
            }

            .member-dropdown {
                position: static !important;

                display: block !important;

                width: 100%;

                min-width: 0 !important;

                box-sizing: border-box;

                box-shadow: none !important;

                border: none !important;

                background: #f8f8f8 !important;

                margin-top: 5px;

                padding: 5px 0 !important;
            }

            .member-dropdown a {
                padding: 11px 15px !important;
            }

            /* Logo */
            .logo {
                font-size: 19px;
            }

            .logo-img {
                max-width: 45px;

                max-height: 45px;
            }

            /* Hero */
            .hero h1 {
                font-size: 32px;
            }

            /* Statistics */
            .stats-bar {
                grid-template-columns: 1fr;

                margin: -20px 20px 0;
            }

            /* Forms */
            .form-grid {
                grid-template-columns: 1fr;
            }

            /* Footer */
            .footer-grid {
                grid-template-columns: 1fr;
            }

            /* Sections */
            .section {
                padding: 50px 20px;
            }

        }

    </style>

</head>

<body>


<!-- =====================================================
     NAVBAR
===================================================== -->

<nav class="navbar">

    <!-- Logo -->

    <a href="index.php" class="logo">

        <img
            src="logo.jpg"
            alt="شعار جمعية سعدي الخيرية"
            class="logo-img">

        <span>جمعية سعدي للتنمية الخيرية</span>

    </a>


    <!-- Mobile menu checkbox -->

    <input
        type="checkbox"
        id="mobile-menu-toggle"
        class="mobile-menu-toggle">


    <!-- Mobile menu button -->

    <label
        for="mobile-menu-toggle"
        class="mobile-menu-label"
        aria-label="فتح القائمة">

        ☰

    </label>


    <!-- Navigation Links -->

    <ul class="nav-links">

        <li>

            <a href="index.php"
               class="active">

                الرئيسية

            </a>

        </li>


        <li>

            <a href="about.php">

                من نحن

            </a>

        </li>


        <li>

            <a href="activities.php">

                أنشطتنا

            </a>

        </li>


        <li>

            <a href="register.php">

                العضوية

            </a>

        </li>


        <?php if (isMemberLoggedIn()): ?>

            <li class="member-menu">

                <a
                    href="#"
                    class="btn-nav"
                    onclick="event.preventDefault();">

                    👤

                    <?php
                    echo htmlspecialchars(getMemberName());
                    ?>

                    <span style="font-size:10px;">

                        ▼

                    </span>

                </a>


                <ul class="member-dropdown">

                    <li>

                        <a href="member_dashboard.php">

                            📋 حسابي

                        </a>

                    </li>


                    <li>

                        <a href="member_subscriptions.php">

                            📅 اشتراكاتي

                        </a>

                    </li>


                    <li>

                        <a href="member_payments.php">

                            💳 مدفوعاتي

                        </a>

                    </li>


                    <li
                        style="
                            border-top:1px solid #eee;
                            margin-top:5px;
                        ">

                        <a
                            href="logout.php"
                            style="
                                color:#e74c3c;
                                font-weight:700;
                            ">

                            🚪 تسجيل الخروج

                        </a>

                    </li>

                </ul>

            </li>


        <?php else: ?>

            <li>

                <a
                    href="login.php"
                    class="btn-nav">

                    تسجيل الدخول

                </a>

            </li>

        <?php endif; ?>

    </ul>

</nav>


<!-- =====================================================
     MEMBER DROPDOWN STYLE
===================================================== -->

<style>

    .member-menu {
        position: relative;
    }

    .member-menu:hover .member-dropdown {
        display: block !important;
    }

    .member-dropdown {
        position: absolute;

        top: calc(100% + 8px);

        right: 0;

        background: white;

        box-shadow:
            0 8px 25px
            rgba(0,0,0,0.15);

        border-radius: 12px;

        padding: 8px 0;

        min-width: 180px;

        display: none;

        z-index: 10001;

        list-style: none;

        border: 1px solid #eee;
    }

    .member-dropdown a:hover {

        background: var(--accent);

        color: var(--primary) !important;

    }

</style>


<!-- =====================================================
     HERO SECTION
===================================================== -->

<section class="hero">

    <div class="hero-content">

        <h1>

            معًا نبني

            <span>
                مجتمعًا متكافلًا
            </span>

        </h1>


        <p>

            جمعية سعدي للتنمية الخيرية - عدن

            <br>

            نسعى إلى تقديم المساعدات الإنسانية وتنفيذ
            البرامج والمشاريع التنموية للأسر المحتاجة
            والأيتام والنساء والشباب.

        </p>


        <div class="hero-btns">

            <a
                href="register.php"
                class="btn btn-primary">

                📝 سجل الآن

            </a>


            <a
                href="about.php"
                class="btn btn-outline">

                تعرف علينا أكثر

            </a>

        </div>

    </div>

</section>


<!-- =====================================================
     STATISTICS
===================================================== -->

<div class="stats-bar">

    <div class="stat-item">

        <h3>+500</h3>

        <p>
            أسرة مستفيدة
        </p>

    </div>


    <div class="stat-item">

        <h3>+200</h3>

        <p>
            يتيم مكفول
        </p>

    </div>


    <div class="stat-item">

        <h3>+50</h3>

        <p>
            مشروعًا منجزًا
        </p>

    </div>


    <div class="stat-item">

        <h3>+1000</h3>

        <p>
            متطوع
        </p>

    </div>

</div>


<!-- =====================================================
     VISION & MISSION
===================================================== -->

<section class="section">

    <div
        style="
            display:grid;
            grid-template-columns:
                repeat(auto-fit,minmax(300px,1fr));
            gap:30px;
            max-width:1000px;
            margin:0 auto;
        ">


        <!-- Vision -->

        <div
            style="
                background:
                    linear-gradient(
                        135deg,
                        var(--primary),
                        var(--primary-light)
                    );
                color:white;
                padding:40px;
                border-radius:20px;
                text-align:center;
            ">

            <div
                style="
                    font-size:50px;
                    margin-bottom:15px;
                ">

                👁️

            </div>


            <h2
                style="
                    font-size:24px;
                    margin-bottom:15px;
                ">

                رؤيتنا

            </h2>


            <p
                style="
                    font-size:16px;
                    line-height:2;
                    opacity:.95;
                ">

                مجتمع متكافل ومتعاون تتحسن فيه الظروف
                المعيشية للأسر المحتاجة، ويحصل أفراده
                على فرص التعليم والرعاية الصحية والتنمية
                والتمكين الاقتصادي.

            </p>

        </div>


        <!-- Mission -->

        <div
            style="
                background:white;
                padding:40px;
                border-radius:20px;
                box-shadow:var(--shadow);
                text-align:center;
                border-top:4px solid var(--secondary);
            ">

            <div
                style="
                    font-size:50px;
                    margin-bottom:15px;
                ">

                📜

            </div>


            <h2
                style="
                    font-size:24px;
                    margin-bottom:15px;
                    color:var(--primary);
                ">

                رسالتنا

            </h2>


            <p
                style="
                    font-size:16px;
                    line-height:2;
                    color:var(--text-light);
                ">

                تقديم المساعدات الإنسانية وتنفيذ البرامج
                والمشاريع التنموية المستدامة التي تستهدف
                الأسر المحتاجة والأيتام والنساء والشباب،
                مع تعزيز التكافل المجتمعي والشراكات
                من خلال الشفافية والاستدامة.

            </p>

        </div>

    </div>

</section>


<!-- =====================================================
     GOALS
===================================================== -->

<section
    class="section"
    style="
        background:white;
        margin:0;
        max-width:100%;
        padding:80px 5%;
    ">

    <div class="section-header">

        <h2>
            أهدافنا
        </h2>

        <p>
            نسعى لتحقيق رسالة هادفة تخدم المجتمع
            وتنمي موارده البشرية والمادية.
        </p>

        <div class="line"></div>

    </div>


    <div class="goals-grid">


        <div class="goal-card">

            <div class="goal-icon">
                🏠
            </div>

            <h3>
                دعم الأسر الفقيرة
            </h3>

            <p>
                دعم الأسر المحتاجة وتوفير
                المساعدات الأساسية لها.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                👶
            </div>

            <h3>
                كفالة الأيتام
            </h3>

            <p>
                كفالة ورعاية الأيتام والأرامل
                والفئات الأكثر احتياجًا.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                📚
            </div>

            <h3>
                دعم التعليم
            </h3>

            <p>
                دعم الطلاب المحتاجين وتشجيع
                التعليم والتطوير المهني.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                🏥
            </div>

            <h3>
                الرعاية الصحية
            </h3>

            <p>
                المساهمة في تقديم الخدمات الصحية
                والعلاج الطبي للمحتاجين.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                💼
            </div>

            <h3>
                التمكين الاقتصادي
            </h3>

            <p>
                تمكين الأسر اقتصاديًا من خلال
                المشاريع الصغيرة والمشاريع الإنتاجية.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                🎓
            </div>

            <h3>
                التدريب والتطوير
            </h3>

            <p>
                تدريب وتأهيل الشباب والنساء
                بالمهارات المهنية المختلفة.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                💧
            </div>

            <h3>
                مشاريع المياه
            </h3>

            <p>
                تنفيذ مشاريع المياه والصرف الصحي
                والبيئة وخدمة المجتمع.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                🚨
            </div>

            <h3>
                الإغاثة الطارئة
            </h3>

            <p>
                الاستجابة للكوارث والأزمات وتقديم
                المساعدات والإغاثة الطارئة.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                🤝
            </div>

            <h3>
                التطوع والتكافل
            </h3>

            <p>
                تشجيع المبادرات التطوعية وتعزيز
                التكافل والتعاون المجتمعي.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                🤲
            </div>

            <h3>
                الشراكات
            </h3>

            <p>
                بناء شراكات مع المؤسسات الحكومية
                والمنظمات غير الحكومية والقطاع الخاص.
            </p>

        </div>


    </div>

</section>


<!-- =====================================================
     ACTIVITIES
===================================================== -->

<section class="section">

    <div class="section-header">

        <h2>
            أنشطتنا ومشاريعنا
        </h2>

        <p>
            برامج ومشاريع نوعية تلبي الاحتياجات
            الحقيقية لمجتمعنا.
        </p>

        <div class="line"></div>

    </div>


    <div class="activities-grid">


        <div class="activity-card">

            <div
                class="activity-img"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        #e74c3c,
                        #c0392b
                    );
                ">

                👶

            </div>

            <div class="activity-content">

                <h3>
                    مشروع كفالة الأيتام
                </h3>

                <p>
                    كفالة الأيتام وتوفير احتياجاتهم
                    الأساسية من الغذاء والملابس والتعليم.
                </p>

            </div>

        </div>


        <div class="activity-card">

            <div
                class="activity-img"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        #27ae60,
                        #1e8449
                    );
                ">

                🏠

            </div>

            <div class="activity-content">

                <h3>
                    دعم الأسر المحتاجة
                </h3>

                <p>
                    دعم الأسر الفقيرة وتوفير المساعدات
                    المالية والعينية لها.
                </p>

            </div>

        </div>


        <div class="activity-card">

            <div
                class="activity-img"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        #f39c12,
                        #d68910
                    );
                ">

                🍞

            </div>

            <div class="activity-content">

                <h3>
                    مشروع السلة الغذائية
                </h3>

                <p>
                    توزيع السلال الغذائية والمساعدات
                    الموسمية على الأسر المحتاجة.
                </p>

            </div>

        </div>


        <div class="activity-card">

            <div
                class="activity-img"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        #9b59b6,
                        #8e44ad
                    );
                ">

                👕

            </div>

            <div class="activity-content">

                <h3>
                    مشروع كسوة العيد
                </h3>

                <p>
                    توفير الملابس الجديدة للأيتام
                    والأسر الفقيرة في المناسبات.
                </p>

            </div>

        </div>


        <div class="activity-card">

            <div
                class="activity-img"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        #3498db,
                        #2980b9
                    );
                ">

                🎒

            </div>

            <div class="activity-content">

                <h3>
                    مشروع الحقيبة والزي المدرسي
                </h3>

                <p>
                    توفير المستلزمات والزي المدرسي
                    للطلاب المحتاجين.
                </p>

            </div>

        </div>


        <div class="activity-card">

            <div
                class="activity-img"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        #1abc9c,
                        #16a085
                    );
                ">

                📖

            </div>

            <div class="activity-content">

                <h3>
                    المنح الدراسية
                </h3>

                <p>
                    دعم طلاب الجامعات والطلاب المتفوقين
                    من خلال المنح التعليمية.
                </p>

            </div>

        </div>


        <div class="activity-card">

            <div
                class="activity-img"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        #e67e22,
                        #d35400
                    );
                ">

                🏥

            </div>

            <div class="activity-content">

                <h3>
                    العلاج والعمليات الجراحية
                </h3>

                <p>
                    توفير العلاج الطبي والعمليات الجراحية
                    للمرضى المحتاجين.
                </p>

            </div>

        </div>


        <div class="activity-card">

            <div
                class="activity-img"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        #2c3e50,
                        #34495e
                    );
                ">

                💼

            </div>

            <div class="activity-content">

                <h3>
                    مشروع الأسر المنتجة
                </h3>

                <p>
                    دعم الأسر بالمشاريع الصغيرة التي
                    توفر مصدر دخل مستدام.
                </p>

            </div>

        </div>


        <div class="activity-card">

            <div
                class="activity-img"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        #16a085,
                        #1abc9c
                    );
                ">

                🎓

            </div>

            <div class="activity-content">

                <h3>
                    برامج التدريب المهني
                </h3>

                <p>
                    تأهيل الشباب والنساء بالمهارات
                    المهنية اللازمة لسوق العمل.
                </p>

            </div>

        </div>


        <div class="activity-card">

            <div
                class="activity-img"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        #2980b9,
                        #3498db
                    );
                ">

                💧

            </div>

            <div class="activity-content">

                <h3>
                    مشاريع المياه
                </h3>

                <p>
                    بناء الآبار وخزانات المياه
                    للمجتمعات المحتاجة.
                </p>

            </div>

        </div>


        <div class="activity-card">

            <div
                class="activity-img"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        #8e44ad,
                        #9b59b6
                    );
                ">

                🏚️

            </div>

            <div class="activity-content">

                <h3>
                    ترميم وتأهيل المساكن
                </h3>

                <p>
                    ترميم وتحسين مساكن الأسر
                    المحتاجة.
                </p>

            </div>

        </div>


        <div class="activity-card">

            <div
                class="activity-img"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        #c0392b,
                        #e74c3c
                    );
                ">

                🚨

            </div>

            <div class="activity-content">

                <h3>
                    حملات الإغاثة الطارئة
                </h3>

                <p>
                    الاستجابة السريعة للكوارث وتقديم
                    المساعدات والإغاثة الطارئة.
                </p>

            </div>

        </div>


    </div>

</section>


<!-- =====================================================
     CALL TO ACTION
===================================================== -->

<section class="cta-section">

    <h2>
        كن عضوًا فعالًا في جمعيتنا
    </h2>


    <p>

        مساهمتك الشهرية يمكن أن تحدث فرقًا حقيقيًا
        في حياة الأسر المحتاجة.

        <br>

        انضم إلينا في بناء مجتمع متكافل وداعم.

    </p>


    <a
        href="register.php"
        class="btn btn-primary"
        style="
            font-size:18px;
            padding:16px 40px;
        ">

        سجل الآن وكن جزءًا من التغيير

    </a>

</section>


<!-- =====================================================
     FOOTER
===================================================== -->

<?php include 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const toggle = document.getElementById('mobile-menu-toggle');
    const menu = document.querySelector('.navbar .nav-links');

    if (!toggle || !menu) return;

    toggle.addEventListener('change', function () {

        if (this.checked) {
            menu.style.display = 'flex';
        } else {
            menu.style.display = 'none';
        }

    });

});
</script>

</body>

</html>
