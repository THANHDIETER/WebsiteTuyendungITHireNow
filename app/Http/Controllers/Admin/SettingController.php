<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key')->get();
        return view('admin.settings.index', compact('settings'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:191',
            'name' => 'nullable|string|max:255',
            'value' => 'nullable|string|max:1000',
        ]);

        Setting::updateOrCreate(
            ['key' => $request->input('key')],
            [
                'name' => $request->input('name'),
                'value' => $request->input('value'),
            ]
        );

        return redirect()->route('admin.settings.index')->with('success', 'Đã lưu cấu hình.');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('admin.settings.index')->with('success', 'Đã xoá cấu hình.');
    }

    public function restoreDefaults()
    {
        $defaults = Setting::getAllDefaults();

        foreach ($defaults as $key => $item) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'name' => $item['name'],
                    'value' => $item['value']
                ]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Đã khôi phục cấu hình mặc định!');
    }


}
