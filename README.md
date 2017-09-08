Oude "Mijnsportwedstrijden" php site

commando's:

docker run --name mysql -v db:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=hl7Yh875doida2Jy72ndsa -d mysql
docker run --name myadmin -d --link mysql:db -p 8080:80 phpmyadmin/phpmyadmin 
docker rm -f msw && docker build -t msw . && docker run -p 80:80 -d --link mysql:db --name msw msw
