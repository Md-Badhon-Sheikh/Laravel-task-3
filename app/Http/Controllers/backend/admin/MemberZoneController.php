<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Http\Middleware\OperatorAuthenticationMiddleware;
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


    public function memberZone(Request $request)
    {

        if ($request->isMethod('post')) {
            $id = 0;
            $id = $request->id;
            try {
                if ($id < 1) {
                    MemberZone::create([
                        'name' => $request->name,
                        'priority' => $request->priority,
                        'created_by' => Auth::user()->id,
                    ]);
                    return back()->with('success', 'Added Successfully');
                } elseif($id > 0){
                    $member_zone_type = MemberZone::findOrFail($id);
                    $member_zone_type->update([
                        'name' => $request->name,
                        'priority' => $request->priority,
                        'created_by' => Auth::user()->id,
                    ]);
                    return back()->with('success','Update Successfully');
                }
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try again');
            }
        }
        $data['member_zone_list'] = DB::table('member_zone_types')->get();
        $data['active_menu']='member_zone';
        $data['page_title'] =  'Member Zone Type';
        return view('backend.admin.pages.member_zone_type', compact('data'));
    }

    public function delete($id){
        $server_response = ['status' => 'FAILED', 'message' => 'Not Found'];
        $member_zone_type = MemberZone::findOrFail($id);
        if($member_zone_type){
            $member_zone_type -> delete();
            $server_response = ['status'=>'SUCCESS', 'message'=> 'Deleted Successfully'];
        }
        echo json_encode($server_response);
    }
}
