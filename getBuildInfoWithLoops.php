<?php
/*
    require_once __DIR__ . '/vendor/autoload.php';

    include_once __DIR__ . "/classes/jenkinsBuild.php";
    include_once __DIR__ . "/classes/jenkinsJobBuilder.php";
    include_once __DIR__ . "/classes/jenkinsSynchronizer.php";


    //$dotenv = new Dotenv\Dotenv(__DIR__);
    //$dotenv->load();

    const INTERVAL = 10; // in seconds;

    $api = "http://build.tm.tmcs/api/";
    // mnxweb release pipeline sut
    $jobName = "mfol-hackathon-CI-light-test-build";

    $requestURL = $api . 'job/' . $jobName;

    $api = "http://build.tm.tmcs/job/$jobName/lastBuild/api/json";
    $requestURL = $api;

    //$userName = $_ENV['JENKINS_USERNAME'];
    //$password = $_ENV['JENKINS_PASS'];

    $headers = array(
        'Content-Type: application/json',
        'Accept: application/json'
    );


    $synchronizer = new JenkinsSynchronizer($requestURL, $headers);
    $jsonObj = $synchronizer->sync();

    $jobBuilder = new JenkinsJobBuilder();
    $lastBuild = $jobBuilder->buildJenkinsBuildInstance($jsonObj);

    // if the build is ongoing, then we need to sync very 10 seconds
    // to get the final result
    $counter = 1;
    $maxTry = 3600 / INTERVAL; // if this goes over one hour then we know it is not right
    while($lastBuild->isBuilding() === true && $counter <= $maxTry) {
        sleep(INTERVAL);

        $synchronizer = new JenkinsSynchronizer($requestURL, $headers);
        $jsonObj = $synchronizer->sync();

        $lastBuild = $jobBuilder->buildJenkinsBuildInstance($jsonObj);

        $counter++;
    }

*/