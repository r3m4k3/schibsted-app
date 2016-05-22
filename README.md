DESCRIPTION:


REST API:
* with format agnostic - format depends on HTTP header - Content-Type
* agnostic DAL database persistence (now implemented only Doctrine ORM)
* 2nd level of Richardson Maturity Level
* unit tests
* secured with JWT.

CLIENT - very simple app made with jQuery, Twig and Symfony3.  

CONFIGURATION:

/* Added on 22.05 */
After composer install you have to change permissions to dirs var/cache/*, var/logs/*, var/sessions/* to 777.
You need too to create folder app/var/jwt (mkdir -p app/var/jwt from root dir).
I'm really sorry about this.
/* */

1. composer install
2. Set your database configuration parameters.
3. Import database schema (database.sql).
4. Create .htaccess file from .htaccess_copy.
Run these commands to generate key:
openssl genrsa -out app/var/jwt/private.pem -aes256 4096
openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem
5. Set your key passphrase in parameters.yml, e.g.:
    jwt_key_pass_phrase: 'test'


WARNING:
Geolocalization doesn't work for the newest Google Chrome without SSL. Please, test this functionality on another web browser.

Running tests: phpunit

