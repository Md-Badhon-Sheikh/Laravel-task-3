<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Models\Division;
use App\Models\Upozilla;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;

class UpozillaController extends Controller implements HasMiddleware
{
       public static function middleware()
    {
        return [
            BackendAuthenticationMiddleware::class,
            AdminAuthenticationMiddleware::class
        ];
    }

    public function upozilla_list(Request $request){
        if($request->isMethod('post')){
            $id = 0;
            $id = $request -> id;
            try {
                 if($id<1){
                    Upozilla::create([
                        'name_en' => $request-> name_en,
                        'name_bn' => $request-> name_bn,
                        'priority' => $request-> priority,
                        'zilla' => $request-> zilla,
                        'created_by' =>Auth::user()->id,
                    ]);
                    return back()->with('success', 'Added Successfully');
                 }elseif($id>0){
                    $division = Division::findOrFail($id);
                    $division->update([
                             'name_en' => $request-> name_en,
                        'name_bn' => $request-> name_bn,
                        'priority' => $request-> priority,
                        'zilla' => $request-> zilla,
                        'created_by' =>Auth::user()->id,
                    ]);
                     return back()->with('success', 'Updated Successfully');
                }
            }
            catch(PDOException $e){
                return back()->with('error','Failed Please Try again');
            }
        }
        $data['division_list'] = DB::table('upazilla')->get();
        $data['active_menu'] = 'upazilla';
        $data['page_title'] = 'Upazilla';
        return view('backend.admin.pages.upazilla', compact('data'));
    }
}
