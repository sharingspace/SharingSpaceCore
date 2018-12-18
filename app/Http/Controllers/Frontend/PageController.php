<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{

    public function viewHomePage(){
        return view('frontend.page');
    }

    public function adminControlIndex(){
        $data['module_subtitle'] = 'Page List';
        $data['pages'] = Page::latest()->paginate(10);
        return view('frontend.control-list',$data);
    }

    public function adminControl(){
        $data['module_subtitle'] = 'Create Page';
        return view('frontend.control',$data);
    }

    public function adminControlPost(Request $request) {
        $this->validate($request, [
            "title" => "required",
            "body" => "required",
            "slug" => "required",
            "meta_description" => "required",
            "meta_keywords" => "required",
            "status" => "required",
        ]);
        
        \DB::beginTransaction();
        try {   
                $item = Page::create($request->all());

        } catch (\Exception $e) {                
            
            \DB::rollback();
            throw new GeneralException("Something goes wrong!");
        }
        \DB::commit();

        return redirect()->back()->withFlashSuccess('Page Created!');
    }

    public function getControlEdit($id, Request $request) {
        $data['module_subtitle'] = 'Edit Page';
        $data['model'] = Page::findorfail($id);
 
        return view('frontend.control',$data);
    }

    public function postControlEdit(Request $request) {
        $this->validate($request, [
            "title" => "required",
            "body" => "required",
            "slug" => "required",
            "meta_description" => "required",
            "meta_keywords" => "required",
            "status" => "required",
        ]);
        
        \DB::beginTransaction();
        try {   
                Page::findorfail($request->id)->update($request->all());

        } catch (\Exception $e) {                
            
            \DB::rollback();
            throw new GeneralException("Something goes wrong!");
        }
        \DB::commit();

        return redirect()->back()->withFlashSuccess('Page Updated!');
    }

    public function getControlDelete($id, Request $request) {
        Page::findorfail($id)->delete();
 
        return redirect()->back()->withFlashSuccess('Page Deleteed!');
    }
}
