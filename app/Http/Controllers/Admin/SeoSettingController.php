<?php 
namespace App\Http\Controllers\admin;

use App\Models\SeoSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeoSettingController extends Controller
{
    public function index()
    {
        // lấy record đầu tiên, nếu chưa có thì tạo mới
        $title = 'Cấu hình SEO Website';
        $seo = SeoSetting::first();
        return view('admin.seo.index', compact('seo', 'title'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $seo = SeoSetting::first();

        if (!$seo) {
            $seo = new SeoSetting();
        }

        $seo->title = $request->title;
        $seo->description = $request->description;
        $seo->keywords = $request->keywords;
        $seo->save();

        return redirect()->back()->with('success', 'Cập nhật SEO thành công!');
    }
}
