<?php

class ApiTokenTest extends TestCase
{
    var $token = 'wrongToken';

    /**
     * /install [GET]
     * Get protected route with incorrect or no api token key
     */
    public function testShouldReturnAuthorisationError()
    {
        $this->get("install", []);
        $this->seeStatusCode(401);
        $this->seeJsonStructure([
            "error" => [
                "code",
                "message"
            ]
        ]);

        $this->get("install", ['api_token' => $this->token]);
        $this->seeStatusCode(401);
        $this->seeJsonStructure([
            "error" => [
                "code",
                "message"
            ]
        ]);
    }

}
