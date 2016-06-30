<?php
	$dataToScan = array(
		"weaponSkill5" 		=> file_get_contents("5skill.txt"),
		"weaponSkill11" 	=> file_get_contents("11skill.txt")
	);
	$stats = array();
	foreach($dataToScan as $dataName => $data)
	{
		if(array_key_exists($dataName, $stats) === false)
		{
			$stats[$dataName] = array(
				"glancing" => array(
					"minHit" => 99999999999,
					"maxHit" => -1,
					"counter" => 0,
					"totalDamage" => 0,
					"avarageDamage" => 0,
				),
				"hit" => array(
					"minHit" => 99999999999,
					"maxHit" => -1,
					"counter" => 0,
					"totalDamage" => 0,
					"avarageDamage" => 0,
				),
			);
		}
		// Get the number for all hits.
		preg_match_all("/for (.*)\..*/", $data, $match5skill);
		//print_r($match5skillglancing);

		// Loop the data, check if the attack is glancing and save the data.
		foreach($match5skill[1] as $i => $damage)
		{
			// Check if this is a hit or glance.
			$hitType = "hit";
			// First (0) of a match contains the full match, we use this to see if it was a glancing.
			if(strpos($match5skill[0][$i], "glancing") !== false)
				$hitType = "glancing";

			if($stats[$dataName][$hitType]["minHit"] > $damage)
				$stats[$dataName][$hitType]["minHit"] = $damage;

			if($stats[$dataName][$hitType]["maxHit"] < $damage)
				$stats[$dataName][$hitType]["maxHit"] = $damage;

			$stats[$dataName][$hitType]["counter"]++;
			$stats[$dataName][$hitType]["totalDamage"] += $damage;

			$stats[$dataName][$hitType]["avarageDamage"] = $stats[$dataName][$hitType]["totalDamage"] / $stats[$dataName][$hitType]["counter"];
		}
	}

	print_r($stats);
	// Get all normal hits
?>