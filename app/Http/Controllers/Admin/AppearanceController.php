<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppearanceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AppearanceController extends Controller
{
    public function edit()
    {
        $setting = AppearanceSetting::first() ?? new AppearanceSetting();
        return view('admin.appearance.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = AppearanceSetting::first() ?? new AppearanceSetting();

        $path = public_path('uploads/appearance');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true, true);
        }

        if ($request->hasFile('login_background')) {
            if ($setting->login_background && File::exists(public_path($setting->login_background))) {
                File::delete(public_path($setting->login_background));
            }
            $file = $request->file('login_background');
            $filename = 'bg_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $setting->login_background = 'uploads/appearance/' . $filename;
        }

        if ($request->hasFile('system_logo')) {
            if ($setting->system_logo && File::exists(public_path($setting->system_logo))) {
                File::delete(public_path($setting->system_logo));
            }
            $file = $request->file('system_logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $setting->system_logo = 'uploads/appearance/' . $filename;
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon && File::exists(public_path($setting->favicon))) {
                File::delete(public_path($setting->favicon));
            }
            $file = $request->file('favicon');
            $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $setting->favicon = 'uploads/appearance/' . $filename;
        }

        $setting->save();

        return redirect()->back()->with('success', 'Apariencia actualizada correctamente.');
    }
}