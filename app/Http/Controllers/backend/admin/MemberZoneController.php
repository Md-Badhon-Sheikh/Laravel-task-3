<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class MemberZoneController extends Controller implements HasMiddleware
{
      public static function middleware()
    {
        return [
            BackendAuthenticationMiddleware::class,
            AdminAuthenticationMiddleware::class
        ];
    }

    public function member_zone(){
        $data = [];
        $data['active_menu'] = 'member-zone';
        $data['page_title'] = 'Member Zone';
        
        
        $data['member-zone'] = \App\Models\MemberZone::all();

        return view('backend.admin.pages.member_zone', compact('data'));
    }

    

}
