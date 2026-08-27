FROM php:8.2-apache

# تثبيت وتفعيل امتداد قواعد البيانات
RUN docker-php-ext-install mysqli pdo_mysql

# تعديل بورت أباتشي ليتوافق مع بورت Railway المتغير
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# نسخ ملفات المشروع
COPY . /var/www/html/

# ضبط الصلاحيات
RUN chown -R www-data:www-data /var/www/html
