<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;

class MemberZoneController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            BackendAuthenticationMiddleware::class,
            AdminAuthenticationMiddleware::class
        ];
    }

    public function member_zone()
    {
        $data = [];
        $data['active_menu'] = 'member-zone';
        $data['page_title'] = 'Member Zone';


        // $data['member-zone'] = \App\Models\MemberZone::all();

        $data['member_zone_list'] = DB::table('member_zones')
            ->leftJoin('zillas', 'member_zones.zilla_id', '=', 'zillas.id')
            ->leftJoin('divisions', 'member_zones.division_id', '=', 'divisions.id')
            ->leftJoin('member_zone_types', 'member_zones.member_zone_type_id', '=', 'member_zone_types.id')
            ->select(
                'member_zones.*',
                'zillas.name_en as zilla_name',
                'divisions.name_en as division_name',
                'member_zone_types.name as type_name'
            )
            ->get();
            $data['zillas'] = DB::table('zillas')->get();
            $data['divisions'] = DB::table('divisions')->get();
            $data['member_zone_types'] = DB::table('member_zone_types')->get();

        return view('backend.admin.pages.member_zone', compact('data'));
    }
}
