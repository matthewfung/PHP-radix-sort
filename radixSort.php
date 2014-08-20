<?php
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function fillArray(){
	$array = array();
	for($i=0; $i<10000; $i++){
		$array[] = rand(0,9999);
	}
	return $array;
}

function radixSort($array){
	//Create a bucket of arrays
	$bucket = array_fill(0, 9, array());
	$maxDigits = 0;
	//Determine the maximum number of digits in the given array.
	foreach($array as $value){
		$numDigits = strlen((string)$value);
		if($numDigits > $maxDigits)
			$maxDigits = $numDigits;
	}
	$nextSigFig = false;
	for($k=0; $k<$maxDigits; $k++){
		for($i=0; $i<count($array); $i++){
			if(!$nextSigFig)
				$bucket[$array[$i]%10][] =  $array[$i];
			else
				$bucket[floor(($array[$i]/pow(10,$k)))%10][] =  $array[$i];
		}
		//Reset array and load back values from bucket.
		$array = array();
		for($j=0; $j<count($bucket); $j++){
			foreach($bucket[$j] as $value){
				$array[] = $value;
			}
		}
		//Reset bucket
		$bucket = array_fill(0, 9, array());
		$nextSigFig= true;
	}
	return $array;
}

$time_start = microtime_float();
$array = radixSort(fillArray());
$time_end = microtime_float();
$duration = $time_end - $time_start;
echo $duration;

//Finishes sorting 10000 elements in ~0.68 seconds
var_dump($array); 

?>