<?php

    require_once __DIR__ . '/vendor/autoload.php';

    include_once "getBuildInfo.php";

    static $colorMap = array(
        "SUCCESS" => "25500",
        "FAILURE" => "0",
        "NEXT_SUCCESS" => "28504",
        "NEXT_FAILURE" => "61827",
        "UNDEFINED" => "50000"
    );

    if (empty($jsonObj) || !isset($lastBuild)) {
        die("No job data has been fetched.");
    }
    var_dump($lastBuild);

    $client = new \Phue\Client('172.31.46.151', '143f312e30a5f7f978c3190560b8d36f');

    $isAuthenticated = $client->sendCommand(
        new \Phue\Command\IsAuthorized
    );

    if (!$isAuthenticated) {
        die("ERROR: You are not authenticated to use the Hue API");
    }

    $light = $client->getLights()[1];
    $currentColor = $light->getHue();
    echo "current color hue: $currentColor \n";

    if (!$lastBuild->isBuilding()) {
        // get the last build result and fetch the matched color
        $lastResult = $lastBuild->getBuildResult();
        if (!in_array($lastResult, array_keys($colorMap))) {
            echo("The last build result is undetermined, will set the light to be yellow");
            $lightColor = $colorMap["UNDEFINED"];
        } else {
            $lightColor = $colorMap[$lastResult];
        }
    } else {
        if ($currentColor == $colorMap["NEXT_SUCCESS"] || $currentColor == $colorMap["NEXT_FAILURE"]) {
            // do nothing;
            $lightColor = $currentColor;
        } elseif ($currentColor == $colorMap["SUCCESS"]) {
            $lightColor = $colorMap["NEXT_SUCCESS"];
        } elseif($currentColor == $colorMap["FAILURE"]) {
            $lightColor = $colorMap["NEXT_FAILURE"];
        } else {
            $lightColor =  $colorMap["UNDEFINED"];
        }
    }

    // If the color does not change, we dont send the command
    if ($currentColor == $lightColor) {
        return;
    }

    // Setting the Initial brightness, hue, and saturation at the same time
    $command = new \Phue\Command\SetLightState($light);
    $command->brightness(254)
        ->hue($lightColor)
        ->saturation(254);

    // turn on the light if it is off
    if (!$light->isOn()) {
        $command->on(true);
    }

    // if the build failed, then flash it first
    if ($lightColor == $colorMap["FAILURE"]) {
        $command->alert();
    }

    // Transition time (in seconds).
    // 0 for "snapping" change
    // Any other value for gradual change between current and new state
    $command->transitionTime(3);

    // Send the command
    $client->sendCommand(
        $command
    );

    if (isset($lastResult)) {
        echo "A command is sent to set the color for the last $lastResult build.\n" ;
    }
