<?php

class InstallTest extends TestCase
{
    var $token = 'testing';
    
    /**
     * /install?reinstall [GET]
     */
    public function testShouldReturnInstallSuccessful()
    {
        $this->get("install?reinstall=true", ['api_token' => $this->token]);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'installed',
            'message'
        ]);
    }
    /**
     * /install [GET]
     */
    public function testShouldReturnInstallAlreadyRan()
    {
        $this->get("install", ['api_token' => $this->token]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'installed',
            'message'
        ]);
    }

}
