### PHP CLI SCRIPT FOR RESERVOIR SAMPLING ALGORITHM
USAGE:
```
php sampler.php flow=0 k=5
```
This command will run default flow with random generating of 20 alphanum symbols and then select k symbols from the generated string

```
php sampler.php flow=1 k=5
```
This command will run second flow and will try to fetch random string from the [random.org](https://www.random.org/clients/http/) and then select k symbols from the generated string

```
cat LICENSE.txt | php sampler.php flow=2 k=20
```

This command will run first flow with STDIN, big amount of data can be fetched with this flow and then select k symbols from the stream

:+1: