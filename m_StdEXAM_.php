<?php

include "m_curlFunction_.php";
include "ParseOBJ_Grading.php";



//------------------- Python File Function ------------------------------

function py_file_setup($filePath_, $student_CODE, $function_ASKED, $test_Cases, $constraintFlag)
{
	//Flag
	$FileSetUp = 0;

	//File Obj
	$testFile = $filePath_;
	$fileObj = fopen($testFile,"w+");

	//Call statement
	$call_statement = "";

	if($fileObj)
	{
		//Write the Student function
		fwrite($fileObj, $student_CODE);

		//Check for PRINT constrains flag.
		switch($constraintFlag & 2)
		{
			case 2:
				//Print Statement insdie function so just call function.
				if (strpos($student_CODE, "print("))
				{
					$call_statement = $call_statement."\n".$function_ASKED."(".$test_Cases.")";
					break;
				}

			default:
				//Write PRINT statement -- In order to obtain result in stdout.
				$call_statement = $call_statement."\nprint(".$function_ASKED."(".$test_Cases."))";
				break;
		}

		fwrite($fileObj, $call_statement);

		//Close file - NO more writing in it.
		fclose($fileObj);

		//Change flag to True
		$FileSetUp = 1;

	}

	return $FileSetUp;
}

//------------------- Function Name Grading ------------------------------
function FunName($fname, $stdAns)
{
	$correct = false;

	/*
		Becasue strpos() ids the substring but it does not check if there are
		more chars in the string we need to put a limit. Which in this case
		is the first parenthesis.
	*/

	$fname_wLimit = $fname."(";

	if(strpos($stdAns, $fname_wLimit)){ $correct = true;}
	return $correct;
}

//---------- GET NEWLY DEFINE FUNCTION NAME BY STUDENT ------------------
function newFunName($stdAns)
{
	$posPrth = strpos($stdAns,"("); //Locate opening parenthesis
	$def_Len = 4;				//in PY def + White spage = 4
	$goUpto = $posPrth - $def_Len;	//Lenght of the string search.
	//Get Name
	$newName = substr($stdAns,$def_Len,$goUpto);

	return $newName;
}

//------------------- Constraints Grading ------------------------------
function qConstraintsGrd($cFlag, $stdAns, $points)
{
	//Take into account that the constraints cannot be in pos zero(0)
	$result = array("for"=>0, "print"=>0, "while"=>0);

	//Constraints
	switch($cFlag & 7)
	{
		case 1://001
			if(!strpos($stdAns,"while")){$result["while"]=$points;}
			break;

		case 2://010
			if(!strpos($stdAns,"print")){$result["print"]=$points;}
			break;

		case 4://100
			if(!strpos($stdAns,"for")){$result["for"]=$points;}
			break;

		case 3://011
			if(!strpos($stdAns,"while")){$result["while"]=$points;}
			if(!strpos($stdAns,"print")){$result["print"]=$points;}
			break;

		case 5://101
			if(!strpos($stdAns,"while")){$result["while"]=$points;}
			if(!strpos($stdAns,"for")){$result["for"]=$points;}
			break;

		case 6://110
			if(!strpos($stdAns,"for")){$result["for"]=$points;}
			if(!strpos($stdAns,"print")){$result["print"]=$points;}
			break;

		case 7://111
			if(!strpos($stdAns,"while")){$result["while"]=$points;}
			if(!strpos($stdAns,"print")){$result["print"]=$points;}
			if(!strpos($stdAns,"for")){$result["for"]=$points;}
			break;
	}

	return $result;
}

//------------------- Python Function ------------------------------
function ExePython($PythonFile, $_Info, $questionIDX, $newQnames)
{
	// -- File Path --
	$filePath = $PythonFile;

	//-------------
	$compile_code_results = array();

	//Loop every Question in exam

	//Loop TestCases related to the Question being asked
	//And run each indivual TestCase related to question.
	for($c=0; $c< count($_Info["TCipQ"][$questionIDX]); $c++)
	{
	 	if(py_file_setup($filePath, 
				 $_Info["StudAnswers"][$questionIDX],
				 $newQnames,
				 $_Info["TCipQ"][$questionIDX][$c], 
				 $_Info["CfpQ"][$questionIDX]))
		{
			$command = "python ".$filePath;
			//Store Executed Python Code
			array_push($compile_code_results, shell_exec($command));
		}
	}

	return $compile_code_results;

}

