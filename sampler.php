<?php

echo "\033[32m ======================================================================\n";
echo "\033[32m PHP CLI SCRIPT FOR RESERVOIR SAMPLING ALGORITHM\n";
echo "\033[32m USAGE:\n";
echo "\033[32m\n";
echo "\033[32m 1) php sampler.php flow=0 k=5\n";
echo "\033[32m This command will run default flow with random generating of 20 alphanum symbols and then select k symbols from the generated string\n";
echo "\033[32m\n";
echo "\033[32m 2) php sampler.php flow=1 k=5\n";
echo "\033[32m This command will run second flow and will try to fetch random string from the random.org and then select k symbols from the generated string\n";
echo "\033[32m\n";
echo "\033[32m 3) cat LICENSE.txt | php sampler.php flow=2 k=20\n";
echo "\033[32m This command will run first flow with STDIN, big amount of data can be fetched with this flow and then select k symbols from the stream\n";
echo "\033[32m ======================================================================";
echo "\033[0m\n\n";

if (count($argv) < 3) {
    echo "Please specify all needed parameters: [flow,k]\n";
    exit();
}

define('DEFAULT_STREAM_LENGTH', 20);
define('DEFAULT_SAMPLE_SIZE', 5);

$flow = null;
$k = DEFAULT_SAMPLE_SIZE;

foreach ($argv as $key => $arg) {
    if ($key == 0) continue;

    list($argument, $value) = explode('=', $arg);
    if ($argument == 'flow') {
        $flow = $value;
    }
    if ($argument == 'k' && $value <= DEFAULT_STREAM_LENGTH) {
        $k = $value;
    }
}

if ($flow == 2) {
    $f = fopen('php://stdin', 'r');
    $characters = '';
    while( $line = fgets( $f ) ) {
        $characters .= $line;
    }
} elseif ($flow == 1) {
    $characters = file_get_contents('https://www.random.org/strings/?num=1&len=20&digits=on&upperalpha=on&loweralpha=off&unique=off&format=plain&rnd=new');
} else {
    $characters = random_str(DEFAULT_STREAM_LENGTH);
}
$characters = trim($characters);

if (strlen($characters) < DEFAULT_STREAM_LENGTH) {
    echo "Please generate at least ".DEFAULT_STREAM_LENGTH." symbols\n";
} else {
    $line = substr($characters, 0, DEFAULT_STREAM_LENGTH);
    echo "First ".strlen($line)." symbols of the stream: ", $line, "\n";
    //
    //  FUNCTION IS HERE
    //
    echo implode('', selectKItems($characters, $k)), "\n";
}

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    if ($max < 1) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[rand(0, $max)];
    }
    return $str;
}

// An efficient program to randomly select k items from a stream of items
// http://www.geeksforgeeks.org/reservoir-sampling/
// https://en.wikipedia.org/wiki/Reservoir_sampling
// Time Complexity: O(n)
function selectKItems($stream, $k)
{
    // reservoir[] is the output array. Initialize it with
    // first k elements from stream[]
    $reservoir = [];
    for ($i = 0; $i < $k; $i++) {
        $reservoir[$i] = $stream[$i];
    }

    for ($i = $k; $i < strlen($stream); $i++) {
        // Pick a random index from 0 to i.
        $j = mt_rand(0, $i);

        // If the randomly picked index is smaller than k, then replace
        // the element present at the index with new element from stream
        if ($j < $k) {
            $reservoir[$j] = $stream[$i];
        }
    }
    return $reservoir;
}
