### Installation

```php
composer install
```

Running Tests 

```php
# Phpsepc
./vendor/bin/phpspec run

# Behat

./vendor/bin/behat 
```


##### Not covered things

- expiry logic for the token (check and regenerate token if its expired)
- http or controller logic to access the endpoints 
- delete endpoint test (I am not sure how it should work within this test)