//------------------------------------------------------------------

function colonPFL($StudAnswers)
{
	//Colon Presnet First Line - colonPFL
	$present = false;
	/*
	We know the first colon should be in the first line.
	Then, lets break the student answer into an array where the first
	item should be the first line.
	String to be breaken by "\n" delimitant.
	if the first item does not have the colon then its wrong by the student.
	*/

	$regx = "/\n/";
	$str_array =  preg_split($regx, $StudAnswers);

	if(strpos($str_array[0], ":")) { $present = true;}

	return $present;
}

//------------------------------------------------------------------
function commentsConstraints(&$cArray, $cPoints, $cFlag)
{
	//Constraints
	switch($cFlag & 7)
	{
		case 1://001
			if($cPoints["while"] >0 ){array_push($cArray,"- FAIL, WHILE constraint no applied.");}
			else {array_push($cArray,"- PASS, WHILE constraint applied.");}
			break;

		case 2://010
			if($cPoints["print"] >0 ){array_push($cArray,"- FAIL, PRINT constraint no applied.");}
			else {array_push($cArray,"- PASS, PRINT constraint applied.");}
			break;

		case 4://100
			if($cPoints["for"] >0 ){array_push($cArray,"- FAIL, FOR constraint no applied.");}
			else {array_push($cArray,"- PASS, FOR constraint applied.");}
			break;

		case 3://011
			if($cPoints["while"] >0 ){array_push($cArray,"- FAIL, WHILE constraint no applied.");}
			else {array_push($cArray,"- PASS, WHILE constraint applied.");}
			if($cPoints["print"] >0 ){array_push($cArray,"- FAIL, PRINT constraint no applied.");}
			else {array_push($cArray,"- PASS, PRINT constraint applied.");}
			break;

		case 5://101
			if($cPoints["while"] >0 ){array_push($cArray,"- FAIL, WHILE constraint no applied.");}
			else {array_push($cArray,"- PASS, WHILE constraint applied.");}
			if($cPoints["for"] >0 ){array_push($cArray,"- FAIL, FOR constraint no applied.");}
			else {array_push($cArray,"- PASS, FOR constraint applied.");}
			break;

		case 6://110
			if($cPoints["print"] >0 ){array_push($cArray,"- FAIL, PRINT constraint no applied.");}
			else {array_push($cArray,"- PASS, PRINT constraint applied.");}
			if($cPoints["for"] >0 ){array_push($cArray,"- FAIL, FOR constraint no applied.");}
			else {array_push($cArray,"- PASS, FOR constraint applied.");}
			break;

		case 7://111
			if($cPoints["while"] >0 ){array_push($cArray,"- FAIL, WHILE constraint no applied.");}
			else {array_push($cArray,"- PASS, WHILE constraint applied.");}
			if($cPoints["print"] >0 ){array_push($cArray,"- FAIL, PRINT constraint no applied.");}
			else {array_push($cArray,"- PASS, PRINT constraint applied.");}
			if($cPoints["for"] >0 ){array_push($cArray,"- FAIL, FOR constraint no applied.");}
			else {array_push($cArray,"- PASS, FOR constraint applied.");}
			break;
	}


}

//------------------------------------------------------------------
function addColonFL($studAns)
{
	$text = "";
	//Split $studAns into lines per "\n"
	$regx = "/\n/";
	$str_array =  preg_split($regx, $studAns);
	//Add colon
	$str_array[0] = substr_replace($str_array[0], ":", strlen($str_array[0]), 0);
	//Concat all pieces.
	foreach($str_array as $line) { 	$text = $text.$line."\n";	}
	//Add "\n" at the end of entire student answer.
	$text =  $text."\n";

	return $text;
}

//------------------- Grading Function ------------------------------


