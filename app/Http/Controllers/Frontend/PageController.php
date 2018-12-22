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
        $data['menus'] = Menu::orderBy('order','asc')->get();
        $data["menu"] = Menu::where("name", 'home')->first();
        return view('frontend.home',$data);
        // return view('frontend.page');
    }

    public function viewFeatures(){
        return view('frontend.features');
    }

    public function viewAbout(){
        return view('frontend.about');
    }

    public function viewPricing(){
        return view('frontend.pricing');
    }

    public function viewPrivacy(){
        return view('frontend.privacy');
    }

    public function viewTerms(){
        return view('frontend.terms');
    }

    public function viewContact(){
        return view('frontend.contact');
    }

    public function viewSlugPage($slug){
        $data['menus'] = Menu::orderBy('order','asc')->get();
        $page = Page::where("slug", $slug)->first();
        if($page){
            $data['menu'] = Menu::where("page_id", $page->id)->first();
            if($slug == 'home'){
                return redirect(url('/'));
            }
            return view('frontend.custom-home',$data);
        } else {
            return view('errors.404');
        }
    }

    public function dashboard(){
        $data['menus'] = Menu::orderBy('order','asc')->get();
        $data['module_subtitle'] = 'Dashboard';
        return view('frontend.dashboard',$data);
    }

    public function adminControl(){
        $data['menus'] = Menu::orderBy('order','asc')->get();
        $data['module_subtitle'] = 'Page List';
        $data['module_subtitle_menu'] = 'Menu List';
        $data['pages'] = Page::latest()->paginate(10);
        $data['menus'] = Menu::latest()->paginate(10);
        return view('frontend.control',$data);
    }

    public function adminControlCreate(){
        $data['menus'] = Menu::orderBy('order','asc')->get();
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
        $page = Page::where("slug", $request->slug)->first();
        if($page){
            throw new GeneralException("This title already exist please choose different title!");
        }
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
        $data['menus'] = Menu::orderBy('order','asc')->get();
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
        $page = Page::where("slug", $request->slug)->where('id','!=',$request->id)->first();
        if($page){
            throw new GeneralException("This title already exist please choose different title!");
        }
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
        $data['menus'] = Menu::orderBy('order','asc')->get();
        $data['module_subtitle_menu'] = 'Arrange Menu';
        $data['menus_data'] = Menu::orderBy('order','asc')->get();
        return view('frontend.drag-menu',$data);
    }

    public function postMenuOrder(Request $request) {
        $str = $request->data;
        preg_match_all('!\d+!', $str, $matches);

        $i = 1;
        foreach ($matches[0] as $key => $value) {
            $menu = Menu::findorfail($value);
            $menu->update(['order' => $i]);            
            $i++;
        }
        return Helper::sendResponse(true, 'Menu items arraged!');
    }
    public function createMenu(){
        $data['menus'] = Menu::orderBy('order','asc')->get();
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
        $data['menus'] = Menu::orderBy('order','asc')->get();
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
        $menu = Menu::findorfail($id);
        if($menu){
            if(ucfirst($menu->name) == "Home" ){
                throw new GeneralException("You cannot delete");
            } else {
                $menu->delete();
            }
        }
        return redirect()->back()->withFlashSuccess('Menu Deleteed!');
    }
}
