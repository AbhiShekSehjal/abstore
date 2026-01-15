<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminSettingsController extends Controller
{
    // Show settings page
    public function index()
    {
        if (Auth::check()) {
            $settings = Setting::first();
            
            return view('admin.settings', compact('settings'));
        } else {
            return redirect()->route('AdminLoginPage');
        }
    }

    // Update settings
    public function update(Request $request)
    {
        // Validate uploaded images
        $validated = $request->validate([
            'slider_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slider_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slider_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Section_3_Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_heading' => 'nullable|string',
            'main_pera' => 'nullable|string',
            'Section_3_Text' => 'nullable|string',
            'Section_3_Text2' => 'nullable|string'
        ]);

        // Get first setting or create if not exists
        $setting = Setting::firstOrCreate([]);

        $updateData = [];

        foreach (['slider_image_1', 'slider_image_2', 'slider_image_3', 'logo', 'Section_3_Image'] as $field) {
            if ($request->hasFile($field)) {
                // Delete old image if exists
                if ($setting->$field && Storage::disk('public')->exists($setting->$field)) {
                    Storage::disk('public')->delete($setting->$field);
                }

                // Store new image
                $updateData[$field] = $request->file($field)->store('settings', 'public');
            }
        }

        $updateData['main_heading'] = $request->main_heading;
        $updateData['main_pera'] = $request->main_pera;
        $updateData['Section_3_Text'] = $request->Section_3_Text;
        $updateData['Section_3_Text2'] = $request->Section_3_Text2;

        // Update setting if any new images uploaded
        if (!empty($updateData)) {
            $setting->update($updateData);
        }

        return back()->with('success', 'Settings updated successfully!');
    }
}