function Grading($indata, $_Info)
{
	/*
		This var will be used to prevent the PY script from running into
		name definition problems when executing, in regards to the Function name.
	*/
	$qname = array();

	/*
		$criteria_point - ARRAY - holds the grade per question per criteria
		$grades - ARRAY - holds all the grades

		$grades = [ $criteria_point, $criteria_point, ....];
	*/
	$criteria_point = array("fnamePoints"=>0,
				"fname"=>"",
				"Syntax" => 0, //Colon Mark
				"TestCases" => array(),
				"Constraints" => array(),
				"Comments" => array(),
				"StudOutput" => array(),
				"PointsLost" => 0);

	$grades = array();

	$ExamPoints = 0;

	//----------------STRART GRADING---------------------------------

	for($idx = 0; $idx < $_Info["qnum"]; $idx++)
	{
		//THE STUDENT ANSWER IS NOT EMPTY.
		if($_Info["StudAnswers"][$idx] !== '')
		{
			// --- GRADE FUNCTION NAME ----
			if(!FunName($_Info["qname"][$idx], $_Info["StudAnswers"][$idx]))
			{
				//BAD FUNCTION NAME
				$criteria_point["fnamePoints"] = $_Info["PpQ"][$idx]; // POINTS DEDUCTED
				array_push($qname,newFunName($_Info["StudAnswers"][$idx])); // NEW FUNCTION NAME
				array_push($criteria_point["Comments"],"- FAIL, function name"); //COMMENT
				$criteria_point["fname"] = $qname[$idx]; //STORING FUNCTION NAME
			}
			else{
				//GOOD FUNCTION NAME
				$criteria_point["fnamePoints"] = 0; // POINTS DEDUCTED
				array_push($qname,$_Info["qname"][$idx]); // FUNCTION NAME
				array_push($criteria_point["Comments"],"- PASS, function name"); //COMMENT
				$criteria_point["fname"] = $qname[$idx]; //STORING FUNCTION NAME
			}

			// --- COLON MARK ----
			if(colonPFL($_Info["StudAnswers"][$idx]))
			{
				//GOOD, : is present.
				$criteria_point["Syntax"] = 0; // POINTS DEDUCTED
				array_push($criteria_point["Comments"],"- PASS, Colon present in first line"); //COMMENT
			}
			else
			{
				//BAD, : is not present.
				$criteria_point["Syntax"]= $_Info["PpQ"][$idx];// POINTS DEDUCTED
				array_push($criteria_point["Comments"],"- FAIL, Colon is not present in first line"); //COMMENT
				//FIX Student Code (add colon to first line)
				$_Info["StudAnswers"][$idx] = addColonFL($_Info["StudAnswers"][$idx]);
			}


			// --- GRADE CONSTRAINTS ----
			foreach(qConstraintsGrd($_Info["CfpQ"][$idx], $_Info["StudAnswers"][$idx], $_Info["PpQ"][$idx]) as $Cpoint)
			{
				array_push($criteria_point["Constraints"],$Cpoint);
			}

			//ADDING COMMENTS TO CONSTRAINTS
			commentsConstraints($criteria_point["Comments"], $criteria_point["Constraints"], $_Info["CfpQ"][$idx]);

			// --- CODE EXECUTION (TEST CASES)----
			$std_tmp_code_result = ExePython("./02_evaluate/written.py", $_Info, $idx, $qname[$idx]);

			//Compare Std_results with TCoutput
			for($a =0; $a < count($_Info["TCopQ"][$idx]); $a++)
			{
				//Remove "\n" created when Python prints.
				$std_tmp_code_result[$a] = preg_split('/\n/',$std_tmp_code_result[$a])[0];

				//str_replace use becuase STRINGS and CHARS will come from DB with quotes in it.
				if($std_tmp_code_result[$a] == str_replace('"','',$_Info["TCopQ"][$idx][$a]))
				{
					$tmp_comment = "- PASS, Result: ".$std_tmp_code_result[$a]." | Expected: ".str_replace('"','',$_Info["TCopQ"][$idx][$a]);
					array_push($criteria_point["StudOutput"],$std_tmp_code_result[$a]); //STUD Output
					array_push($criteria_point["TestCases"],0); //POINTS
					array_push($criteria_point["Comments"],$tmp_comment); //COMMENT
					//echo $tmp_comment."\n";
				}
				else
				{
					$tmp_comment = "- FAIL, Result: ".$std_tmp_code_result[$a]." | Expected: ".str_replace('"','',$_Info["TCopQ"][$idx][$a]);
					array_push($criteria_point["StudOutput"],$std_tmp_code_result[$a]); //STUD Output
					array_push($criteria_point["TestCases"],$_Info["PpQ"][$idx]); //POINTS
					array_push($criteria_point["Comments"],$tmp_comment); //COMMENT
				}
			}

		}

			//THE STUDENT ANSWER IS EMPTY
		else
		{
			//Function Name Points
			$criteria_point["fnamePoints"] = $_Info["PpQ"][$idx]; // POINTS
			array_push($criteria_point["Comments"],"- FAIL, no function name given");// COMMENT
			//Function Name
			array_push($qname," "); // FUNCTION NAME
			//Colon Mark Points
			$criteria_point["Syntax"] = $_Info["PpQ"][$idx];
			array_push($criteria_point["Comments"],"- FAIL, no input given");// COMMENT
			//Constraints
			foreach(qConstraintsGrd($_Info["CfpQ"][$idx], $_Info["StudAnswers"][$idx], $_Info["PpQ"][$idx]) as $Cpoint)
			{
				array_push($criteria_point["Constraints"],$Cpoint);
			}

			array_push($criteria_point["Comments"],"- FAIL, no CONSTRAINTS input given");// COMMENT

			//Code Execution (TEST CASES)
			//NUMBER OF TESTCASES OUPUT
			for($a =0; $a < count($_Info["TCopQ"][$idx]); $a++)
			{
				$tmp_comment = "- FAIL, no input given";
				array_push($criteria_point["StudOutput"]," "); //STUD Output
				array_push($criteria_point["TestCases"],$_Info["PpQ"][$idx]); //POINTS
				array_push($criteria_point["Comments"],$tmp_comment); //COMMENT
			}
		}

		// --- Calculate PointsLost ---
		$criteria_point["PointsLost"] = $criteria_point["fnamePoints"];

		$criteria_point["PointsLost"] += $criteria_point["Syntax"];

		foreach($criteria_point["Constraints"] as $cnsPoint)
		{ $criteria_point["PointsLost"] += $cnsPoint; }

		foreach($criteria_point["TestCases"] as $tcpoint)
		{ $criteria_point["PointsLost"] += $tcpoint;}

		// --- Acumulate ExamPoints ---
		$ExamPoints += $criteria_point["PointsLost"];


		// --- PUSH INTO GRADES ---
		array_push($grades,$criteria_point);


		// --- Clear Criteria ---
		$criteria_point = array("fnamePoints"=>0,
					"fname"=>"",
					"Syntax" => 0, //Colon Mark
					"TestCases" => array(),
					"Constraints" => array(),
					"Comments" => array(),
					"StudOutput" => array(),
					"PointsLost" => 0);

	}

	// --- Push Into Exam Points ---
	array_push($grades,$ExamPoints);


	// Return Grades
	return $grades;

}
//--------------------------------------------------------------------


