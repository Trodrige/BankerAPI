<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CustomerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * /products [GET]
     */
    public function testShouldReturnAllCustomers(){
        $this->get("customers", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }


}
