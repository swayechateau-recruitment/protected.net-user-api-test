<?php

use Faker\Factory as Faker;

class UserTest extends TestCase
{
    var $token = 'testing';
    
    /**
     * /users [GET]
     */
    public function testShouldReturnAllUsers()
    {

        $this->get("users", ['api_token' => $this->token]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' =>
            [
                'username',
                'first_name',
                'last_name',
                'dark_mode',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    /**
     * /users/id [GET]
     */
    public function testShouldReturnUser()
    {
        $this->get("users/2", ['api_token' => $this->token]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'username',
            'first_name',
            'last_name',
            'dark_mode',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * /users [POST]
     */
    public function testShouldCreateUser()
    {

        $faker = Faker::create();
        $parameters = [
            'username' => $faker->username,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
        ];

        $this->post("users", $parameters, ['api_token' => $this->token]);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'username',
            'first_name',
            'last_name',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * /users/id/tdm [GET]
     */
    public function testShouldToggleUserDarkMode()
    {
        $this->get("users/2/tdm", ['api_token' => $this->token]);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'dark_mode',
            'message',
        ]);
    }

    /**
     * /users/id [PUT]
     */
    public function testShouldUpdateUser()
    {

        $parameters = [
            'last_name' => 'Infinix Hot Note',
            'first_name' => 'markus',
        ];

        $this->put("users/4", $parameters, ['api_token' => $this->token]);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'username',
            'first_name',
            'last_name',
            'dark_mode',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * /users/id [DELETE]
     */
    public function testShouldDeleteUser()
    {
        $this->delete("users/7", [], ['api_token' => $this->token]);
        $this->seeStatusCode(410);
        $this->seeJsonStructure([
            'code',
            'message'
        ]);
    }

}
