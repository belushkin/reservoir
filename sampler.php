<?php

echo "\033[32m ======================================================================\n";
echo "\033[32m PHP CLI SCRIPT FOR RESERVOIR SAMPLING ALGORITHM\n";
echo "\033[32m USAGE:\n";
echo "\033[32m\n";
echo "\033[34m php sampler.php\n";
echo "\033[32m This command random generate 20 alphanum and then select 5 symbols from the generated string\n";
echo "\033[34m php sampler.php 4\n";
echo "\033[32m This command random generate 20 alphanum and then select 4 symbols from the generated string\n";
echo "\033[34m php sampler.php random 5\n";
echo "\033[32m This command fetch random string from the random.org and then select 5 symbols from the generated string\n";
echo "\033[34m cat LICENSE.txt | php sampler.php 20\n";
echo "\033[32m This command fetch STDIN (big amount of data can be fetched with it) and then select 20 symbols from the stream\n";
echo "\033[32m ======================================================================";
echo "\033[0m\n\n";

define('DEFAULT_STREAM_LENGTH', 20);
define('DEFAULT_SAMPLE_SIZE', 5);

$flow = null;
$k = DEFAULT_SAMPLE_SIZE;

//////////////////////////////////////////////////////////////
// WORKING WITH ARGUMENTS
//////////////////////////////////////////////////////////////
foreach ($argv as $key => $arg) {
    if ($key == 0) continue;
    if (intval($arg) > 0 && $arg <= DEFAULT_STREAM_LENGTH) {
        $k = $arg;
    }
    if ($arg == 'random' ) {
        $flow = $arg;
    }
}

//////////////////////////////////////////////////////////////
// CHECK IF STDIN EXISTS
//////////////////////////////////////////////////////////////
$characters = '';
$f = fopen('php://stdin', 'r');
$read   = array($f);
$write  = null;
$except = null;
if ( stream_select( $read, $write, $except, 0 ) === 1 ) {
    while ($line = fgets( $f )) {
        $characters .= $line;
    }
}
fclose($f);

//////////////////////////////////////////////////////////////
// CHOOSE FLOW
//////////////////////////////////////////////////////////////
if ($characters) {

} elseif ($flow == 'random') {
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
