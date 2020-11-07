<?php

//--------------------------------------------------------------------
function numOfquestions($data){
	/*
	$data: is an array
	Last Item in the array is not a question, but the student answers.
	*/

	return count($data) - 1;
}

//--------------------------------------------------------------------
function numTcases($io,$data)
{
	$tc = $io;
	$cases = array();
	for($n=0; $n<count($data); $n++)
	{
		$tmp = $tc.($n+1); //Because field is define as input[1-9]*
		if(array_key_exists($tmp,$data))
		{
			array_push($cases,$data[$tmp]);
		}
	}
	return $cases;
}

//--------------------------------------------------------------------
function numTCasesPquestion($type,$qnum,$data)
{

	$TCpQ = array();
	switch($type){
		case "i":
			for($idx=0; $idx<$qnum; $idx++)
			{	array_push($TCpQ,numTcases("input",$data[$idx])); }
			break;
		case "o":
			for($idx=0; $idx<$qnum; $idx++)
			{	array_push($TCpQ,numTcases("output",$data[$idx]));	}
			break;
	}
	return $TCpQ;
}

//--------------------------------------------------------------------
function idConstranints($data)
{
	/*
		Flag will be dealt in BIN format e.g. 001, 110, 111, 100, etc.

		FOR|PRINT|WHILE
		 1    1     1
	*/
	$constraint =array("for","print","while");
	$constraintValue = array(4,2,1);
	$cFlag = 0;

	//FLAGS
	for($idx =0; $idx<count($constraint); $idx++)
	{
		if(array_key_exists($constraint[$idx],$data))
		{
			if($data[$constraint[$idx]] == 1)
			{	$cFlag += $constraintValue[$idx];	}
		}
	}
	return $cFlag;
}

//--------------------------------------------------------------------

function constrainsPerQuestion($qnum, $data)
{
	$flags = array();
	for($idx=0; $idx<$qnum; $idx++)
	{
		array_push($flags,idConstranints($data[$idx]));
	}
	return $flags;
}

//--------------------------------------------------------------------

function questionsWorth($qn, $data)
{
	$q = array("q","w");
	$worth = array();

	for($idx=0; $idx<$qn; $idx++)
	{
		$tmp = $q[0].($idx+1).$q[1];
		if(array_key_exists($tmp, $data))
		{
			array_push($worth,$data[$tmp]);
		}
	}
	return $worth;
}

//--------------------------------------------------------------------
function substractPquestion($info)
{
	//Function name is a TESTING Standard
	//Numer of Test Cases is a TESTING Standard
	//Number of Constraints Flags is a TESTING Standard
	$pointsPerQuestion = array();
	$counter = 0;
	for($idx=0; $idx<$info["qnum"]; $idx++)
	{
		//Function name
		$counter += 1;
		//Colon Symbol Check
		$counter += 1;
		//TestCases
		$counter += count($info["TCipQ"][$idx]);
		//echo "tc:".$counter."\n";
		//Constraints
		switch($info["CfpQ"][$idx] & 7)
		{
			case 1:
				//echo "cn1";
			case 2:
				//echo "cn2";
			case 4:
				//echo "cn4";
				//Only 1 out of 3 flags was setup
				$counter += 1;
				break;
			case 3:
				 //echo"cn3";
			case 5:
				//echo "cn5";
			case 6:
				//echo "cn6";
				//Only 2 out of 3 flags were setup
				$counter += 2;
				break;
			case 7:
				//echo "cn7";
				//All 3 flags were set up
				$counter += 3;
				break;
			default:
				//echo "cn0";
				//No flags were set up
				$counter += 0;
				break;
		}
		// -- Calculate
		//echo "cnst: ".$counter."\n";
		array_push($pointsPerQuestion, $info["qworth"][$idx]/$counter);
		//array_push($pointsPerQuestion,$counter);

		//echo "--".$pointsPerQuestion[$idx]."--\n";
		$counter = 0;
	}
	return $pointsPerQuestion;
}
//--------------------------------------------------------------------

function questionsName($qnum, $data)
{
	$q = "questionName";
	$names = array();
	for($idx=0; $idx<$qnum; $idx++)
	{
		if(array_key_exists($q,$data[$idx]))
		{
			array_push($names,$data[$idx][$q]);
		}
	}
	return $names;
}

//--------------------------------------------------------------------
function studAnswers($qnum, $data)
{
	$q = "q";
	$ans = array();
	for($idx=0; $idx<$qnum; $idx++)
	{
		$tmp = $q.($idx+1);
		if(array_key_exists($tmp,$data))
		{
			array_push($ans,$data[$tmp]);
		}
	}
	return $ans;
}
//--------------------------------------------------------------------

?>
