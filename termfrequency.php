<?php
define('MIN_FREQ', 200);
$stop_words_filename = "stop_words.txt";

//check correctness of file and command
if(!$argv[1])
{
    echo "No text file argument in the command!\n";
    exit();
}
else if(!is_file($argv[1])){
    echo "File does not exist!\n";
    exit();
}
if (!is_file($stop_words_filename))
{
    echo "stop_words file does not exist!\n";
    exit();
}

$file = file($argv[1]);
$stop_words = explode(',', file_get_contents($stop_words_filename));
//make the stop words as key other than value
$stop_words_flip = array();
foreach($stop_words as $_stop_word){
    $stop_words_flip[$_stop_word] = 1;
}

//get frequency of words
foreach($file as $_temp)
{
    preg_match_all("/[a-zA-Z]{2,}/", $_temp, $_matches);
    foreach($_matches[0] as $_term)
    {
        $_term = strtolower($_term);
        if(!$stop_words_flip[$_term])
            $term_freq[$_term]++;
    }
}

arsort($term_freq);

//display
foreach($term_freq as $_key => $_val)
{
    if($_val > MIN_FREQ)
       echo $_key."  -  ".$_val."\n";
}
