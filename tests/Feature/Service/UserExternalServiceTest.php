<?php

namespace Tests\Feature\Http\Service;

use App\Gateway\UserGatewayService;
use App\Models\UserExternal;
use App\Repositories\Eloquent\UserExternalModelRepository;
use App\Service\UserExternalService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Tests\TestCase;
use Tests\Traits\TestResources;

class UserExternalServiceTest extends TestCase
{
    use DatabaseTransactions;
    use TestResources;
    protected $returnPayloadMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->returnPayloadMock = [
            "results" => [
                [
                    "gender" => "female",
                    "name" => [
                        "title" => "Miss",
                        "first" => "Nieves",
                        "last" => "Ibáñez"
                    ],
                    "location" => [
                        "street" => [
                            "number" => 993,
                            "name" => "Calle de Pedro Bosch"
                        ],
                        "city" => "Orense",
                        "state" => "Región de Murcia",
                        "country" => "Spain",
                        "postcode" => 38837,
                        "coordinates" => [
                            "latitude" => "-30.3692",
                            "longitude" => "106.9757"
                        ],
                        "timezone" => [
                            "offset" => "+3:30",
                            "description" => "Tehran"
                        ]
                    ],
                    "email" => "nieves.ibanez@example.com",
                    "login" => [
                        "uuid" => "b629199f-5ef7-4bc1-8472-3750047c3d66",
                        "username" => "blackduck546",
                        "password" => "hotass",
                        "salt" => "38BTWfVr",
                        "md5" => "7e840cc8ec7e1b812a2ceb77d039cb4c",
                        "sha1" => "358aee545bb5ac1093980d7bb7ca3b6e4c4cb075",
                        "sha256" => "8b348762780e71508a57f3c6ddd610986a6da93763523cbd0f016d98528d4929"
                    ],
                    "dob" => [
                        "date" => "1965-04-07T07:01:18.675Z",
                        "age" => 59
                    ],
                    "registered" => [
                        "date" => "2002-04-07T18:47:52.136Z",
                        "age" => 22
                    ],
                    "phone" => "924-728-435",
                    "cell" => "639-371-009",
                    "id" => [
                        "name" => "DNI",
                        "value" => "79580857-O"
                    ],
                    "picture" => [
                        "large" => "https://randomuser.me/api/portraits/women/5.jpg",
                        "medium" => "https://randomuser.me/api/portraits/med/women/5.jpg",
                        "thumbnail" => "https://randomuser.me/api/portraits/thumb/women/5.jpg"
                    ],
                    "nat" => "ES"
                ]
            ],
            "info" => [
                "seed" => "8c0dab4aec3edcc0",
                "results" => 1,
                "page" => 1,
                "version" => "1.4"
            ]
        ];
    }

    public function testgetCreateUsers()
    {
        $gatewayServiceMock = Mockery::mock(UserGatewayService::class);
        $gatewayServiceMock->shouldreceive('getAllUser')->andReturn($this->returnPayloadMock);
        $service = new UserExternalService(
            $gatewayServiceMock,
            new UserExternalModelRepository()
        );
        $service->insertUsersByExternalApi();
        $userCreated = UserExternal::where('email', $this->returnPayloadMock['results'][0]['email'])->first();
        $this->assertEquals($userCreated['nome'], "Miss Nieves Ibáñez");
        $this->assertEquals($userCreated['email'], "nieves.ibanez@example.com");
        $this->assertEquals($userCreated['cidade'], "Orense");
        $this->assertEquals($userCreated['telefone'], "924-728-435");
        $this->assertEquals($userCreated['data_nascimento'], "2002-04-07");
        $this->assertEquals($userCreated['foto'], "https://randomuser.me/api/portraits/thumb/women/5.jpg");
    }

    public function testFormatPayloadInsert()
    {
        $response = $this->instanceService()->formatPayloadInsert($this->returnPayloadMock['results'][0]);
        $this->assertEquals($response['nome'], "Miss Nieves Ibáñez");
        $this->assertEquals($response['email'], "nieves.ibanez@example.com");
        $this->assertEquals($response['cidade'], "Orense");
        $this->assertEquals($response['telefone'], "924-728-435");
        $this->assertEquals($response['data_nascimento'], "2002-04-07");
        $this->assertEquals($response['foto'], "https://randomuser.me/api/portraits/thumb/women/5.jpg");
    }

    public function testGetAllPaginate()
    {
        $response = $this->instanceService()->getAllPaginateWithCache();
        $this->assertNotNull($response);
    }


    protected function instanceService()
    {
        return new UserExternalService(
            new UserGatewayService(),
            new UserExternalModelRepository()
        );
    }
}
