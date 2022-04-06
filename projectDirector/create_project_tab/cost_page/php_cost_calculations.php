<?php
/*
		CIS 492 
		Last Worked: 04/01/22   
		Filename: php_cost_calculations.php
*/	

// calculations work the same as the Javascript version just in php now
$months = 1;
$value0 = filter_input(INPUT_GET, 'P0', FILTER_VALIDATE_INT)* 3;
$value1 = filter_input(INPUT_GET, 'P1', FILTER_VALIDATE_INT)* 4;
$value2 = filter_input(INPUT_GET, 'P2', FILTER_VALIDATE_INT)* 6;
$value3 = filter_input(INPUT_GET, 'P3', FILTER_VALIDATE_INT)* 4;
$value4 = filter_input(INPUT_GET, 'P4', FILTER_VALIDATE_INT)* 5;
$value5 = filter_input(INPUT_GET, 'P5', FILTER_VALIDATE_INT)* 7;
$value6 = filter_input(INPUT_GET, 'P6', FILTER_VALIDATE_INT)* 3;
$value7 = filter_input(INPUT_GET, 'P7', FILTER_VALIDATE_INT)* 4;
$value8 = filter_input(INPUT_GET, 'P8', FILTER_VALIDATE_INT)* 6;
$value9 = filter_input(INPUT_GET, 'P9', FILTER_VALIDATE_INT)* 5;
$value10 = filter_input(INPUT_GET, 'P10', FILTER_VALIDATE_INT)* 7;
$value11 = filter_input(INPUT_GET, 'P11', FILTER_VALIDATE_INT)* 10;
$value12 = filter_input(INPUT_GET, 'P12', FILTER_VALIDATE_INT)* 7;
$value13 = filter_input(INPUT_GET, 'P13', FILTER_VALIDATE_INT)* 10;
$value14 = filter_input(INPUT_GET, 'P14', FILTER_VALIDATE_INT)* 15;


$ufp =$value0+$value1+$value2+$value3+$value4+$value5+$value6+$value7+$value8+$value9+$value10+$value11+$value12+$value13+$value14;
/////////////////////////////////////////////////////////////////////
$value15 = filter_input(INPUT_GET, 'Q1', FILTER_VALIDATE_INT);
$value16 = filter_input(INPUT_GET, 'Q2', FILTER_VALIDATE_INT);
$value17 = filter_input(INPUT_GET, 'Q3', FILTER_VALIDATE_INT);
$value18 = filter_input(INPUT_GET, 'Q4', FILTER_VALIDATE_INT);
$value19 = filter_input(INPUT_GET, 'Q5', FILTER_VALIDATE_INT);
$value20 = filter_input(INPUT_GET, 'Q6', FILTER_VALIDATE_INT);
$value21 = filter_input(INPUT_GET, 'Q7', FILTER_VALIDATE_INT);
$value22 = filter_input(INPUT_GET, 'Q8', FILTER_VALIDATE_INT);
$value23 = filter_input(INPUT_GET, 'Q9', FILTER_VALIDATE_INT);
$value24 = filter_input(INPUT_GET, 'Q10', FILTER_VALIDATE_INT);
$value25 = filter_input(INPUT_GET, 'Q11', FILTER_VALIDATE_INT);
$value26 = filter_input(INPUT_GET, 'Q12', FILTER_VALIDATE_INT);
$value27 = filter_input(INPUT_GET, 'Q13', FILTER_VALIDATE_INT);
$value28 = filter_input(INPUT_GET, 'Q14', FILTER_VALIDATE_INT);
//these add up all the field on the calculator page 
// calculations for tafp 
$fi=$value15+$value16+$value17+$value18+$value19+$value20+$value21+$value22+$value23+$value24+$value25+$value26+$value27+$value28;
$caf = (.65 + (.01*$fi));
$tafp = round(($ufp * $caf), 2);
///////////////////////////////////////////////////////////////////////
//these caclculate total lines of code AND person months values 
$LOC = filter_input(INPUT_GET, 'LOC', FILTER_VALIDATE_INT);
$tlc = $tafp*$LOC;
$PM = round(1.4*($tlc/1000), 2);
///////////////////////////////////////////////////////////////////////
//calculates months 
//it didn't like months or persons being zero (division by zero) so it needed to be positive to avoid an error message
$m=3.0*$PM;
$expo = filter_input(INPUT_GET, 'exponent1');

$months = round(pow($m, (1/3)), 2);
if ($months == 0) {
	$months = 1;
	$persons =1;
}else{
$persons = round(($PM/$months), 2);
}
/////////////////////////////////////////////////////////////////////////
//calculates personnel cost 
$rate = filter_input(INPUT_GET, 'hourlyRate', FILTER_VALIDATE_FLOAT);
$personCost = round(($persons*$rate), 2);
//////////////////////////////////////////////////////////////////////////
//puts these values into a SESSION to get it over to cost_update.php
$project_id = filter_input(INPUT_GET, 'project_id', FILTER_VALIDATE_INT);  // THIS GETS THE PROJECT ID !!
$reason = filter_input(INPUT_GET, 'reason');
$_SESSION['project_id'] = $project_id;
$_SESSION['tafp1'] = $tafp;
$_SESSION['code'] = $tlc;
$_SESSION['personMonths'] = $PM;
$_SESSION['months'] = $months;
$_SESSION['persons'] = $persons;
$_SESSION['personnel_cost'] = $personCost;
$_SESSION['reason'] = $reason;

?>