//------------------- PHP Script Starts ------------------------------

/*RECEIVE DATA FROM POST REQUEST*/
$indata = file_get_contents("php://input");
$data = json_decode($indata,true);

//Figure out how many questions...
$info["qnum"] = numOfquestions($data); //INTEGER
//Get questions Name...
$info["qname"] = questionsName($info["qnum"],$data);
//Figure out how many TestCases (input,output)...
$info["TCipQ"] = numTCasesPquestion("i",$info["qnum"], $data); //ARRAY
$info["TCopQ"] = numTCasesPquestion("o",$info["qnum"], $data); //ARRAY
//Identify which constraints are apply per Questions.
$info["CfpQ"] = constrainsPerQuestion($info["qnum"],$data); //ARRAY
//Figure out each questions Worth
$info["qworth"] = questionsWorth($info["qnum"], $data[$info["qnum"]]);
//Get Students Answer...
$info["StudAnswers"] = studAnswers($info["qnum"], $data[$info["qnum"]]);
//Calcualte Number of points to SUBSTRACT per TESTING standard
$info["PpQ"]= substractPquestion($info); //ARRAY

// ----- START GRADING -----
$result =  Grading($data, $info);

// --- MERGING IN TO ONE OBJ ---
$ans = array();
array_push($ans,$data);
array_push($ans,$result);

// --- JSON OBJ ---


/*URL TO BACK SERVER*/
$url = "https://web.njit.edu/~pio3/CS490/exam/submitexam.php";

//cURL to Back Server
echo http_post_back_server($url, json_encode($ans));

?>
