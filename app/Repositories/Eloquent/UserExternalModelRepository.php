<?php

namespace App\Repositories\Eloquent;

use App\Models\UserExternal;
use Illuminate\Database\Eloquent\Model;

class UserExternalModelRepository extends AbstractBaseCrudRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function model() : Model {
        return new UserExternal();
    }
}
