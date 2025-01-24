<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Controllers\Api\UserExternalController;
use App\Models\UserExternal;
use App\Service\UserExternalService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserExternalControllerTest extends TestCase
{
    use DatabaseTransactions;
    // use TestValidations;
    // use TestSaves;
    // use TestResources;
    // // use WithOutMiddleware;

    private $account;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = $this->controller();
        // $fakeAccount = UserExternal::factory()->create([
        //     'id' => Uuid::uuid4()->toString(),
        //     'name' => fake()->name(),
        //     'email' => 'teste@dev.com.br',
        //     'balance' => 10,
        //     'password' => '1234',
        // ]);

        // $this->account = $this->model()::where('email', $fakeAccount->email)->first();
    }

    private $serializedFields = [
        "id",
        "nome",
        "email",
        "cidade",
        "telefone",
        "foto",
        "data_nascimento",
        "created_at",
        "updated_at",
    ];

    public function testGetAll()
    {
        $response = $this->get(route('users.index'));
        $response
            ->assertStatus(200);
            // ->assertJsonStructure(
            //     [
            //         'data' => [
            //             '*' => $this->serializedFields
            //         ],
            //         'links' => [],
            //     ]
            // );
    }

    public function model()
    {
        return UserExternal::class;
    }

    public function controller()
    {
        $service = app()->make(UserExternalService::class);
        return new UserExternalController($service);
    }
}
