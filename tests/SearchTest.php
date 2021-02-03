<?php

class SearchTest extends TestCase
{
    var $token = 'testing';
    
    /**
     * /search?q= [GET]
     */
    public function testShouldReturnAllResults()
    {
        $this->get("search?q=elo", ['api_token' => $this->token]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            "search_term",
            "results" => [],
            "total" 
        ]);

    }
    /**
     * /search [GET]
     */
    public function testShouldReturnPleaseSetAQuery()
    {
        $this->get("search", ['api_token' => $this->token]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            "message" 
        ]);
    }

}
