### PHP CLI SCRIPT FOR RESERVOIR SAMPLING ALGORITHM
USAGE:

```
php sampler.php
```
This command will run random generating of 20 alphanum and then select 5 symbols from the generated string

```
php sampler.php k=4
```
This command will run random generating of 20 alphanum and then select k=4 symbols from the generated string

```
php sampler.php flow=0 k=5
```
This command will run flow with random generating of 20 alphanum symbols and then select k=5 symbols from the generated string

```
php sampler.php flow=1 k=5
```
This command will try to fetch random string from the [random.org](https://www.random.org/clients/http/) and then select k=5 symbols from the generated string

```
cat LICENSE.txt | php sampler.php flow=2 k=20
```
This command will run flow with STDIN (big amount of data can be fetched with it) and then select k=20 symbols from the stream

:+1:
