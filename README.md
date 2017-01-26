### PHP CLI SCRIPT FOR RESERVOIR SAMPLING ALGORITHM
USAGE:

```
php sampler.php
```
This command random generate 20 alphanum and then select 5 symbols from the generated string

```
php sampler.php 4
```
This command random generate 20 alphanum and then select 4 symbols from the generated string

```
php sampler.php random 5
```
This command fetch random string from the [random.org](https://www.random.org/clients/http/) and then select 5 symbols from the generated string

```
cat LICENSE.txt | php sampler.php 20
```
This command fetch STDIN (big amount of data can be fetched with it) and then select 20 symbols from the stream

:+1:
