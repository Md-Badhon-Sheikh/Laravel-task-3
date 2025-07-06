<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Models\Division;
use App\Models\MemberZone;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;

class MemberZoneController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            BackendAuthenticationMiddleware::class,
            AdminAuthenticationMiddleware::class
        ];
    }

    public function member_zone(Request $request)
    {
        if($request->isMethod('post')){
            $id = 0;
            $id = $request->id;
            try{
                if($id < 1){
                    MemberZone::create([
                        'zone_name' => $request->zone_name,
                        'zilla_id' => $request->zilla,
                        'division_id' => $request->division,
                        'member_zone_type_id' => $request->member_zone_type,
                        'created_by' => Auth::user()->id,
                    ]);
                    return back()->with('success', 'Added Successfully');
                }elseif($id > 0){
                    $memberZone = MemberZone::findOrFail($id);
                    $memberZone -> update([
                        'zone_name' => $request->zone_name,
                        'zilla_id' => $request->zilla,
                        'division_id' => $request->division,
                        'member_zone_type_id' => $request->member_zone_type,
                        'created_by' => Auth::user()->id,
                    ]);
                    return back()->with('success','Update Successfully');
                }
            }catch(PDOException $e){
                return back()->with('error', 'Failed Please Try again');
            }
        }

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


    // delete 

    public function member_zone_delete($id){
        $server_response = ['status' => "FAILED", 'message' => 'Not Found'];
        $memberZone = MemberZone::findOrFail($id);
        if($memberZone){
            $memberZone-> delete();
            $server_response = ['status' => 'SUCCESS', 'message' => 'delete Successfully'];
        }
        echo json_encode($server_response);

    }
}
