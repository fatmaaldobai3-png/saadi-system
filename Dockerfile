FROM php:8.2-apache

# تثبيت وتفعيل امتداد قواعد البيانات
RUN docker-php-ext-install mysqli pdo_mysql

# نسخ جميع الملفات إلى مجلد الويب الافتراضي لأباتشي
COPY . /var/www/html/

# ضبط صلاحيات المجلدات لتجنب أي مشاكل بالوصول
RUN chown -R www-data:www-data /var/www/html
