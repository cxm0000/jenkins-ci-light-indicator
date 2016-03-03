<?php

/**
 * Created by PhpStorm.
 * User: ming
 * Date: 03/03/16
 * Time: 08:11
 */
class JenkinsBuild
{
    private $buildId;
    private $buildOnBranch;
    private $buildResult;
    private $isBuilding = false;

    /**
     * JenkinsBuild constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getBuildId()
    {
        return $this->buildId;
    }

    /**
     * @param mixed $buildId
     */
    public function setBuildId($buildId)
    {
        $this->buildId = $buildId;
    }

    /**
     * @return mixed
     */
    public function getBuildOnBranch()
    {
        return $this->buildOnBranch;
    }

    /**
     * @param mixed $buildOnBranch
     */
    public function setBuildOnBranch($buildOnBranch)
    {
        $this->buildOnBranch = $buildOnBranch;
    }

    /**
     * @return mixed
     */
    public function getBuildResult()
    {
        return $this->buildResult;
    }

    /**
     * @param mixed $buildResult
     */
    public function setBuildResult($buildResult)
    {
        $this->buildResult = $buildResult;
    }

    /**
     * @return boolean
     */
    public function isBuilding()
    {
        return $this->isBuilding;
    }

    /**
     * @param boolean $isBuilding
     */
    public function setIsBuilding($isBuilding)
    {
        $this->isBuilding = $isBuilding;
    }

}