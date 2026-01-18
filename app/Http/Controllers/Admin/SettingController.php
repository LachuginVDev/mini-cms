<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $bannerTitle = Setting::get('banner_title', 'Добро пожаловать');
        $bannerSubtitle = Setting::get('banner_subtitle', 'Начните создавать удивительные посты');
        $bannerImage = Setting::get('banner_image');

        return view('admin.settings.edit', compact('bannerTitle', 'bannerSubtitle', 'bannerImage'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'banner_title' => ['required', 'string', 'max:255'],
            'banner_subtitle' => ['required', 'string', 'max:500'],
            'banner_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        Setting::set('banner_title', $request->banner_title);
        Setting::set('banner_subtitle', $request->banner_subtitle);

        if ($request->hasFile('banner_image')) {
            $oldImage = Setting::get('banner_image');

            if ($oldImage) {
                $oldPath = str_replace('/storage/', '', parse_url($oldImage, PHP_URL_PATH));
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $imagePath = $request->file('banner_image')->store('banners', 'public');
            Setting::set('banner_image', Storage::url($imagePath));
        }

        if ($request->has('remove_image') && $request->remove_image == '1') {
            $oldImage = Setting::get('banner_image');
            if ($oldImage) {
                $oldPath = str_replace('/storage/', '', parse_url($oldImage, PHP_URL_PATH));
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            Setting::set('banner_image', null);
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Настройки баннера успешно обновлены');
    }
}
