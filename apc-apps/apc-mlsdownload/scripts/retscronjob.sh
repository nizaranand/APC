#!/bin/sh
#
# execute this to update all feeds to database with cron job
#
cd /var/www/viele
php -q ./run_interactive_job.php batch_control_files/GGAR_Property

