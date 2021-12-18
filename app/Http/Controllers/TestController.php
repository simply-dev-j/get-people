<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\PeopleUtil;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //

    public function testPerformRegistration(Request $request, User $user)
    {
        PeopleUtil::addNewPeople($user);

        return 'Test';
    }
}
