<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="ar" dir="ltr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Saadi Charity Development Association - Aden</title>

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
            alt="Saadi Charity Association Logo"
            class="logo-img">

        <span>Saadi Charity Association</span>

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
        aria-label="Open menu">

        ☰

    </label>


    <!-- Navigation Links -->

    <ul class="nav-links">

        <li>

            <a href="index.php"
               class="active">

                Home

            </a>

        </li>


        <li>

            <a href="about.php">

                About Us

            </a>

        </li>


        <li>

            <a href="activities.php">

                Our Activities

            </a>

        </li>


        <li>

            <a href="register.php">

                Membership

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

                            📋 My Account

                        </a>

                    </li>


                    <li>

                        <a href="member_subscriptions.php">

                            📅 My Subscriptions

                        </a>

                    </li>


                    <li>

                        <a href="member_payments.php">

                            💳 My Payments

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

                            🚪 Logout

                        </a>

                    </li>

                </ul>

            </li>


        <?php else: ?>

            <li>

                <a
                    href="login.php"
                    class="btn-nav">

                    Login

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

        left: 0;

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

            Together We Build

            <span>
                A Caring Community
            </span>

        </h1>


        <p>

            Saadi Charity Development Association - Aden

            <br>

            We strive to provide humanitarian assistance
            and implement development programs and projects
            for families in need, orphans, women, and youth.

        </p>


        <div class="hero-btns">

            <a
                href="register.php"
                class="btn btn-primary">

                📝 Register Now

            </a>


            <a
                href="about.php"
                class="btn btn-outline">

                Learn More About Us

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
            Beneficiary Families
        </p>

    </div>


    <div class="stat-item">

        <h3>+200</h3>

        <p>
            Sponsored Orphans
        </p>

    </div>


    <div class="stat-item">

        <h3>+50</h3>

        <p>
            Completed Projects
        </p>

    </div>


    <div class="stat-item">

        <h3>+1000</h3>

        <p>
            Volunteers
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

                Our Vision

            </h2>


            <p
                style="
                    font-size:16px;
                    line-height:2;
                    opacity:.95;
                ">

                A caring and cooperative community
                where the living conditions of families
                in need are improved, with access to
                education, healthcare, development
                opportunities, and economic empowerment.

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

                Our Mission

            </h2>


            <p
                style="
                    font-size:16px;
                    line-height:2;
                    color:var(--text-light);
                ">

                To provide humanitarian assistance
                and implement sustainable development
                programs and projects targeting families
                in need, orphans, women, and youth,
                while strengthening community solidarity
                and partnerships through transparency
                and sustainability.

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
            Our Goals
        </h2>

        <p>
            We strive to achieve a meaningful mission
            that serves the community and develops
            human and material resources.
        </p>

        <div class="line"></div>

    </div>


    <div class="goals-grid">


        <div class="goal-card">

            <div class="goal-icon">
                🏠
            </div>

            <h3>
                Supporting Poor Families
            </h3>

            <p>
                Supporting families in need
                and providing them with
                essential assistance.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                👶
            </div>

            <h3>
                Orphan Sponsorship
            </h3>

            <p>
                Sponsoring and caring for orphans,
                widows, and the most vulnerable groups.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                📚
            </div>

            <h3>
                Education Support
            </h3>

            <p>
                Supporting students in need
                and encouraging education
                and professional development.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                🏥
            </div>

            <h3>
                Healthcare
            </h3>

            <p>
                Contributing to healthcare services
                and medical treatment for people in need.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                💼
            </div>

            <h3>
                Economic Empowerment
            </h3>

            <p>
                Empowering families economically
                through small businesses and
                productive family projects.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                🎓
            </div>

            <h3>
                Training & Development
            </h3>

            <p>
                Training and preparing youth
                and women with professional skills.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                💧
            </div>

            <h3>
                Water Projects
            </h3>

            <p>
                Implementing water, sanitation,
                environmental, and community
                service projects.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                🚨
            </div>

            <h3>
                Emergency Relief
            </h3>

            <p>
                Responding to disasters and crises
                and providing emergency assistance.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                🤝
            </div>

            <h3>
                Volunteering & Solidarity
            </h3>

            <p>
                Encouraging volunteer initiatives
                and promoting solidarity and cooperation.
            </p>

        </div>


        <div class="goal-card">

            <div class="goal-icon">
                🤲
            </div>

            <h3>
                Partnerships
            </h3>

            <p>
                Building partnerships with government
                institutions, NGOs, and the private sector.
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
            Our Activities & Projects
        </h2>

        <p>
            Quality programs and projects that address
            the real needs of our community.
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
                    Orphan Sponsorship Project
                </h3>

                <p>
                    Sponsoring orphans and providing
                    their basic needs including food,
                    clothing, and education.
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
                    Support for Families in Need
                </h3>

                <p>
                    Supporting poor families and
                    providing financial and
                    in-kind assistance.
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
                    Food Basket Project
                </h3>

                <p>
                    Distributing food baskets and
                    seasonal assistance to families
                    in need.
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
                    Eid Clothing Project
                </h3>

                <p>
                    Providing new clothing for orphans
                    and poor families during special occasions.
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
                    School Bag & Uniform Project
                </h3>

                <p>
                    Providing school supplies and
                    uniforms for students in need.
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
                    Educational Scholarships
                </h3>

                <p>
                    Supporting university students
                    and outstanding students through
                    educational scholarships.
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
                    Medical Treatment & Surgery
                </h3>

                <p>
                    Providing medical treatment and
                    surgical operations for patients
                    in need.
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
                    Productive Families Project
                </h3>

                <p>
                    Supporting families with small
                    businesses that generate
                    sustainable income.
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
                    Vocational Training Programs
                </h3>

                <p>
                    Preparing youth and women
                    with professional skills
                    for employment.
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
                    Water Projects
                </h3>

                <p>
                    Building wells and water tanks
                    for communities in need.
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
                    Housing Rehabilitation
                </h3>

                <p>
                    Renovating and improving homes
                    for families in need.
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
                    Emergency Relief Campaigns
                </h3>

                <p>
                    Rapid response to disasters
                    and providing emergency relief.
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
        Become an Active Member of Our Association
    </h2>


    <p>

        Your monthly contribution can make
        a real difference in the lives of families in need.

        <br>

        Join us in building a caring and supportive community.

    </p>


    <a
        href="register.php"
        class="btn btn-primary"
        style="
            font-size:18px;
            padding:16px 40px;
        ">

        Register Now & Be Part of the Change

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
