<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Models\ImportantLink;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;
use PDOException;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;



class ImportantLinkController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            BackendAuthenticationMiddleware::class,
            AdminAuthenticationMiddleware::class
        ];
    }


    // add data 

    public function link_add(Request $request)
    {
        $data = [];
        if ($request->isMethod('post')) {
            $photo = $request->file('photo');
            if ($photo) {
                $photo_extension = $photo->getClientOriginalExtension();
                $photo_name = 'backend_assets/images/links/'.uniqid().'.'.$photo_extension;
                $image = Image::make($photo);
                // $image->resize(300,300);
                $image->save($photo_name);
            } else {
                $photo_name = null;
            }
            try {
                ImportantLink::create([
                    'title' => $request->title,
                    'site_link' => $request->site_link,
                    'photo' => $photo_name,
                    'priority' => $request->priority,
                    'link_type' => $request->link_type,
                ]);
                return back()->with('success', 'Added Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again');
            }
        }
        $data['active_menu'] = 'important_link_add';
        $data['page_title'] = 'Important Link Add';
        return view('backend.admin.pages.important_link_add', compact('data'));
    }

    // edit data 

    public function link_edit(Request $request, $id)
    {
        $data = [];
        $data['link'] = ImportantLink::findOrFail($id);
        if ($request->isMethod('post')) {
            $old_photo = $data['link']->photo;
            $photo = $request->file('photo');
            if ($photo) {
                $photo_extension = $photo->getClientOriginalExtension();
                $photo_name = 'backend_assets/images/links' . uniqid() . '.' . $photo_extension;

                $photo->move(public_path('backend_assets/images/links'), basename($photo_name));

                 if(File::exists($old_photo)){
                 File::delete($old_photo);
                }
            }else{
                $photo_name = $old_photo;
            }
              if($request->title){
                $title = bcrypt($request->title);
             }else{
                $title = $data['link']->title;
             }
              if($request->site_link){
                $site_link = bcrypt($request->site_link);
             }else{
                $site_link = $data['link']->site_link;
             }
              if($request->priority){
                $priority = bcrypt($request->priority);
             }else{
                $priority = $data['link']->priority;
             }
              if($request->link_type){
                $link_type = bcrypt($request->link_type);
             }else{
                $link_type = $data['link']->link_type;
             }
             try{
                $data['link']->update([
                    'title'=> $request-> title,
                    'site_link'=> $request-> site_link,
                    'photo'=> $request-> $photo_name,
                    'priority'=> $request-> priority,
                    'link_type'=> $request-> link_type,
                ]);
                return back()->with('success', 'Updated Successfully');
             } catch(PDOException $e){
                return back()->with('error', 'Failed Please try Again');
             }
        }
        $data['active_menu'] = 'link_edit';
        $data['page_title'] = 'Link Edit';
        return view('backend.admin.pages.important_link_edit', compact('data'));
    }


    // List 

    public function link_list()
    {
        $data = [];
        $data['link_list'] = DB::table('important_links')->select('id', 'title', 'site_link', 'photo', 'priority', 'link_type')->get();
        $data['active_menu'] = 'link_list';
        $data['page_title'] = 'Link List';
        return view('backend.admin.pages.important_link_list', compact('data'));

       
    }

    public function link_delete($id){
        $server_response = ['status'=> 'FAILED', 'message'=>'Not Found'];
        $link = ImportantLink::findOrFail($id);
        if($link){
            if(File::exists($link->photo)){
                File::delete($link->photo);
            }
            $link->delete();
            $server_response=['status'=>'SUCCESS','message'=>'Deleted Successfully'];
        }else{
            $server_response = ['status'=> 'FAILED', 'message'=>'Not Found'];
        }
        echo json_encode($server_response);
    }
}
