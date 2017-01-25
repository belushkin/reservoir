PHP CLI SCRIPT FOR RESERVOIR SAMPLING ALGORITHM\n
USAGE:
1) php sampler.php flow=0 k=5
This command will run default flow with random generating of 20 alphanum symbols and then select k symbols from the generated string

2) php sampler.php flow=1 k=5
This command will run second flow and will try to fetch random string from the random.org and then select k symbols from the generated string

3) cat LICENSE.txt | php sampler.php flow=2 k=20
This command will run first flow with STDIN, big amount of data can be fetched with this flow and then select k symbols from the stream

