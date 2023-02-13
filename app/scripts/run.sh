#!/bin/bash

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


# create dhparam for ssl
#openssl dhparam -out /etc/ssl/certs/dhparams.pem 4096

# make app run on /testimony/ location
rm testimony
ln -s /var/www/html/public testimony