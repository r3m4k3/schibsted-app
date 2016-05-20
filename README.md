CONFIGURATION:

1. composer install
2. Set your database configuration parameters.
3. Import database schema (database.sql).
4. Create .htaccess file:

DirectoryIndex app.php
<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteCond %{HTTP:Authorization} ^(.*)
	RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]

	RewriteCond %{REQUEST_FILENAME} -f
	RewriteRule ^ - [L]

	RewriteRule ^bundles/(.*)$ /web/bundles/$1 [L]
	RewriteRule ^assets/(.*)$ /web/assets/$1 [L]
	RewriteRule ^ %{ENV:BASE}/web/app.php [L]
</IfModule>
	
5. openssl genrsa -out app/var/jwt/private.pem -aes256 4096
6. openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem
7. Set your key passphrase in parameters.yml, e.g.:
    jwt_key_pass_phrase: 'test'


WARNING:
Geolocalization doesn't work for the newest Google Chrome without SSL. Please, test this functionality on another web browser.