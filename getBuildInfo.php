<?php
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

    if (empty($jsonObj)) {
        die("Warning: Can not fetch any data from Jenkins. Please check the site is available");
    }

    $jobBuilder = new JenkinsJobBuilder();
    $lastBuild = $jobBuilder->buildJenkinsBuildInstance($jsonObj);