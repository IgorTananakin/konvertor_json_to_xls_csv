<?php

$division = $_GET["division"];
$date = $_GET["date"];
$format = $_GET["format"];




$jsondata2 = file_get_contents("https://scout.bigsports.ru/wp-json/scout_calendar/v1/league=$division/date=$date/status=4");
//$jsondata2 = json_decode("https://scout.bigsports.ru/wp-json/scout_calendar/v1/league=$division/date=$date/status=4",true);
$jsonDecoded = json_decode($jsondata2, true); // add true, will handle as associative array


//foreach ($jsonDecoded as $line) {
//	foreach ($line as $key => $value) {
//		echo "<pre>";
//		var_dump($line[$key]["home_score"]);
//		echo "</pre>";
//	}
//	
//}

if ($format === 'xls') {
$fileName = "test " . $date . ".xls";
if (is_array($jsonDecoded)) {

	
$fields = array('Date', 'match_id', 'home_id', 'Team_home', 'away_id', 'Team_away', 'Score_Home','Score_Away',
    //'summa_golov',
    '1_period_HOME', '1_period_AWAY', '2_period_HOME', '2_period_AWAY', '3_perion_HOME', '3_period_AWAY');


$excelData = implode("\t", array_values($fields)) . "\n";	
	
	
    foreach ($jsonDecoded as $line) {

        foreach ($line as $key => $value) {

            $lineData = array($line[$key]["match_date"], $line[$key]["model"]["match_id"], $line[$key]["homeTeamID"], strip_tags($line[$key]["homePartName"]),
							  $line[$key]["awayTeamID"], strip_tags($line[$key]["awayPartName"]), $line[$key]["home_score"], $line[$key]["away_score"],
                //$arrays["ScoreHome"] + $arrays["ScoreAway"],
                $line[$key]["stages"]["2"]["0"], $line[$key]["stages"]["2"]["1"], $line[$key]["stages"]["3"]["0"], $line[$key]["stages"]["3"]["1"], $line[$key]["stages"]["4"]["0"], $line[$key]["stages"]["4"]["1"], 
						
					    
            );
			$excelData .= implode("\t", array_values($lineData)) . "\n";
        }

        


    }
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$fileName\"");


    // Render excel data
    echo $excelData;

    exit;

}
	
} else if ($format === "csv") {
	$fileName = "test " . $date . ".csv";
	
	
$fields = array('Date;', 'match_id;', 'home_id;', 'Team_home;', 'away_id;', 'Team_away;', 'Score_Home;','Score_Away;',
  				'1_period_HOME;', '1_period_AWAY;', '2_period_HOME;', '2_period_AWAY;', '3_perion_HOME;', '3_period_AWAY;');


$excelData = implode("\t", array_values($fields)) . "\n";
	
	
	if (is_array($jsonDecoded)) {

    foreach ($jsonDecoded as $line) {

        foreach ($line as $key => $value) {

            $lineData = array($line[$key]["match_date"] . ";", $line[$key]["model"]["match_id"] . ";", $line[$key]["homeTeamID"] . ";", 
			strip_tags($line[$key]["homePartName"]) . ";",
			$line[$key]["awayTeamID"] . ";", strip_tags($line[$key]["awayPartName"]) . ";", $line[$key]["home_score"] . ";", $line[$key]["away_score"] . ";",
               
                $line[$key]["stages"]["2"]["0"] . ";", $line[$key]["stages"]["2"]["1"] . ";", $line[$key]["stages"]["3"]["0"] . ";", $line[$key]["stages"]["3"]["1"] . ";", $line[$key]["stages"]["4"]["0"] . ";", $line[$key]["stages"]["4"]["1"] . ";", 
						
					    
            );
			$excelData .= implode("\t", array_values($lineData)) . "\n";
        }

        


    }
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$fileName\"");


    // Render excel data
    echo $excelData;

    exit;

}
}



