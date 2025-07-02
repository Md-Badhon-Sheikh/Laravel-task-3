<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;

class DivisionController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            BackendAuthenticationMiddleware::class,
            AdminAuthenticationMiddleware::class
        ];
    }

    public function division_list(Request $request){
        if($request-> isMethod('post')){
            $id = 0;
            $id = $request->id;
            try{
                if($id < 1){
                    Division::create([
                        'name_en' => $request->name_en,
                        'name_bn' => $request->name_bn,
                        'priority' => $request->priority,
                        'created_by' => Auth::user()->id,
                    ]);
                    return back()->with('success','Added Successfully');
                } elseif($id >0){
                    $division = Division::findOrFail($id);
                    $division->update([
                        'name_en' => $request->name_en,
                        'name_bn' => $request->name_bn,
                        'priority' => $request->priority,
                        'created_by' =>Auth::user()->id,
                    ]);
                    return back()->with('success','Updated Successfully');
                }
                
            }catch(PDOException $e){
                return back()->with('error', 'Faild Please Try again');
            }
        }
        $data['division_list'] = DB::table('divisions')->get();
        $data['active_menu']='division';
        $data['page_title']='Division';
        return view('backend.admin.pages.divisions', compact('data'));
    }

    
    public function division_delete($id){
        $server_response = ['status' => 'FAILED','message' => 'Not Found'];
        $division = Division::findOrFail($id);
        if($division){
            $division->delete();
            $server_response = ['status' => 'SUCCESS', 'message'];
        }
        echo json_encode($server_response);
    }
}
