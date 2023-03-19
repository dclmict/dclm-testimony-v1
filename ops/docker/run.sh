#!/bin/sh

#
# ____          __  __  _____ 
# |  _ \   /\   |  \/  |/ ____|     repo:     https://github.com/opeoniye
# | |_) | /  \  | \  / | (___       porfolio: https://opeoniye.vercel.app/
# |  _ < / /\ \ | |\/| |\___ \      credit:   http://patorjk.com/software/taag/
# | |_) / ____ \| |  | |____) |
# |____/_/    \_\_|  |_|_____/ 
#                             
#
# Based on https://gist.github.com/2206527

# laravel something
cd /var/www
php artisan cache:clear
php artisan route:cache
php artisan optimize
# php artisan migrate:fresh --seed

# start supervisord
/usr/bin/supervisord -c /etc/supervisord.conf

# make app run on /testimony/ location
if [ -e "/var/www/testimony" ]; then
  echo "recreating /testimony symbolic link..."
  cd /var/www/public
  rm /var/www/testimony
  ln -s /var/www/public testimony
  chown -R www:www-data /var/www/public/testimony
  cd /var/www
else
  echo "creating symbolic link for testimony..."
  cd /var/www/public
  ln -s /var/www/public testimony
  chown -R www:www-data /var/www/public/testimony
  cd /var/www
fi