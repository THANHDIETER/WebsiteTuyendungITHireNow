<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiConfig;
use Illuminate\Http\Request;

class AiConfigController extends Controller
{
    public function index()
    {
        $title = 'Cấu hình AI';
        $configs = AiConfig::all();
        return view('admin.ai-configs.index', compact('configs', 'title'));
    }

    // Cập nhật tất cả configs một lần
    public function updateAll(Request $request)
    {
        $request->validate([
            'configs'   => 'required|array',
            'configs.*' => 'nullable|string',
        ]);

        foreach ($request->configs as $id => $value) {
            AiConfig::where('id', $id)->update(['value' => $value]);
        }

        return response()->json(['success' => true, 'message' => 'Lưu tất cả cấu hình thành công']);
    }
}
