<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Models\Division;
use App\Models\Zilla;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;

class ZillaController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            BackendAuthenticationMiddleware::class,
            AdminAuthenticationMiddleware::class
        ];
    }

    public function zilla_list(Request $request)
    {

        if ($request->isMethod('post')) {
            $id = 0;
            $id = $request->id;
            try {
                if ($id < 1) {
                    Zilla::create([
                        'name_en' => $request->name_en,
                        'name_bn' => $request->name_bn,
                        'priority' => $request->priority,
                        'division_id' => $request->division,
                        'created_by' => Auth::user()->id,
                    ]);

                    return back()->with('success', 'Added Successfully');
                } elseif ($id > 0) {
                    $zilla = Zilla::find($id);
                    $zilla->update([
                        'name_en' => $request->name_en,
                        'name_bn' => $request->name_bn,
                        'priority' => $request->priority,
                        'division_id' => $request->division,
                        'created_by' => Auth::user()->id,
                    ]);
                    return back()->with('success', 'Updated Successfully');
                }
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try again');
            }
        }
        // $data['zilla_list'] = DB::table('zillas')->get();


        $data['zilla_list'] = DB::table('zillas')
            ->leftJoin('divisions', 'zillas.division_id', '=', 'divisions.id')
            ->select('zillas.*', 'divisions.name_en as division_name')
            ->get();

        $data['divisions'] = DB::table('divisions')->orderBy('name_en')->get();
        $data['active_menu'] = 'zilla';
        $data['page_title'] = 'Zilla';
        return view('backend.admin.pages.zilla', compact('data'));
    }

    public function zilla_delete($id)
    {
        $server_response = ['status' => 'FAILED', 'message' => 'Not Found'];
        $zilla = Zilla::findOrFail($id);
        if ($zilla) {
            $zilla->delete();
            $server_response = ['status' => 'SUCCESS', 'message' => 'delete Successfully'];
        }
        echo json_encode($server_response);
    }
}
