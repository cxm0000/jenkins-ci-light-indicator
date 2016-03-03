<?php
include_once "jenkinsBuild.php";

/**
 * Created by PhpStorm.
 * User: ming
 * Date: 03/03/16
 * Time: 08:11
 */
class JenkinsJobBuilder
{

    private $jenkinsBuildJson = '';

    /**
     * JenkinsJobBuilder constructor.
     *
     * @return $this
     */
    public function __construct()
    {
    }

    /**
     * Build a jenkinsBuild instance based on the given json object
     *
     * @param stdClass $jenkinsBuildJson
     *
     * @return JenkinsBuild
     */
    public function buildJenkinsBuildInstance(stdClass $jenkinsBuildJson)
    {
        $build = new JenkinsBuild();

        if (isset($jenkinsBuildJson->id)) {
            $build->setBuildId($jenkinsBuildJson->id);
        }

        if (isset($jenkinsBuildJson->actions[0]->parameters[0]->value)) {
            $build->setBuildOnBranch($jenkinsBuildJson->actions[0]->parameters[0]->value);
        }

        if (isset($jenkinsBuildJson->result)) {
            $build->setBuildResult($jenkinsBuildJson->result);
        }

        if (isset($jenkinsBuildJson->building)) {
            $build->setIsBuilding($jenkinsBuildJson->building);
        }

        return $build;
    }

}