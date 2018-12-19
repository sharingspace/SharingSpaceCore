<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Menu;
use Helper;

class PageController extends Controller
{

    public function viewHomePage(){
        $data = Page::orderBy("created_at", 'desc')->first();
        return view('frontend.home',$data);
        // return view('frontend.page');
    }

    public function viewSlugPage($slug){
        $data = Page::where("slug", $slug)->first();
        return view('frontend.home',$data);
        // return view('frontend.page');
    }

    public function dashboard(){
        $data['module_subtitle'] = 'Dashboard';
        return view('frontend.dashboard',$data);
    }

    public function adminControl(){
        $data['module_subtitle'] = 'Page List';
        $data['module_subtitle_menu'] = 'Menu List';
        $data['pages'] = Page::latest()->paginate(10);
        $data['menus'] = Menu::latest()->paginate(10);
        return view('frontend.control',$data);
    }

    public function adminControlCreate(){
        $data['module_subtitle'] = 'Create Page';        
        return view('frontend.control-view',$data);
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
        
        return view('frontend.control-view',$data);
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

    public function indexMenu(){
        $data['module_subtitle_menu'] = 'Menu List';
        $data['menus'] = Menu::latest()->paginate(10);
        return view('frontend.menu',$data);
    }

    public function createMenu(){
        $data['module_subtitle'] = 'Create Menu';
        $menu = Menu::pluck('page_id')->toarray();
        $data['pages'] = Helper::injectselect(Page::whereNotIn('id',$menu)->pluck('title','id'),'Select Page Name');        
        return view('frontend.menu-view',$data);
    }

    public function postMenu(Request $request) {
        $this->validate($request, [
            "name" => "required",
            "page_id" => "required",
        ]);
        
        \DB::beginTransaction();
        try {   
                $item = Menu::create($request->all());

        } catch (\Exception $e) {                
            
            \DB::rollback();
            throw new GeneralException("Something goes wrong!");
        }
        \DB::commit();

        return redirect()->back()->withFlashSuccess('Menu Created!');
    }

    public function editMenu($id, Request $request) {
        $data['module_subtitle'] = 'Edit Menu';
        $menu = Menu::where('id',"!=", $id)->pluck('page_id')->toarray();

        $data['pages'] = Helper::injectselect(Page::whereNotIn('id',$menu)->pluck('title','id'),'Select Page Name');        
        $data['model'] = Menu::findorfail($id);
        
        return view('frontend.menu-view',$data);
    }

    public function updateMenu(Request $request) {
        $this->validate($request, [
            "name" => "required",
            "page_id" => "required",
        ]);
        
        \DB::beginTransaction();
        try {   
                Menu::findorfail($request->id)->update($request->all());

        } catch (\Exception $e) {                
            
            \DB::rollback();
            throw new GeneralException("Something goes wrong!");
        }
        \DB::commit();

        return redirect()->back()->withFlashSuccess('Menu Updated!');
    }

    public function deleteMenu($id, Request $request) {
        Menu::findorfail($id)->delete();
 
        return redirect()->back()->withFlashSuccess('Menu Deleteed!');
    }
}
