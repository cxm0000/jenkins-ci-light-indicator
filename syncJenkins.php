<?php

    require_once __DIR__ . '/vendor/autoload.php';

    include_once "getBuildInfo.php";

    static $colorMap = array(
        "SUCCESS" => "25500",
        "FAILURE" => "0",
        "BUILDING" => "12750",
        "UNDEFINED" => "50000"
    );

    if (empty($jsonObj) || !isset($lastBuild)) {
        die("No job data has been fetched.");
    }
    var_dump($lastBuild);

    if ($lastBuild->isBuilding()) {
        $lightColor = $colorMap["BUILDING"];
    } else {
        // get the last build result and fetch the matched color
        $lastResult = $lastBuild->getBuildResult();
        if (!in_array($lastResult, array_keys($colorMap))) {
            echo ("The last build result is undetermined, will set the light to be yellow");
            $lightColor = $colorMap["UNDEFINED"];
        } else {
            $lightColor = $colorMap[$lastResult];
        }
    }

    $client = new \Phue\Client('172.31.46.151', '143f312e30a5f7f978c3190560b8d36f');

    try {
        $client->sendCommand(
            new \Phue\Command\Ping
        );
    } catch (\Phue\Transport\Exception\ConnectionException $e) {
        echo 'There was a problem accessing the bridge';
    }

    $isAuthenticated = $client->sendCommand(
        new \Phue\Command\IsAuthorized
    );

    if (!$isAuthenticated) {
        die("ERROR: You are not authenticated to use the Hue API");
    }

    $light = $client->getLights()[1];

    // If the color does not change, we dont send the command
    if ($light->getHue() == $lightColor) {
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
