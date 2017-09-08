Oude "Mijnsportwedstrijden" php site

commando's:

docker run --name some-mysql -e MYSQL_ROOT_PASSWORD=my-secret-pw -d mysql
docker run --name myadmin -d --link some-mysql:db -p 8080:80 phpmyadmin/phpmyadmin 
docker rm -f msw && docker build -t msw . && docker run -p 80:80 -d --link some-mysql:db --name msw msw
 