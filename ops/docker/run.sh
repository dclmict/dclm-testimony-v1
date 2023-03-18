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

## main code
cd /var/www

# make app run on /testimony/ location
if [ -e "/var/www/testimony" ]; then
  rm /var/www/testimony
  ln -s /var/www/public /var/www/testimony
else
  echo "creating symbolic link for testimony..."
  ln -s /var/www/public testimony
fi

# laravel something
# php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache
php artisan optimize

# start supervisord
/usr/bin/supervisord -c /etc/supervisord.conf