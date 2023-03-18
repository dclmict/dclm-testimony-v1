#!/bin/sh

#
# ____          __  __  _____ 
# |  _ \   /\   |  \/  |/ ____|     https://github.com/opeoniye
# | |_) | /  \  | \  / | (___       https://opeoniye.vercel.app/
# |  _ < / /\ \ | |\/| |\___ \      credit: http://patorjk.com/software/taag/
# | |_) / ____ \| |  | |____) |
# |____/_/    \_\_|  |_|_____/ 
#                             
#
# Based on https://gist.github.com/2206527

## main code
cd /var/www

# make app run on /testimony/ location
file='testimony'
if [ -e $file ]; then
  rm testimony
  ln -s /www/html/public testimony
else
  echo "creating symbolic link for testimony..."
  ln -s /www/html/public testimony

fi

# laravel something
# php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache
php artisan optimize

# start supervisord
/usr/bin/supervisord -c /etc/supervisord.conf