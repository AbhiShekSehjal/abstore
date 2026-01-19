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
            'slider_image_1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'slider_image_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'slider_image_3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'Section_3_Image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'ORcode' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'main_heading' => 'nullable|string',
            'main_pera' => 'nullable|string',
            'Section_3_Text' => 'nullable|string',
            'Section_3_Text2' => 'nullable|string'
        ]);

        // Get first setting or create if not exists
        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create([]);
        }

        $updateData = [];

        // Handle image uploads
        foreach (['slider_image_1', 'slider_image_2', 'slider_image_3', 'logo', 'Section_3_Image', 'ORcode'] as $field) {
            if ($request->hasFile($field)) {
                // Delete old image if exists
                if ($setting->$field && Storage::disk('public')->exists($setting->$field)) {
                    Storage::disk('public')->delete($setting->$field);
                }

                // Store new image
                $updateData[$field] = $request->file($field)->store('settings', 'public');
            }
        }

        // Handle text fields - always update them (even if empty)
        $updateData['main_heading'] = $request->input('main_heading');
        $updateData['main_pera'] = $request->input('main_pera');
        $updateData['Section_3_Text'] = $request->input('Section_3_Text');
        $updateData['Section_3_Text2'] = $request->input('Section_3_Text2');

        // Update setting with all data
        $setting->update($updateData);

        return back()->with('success', 'Settings updated successfully!');
    }
}
