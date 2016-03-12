Symfony3 RESTful API
===========



Security Check
```
php bin/console security:check
```

Symfony show all routes
```
php bin/console debug:router
```

Symfony clear cache
```
bin/console cache:clear --no-debug --env=prod
```


### Database


Build database
```
sudo -u www-data bin/console doctrine:migrations:status
sudo -u www-data bin/console doctrine:migrations:migrate
```

Load fixtures
```
bin/console doctrine:fixtures:load -n --env=dev
```



### Testing Setup


install phantomjs

```bash
cd bin/phantomjs
wget https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2
tar jxvf phantomjs-2.1.1-linux-x86_64.tar.bz2
cp phantomjs-2.1.1-linux-x86_64/bin/phantomjs /usr/local/bin/
chmod +x /usr/local/bin/phantomjs
```

start/stop phantomjs

```bash
bin/phantomjs/start.sh
```


Config
```
cp codeception.yml.dist codeception.yml
```


Run build after updating yml files (eg. adding a module to `unit.suite.yml`)
```
vendor/codeception/codeception/codecept build
```




### Running Tests

```
vendor/bin/codecept run unit
vendor/bin/codecept run api
```


### API Docs

```
http://api.symfony3.dev/api/doc
```