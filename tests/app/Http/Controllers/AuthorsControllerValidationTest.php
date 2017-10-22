<?php

namespace Tests\App\Http\Controllers;

use TestCase;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AuthorsControllerValidationTest extends TestCase
{
    use DatabaseMigrations;

//    /**
//     * @test
//     */
//    public function store_method_validates_required_fields()
//    {
//        $this->post('/authors', [], ['Accept' => 'application/json']);
//
//        $data = $this->response->getData(true);
//
//        $fields = ['name', 'gender', 'biography'];
//
//        foreach ($fields as $field) {
//            $this->assertArrayHasKey($field, $data);
//            $this->assertEquals(["The {$field} field is required."], $data[$field]);
//        }
//    }

//    /**
//     * @test
//     */
//    public function store_invalidates_incorrect_gender_data()
//    {
//        $postData = [
//            'name' => 'John Doe',
//            'gender' => 'unknown',
//            'biography' => 'An anonymous author'
//        ];
//
//        $this->post('/authors', $postData, ['Accept' => 'application/json']);
//
//        $this->seeStatusCode(422);
//
//        $data = $this->response->getData(true);
//        $this->assertCount(1, $data);
//        $this->assertArrayHasKey('gender', $data);
//        $this->assertEquals(
//            ["Gender format is invalid: must equal 'male' or 'female'"],
//            $data['gender']);
//    }

//    /**
//     * @test
//     */
//    public function store_invalidates_name_when_name_is_just_too_long()
//    {
//        $postData = [
//            'name' => str_repeat('a', 256),
//            'gender' => 'male',
//            'biography' => 'A Valid Biography'
//        ];
//
//        $this->post('/authors', $postData, ['Accept' => 'application/json']);
//
//        $this->seeStatusCode(422);
//
//        $data = $this->response->getData(true);
//        $this->assertCount(1, $data);
//        $this->assertArrayHasKey('name', $data);
//        $this->assertEquals(
//            ["The name may not be greater than 255 characters."],
//            $data['name']
//        );
//    }

//    /**
//     * @test
//     */
//    public function store_is_valid_when_name_is_just_long_enough()
//    {
//        $postData = [
//            'name' => str_repeat('a', 255),
//            'gender' => 'male',
//            'biography' => 'A Valid Biography'
//        ];
//
//        $this->post('/authors', $postData,
//            ['Accept' => 'application/json']);
//
//        $this->seeStatusCode(201);
//        $this->seeInDatabase('authors', $postData);
//    }



    /**
     * @test
     */
    public function validation_validates_required_fields()
    {
        $author = factory(\App\Author::class)->create();
        $tests = [
            ['method' => 'post', 'url' => '/authors'],
            ['method' => 'put', 'url' => "/authors/{$author->id}"],
        ];

        foreach ($tests as $test) {
            $method = $test['method'];
            $this->{$method}($test['url'], [], ['Accept' => 'application/json']);
            $this->seeStatusCode(422);
            $data = $this->response->getData(true);

            $fields = ['name', 'gender', 'biography'];

            foreach ($fields as $field) {
                $this->assertArrayHasKey($field, $data);
                $this->assertEquals(["The {$field} field is required."], $data[$field]);
            }
        }
    }

    /**
     * @test
     */
    public function validation_invalidates_incorrect_gender_data()
    {
        foreach ($this->getValidationTestData() as $test) {
            $method = $test['method'];
            $test['data']['gender'] = 'unknown';
            $this->{$method}($test['url'], $test['data'], ['Accept' => 'application/json']);

            $this->seeStatusCode(422);

            $data = $this->response->getData(true);
            $this->assertCount(1, $data);
            $this->assertArrayHasKey('gender', $data);
            $this->assertEquals(
                ["Gender format is invalid: must equal 'male' or 'female'"],
                $data['gender']
            );
        }
    }

    /**
     * @test
     */
    public function validation_invalidates_name_when_name_is_just_too_long()
    {
        foreach ($this->getValidationTestData() as $test) {
            $method = $test['method'];
            $test['data']['name'] = str_repeat('a', 256);
            $this->{$method}($test['url'], $test['data'], ['Accept' => 'application/json']);

            $this->seeStatusCode(422);

            $data = $this->response->getData(true);
            $this->assertCount(1, $data);
            $this->assertArrayHasKey('name', $data);
            $this->assertEquals(["The name may not be greater than 255 characters."],
                $data['name']);
        }
    }

    /**
     * @test
     */
    public function validation_is_valid_when_name_is_just_long_enough()
    {
        foreach ($this->getValidationTestData() as $test) {
            $method = $test['method'];
            $test['data']['name'] = str_repeat('a', 255);

            $this->{$method}($test['url'], $test['data'], ['Accept' => 'application/json']);

            $this->seeStatusCode($test['status']);
            $this->seeInDatabase('authors', $test['data']);
        }
    }

    /**
     * Provides boilerplate test instructions for validation.
     *
     * @return array
     */
    private function getValidationTestData()
    {
        $author = factory(\App\Author::class)->create();
        return [
            // Create
            [
                'method' => 'post',
                'url' => '/authors',
                'status' => 201,
                'data' => [
                    'name' => 'John Doe',
                    'gender' => 'male',
                    'biography' => 'An anonymous author'
                ]
            ],

            //Update
            [
                'method' => 'put',
                'url' => "/authors/{$author->id}",
                'status' => 200,
                'data' => [
                    'name' => $author->name,
                    'gender' => $author->gender,
                    'biography' => $author->biography
                ]
            ]
        ];
    }
}