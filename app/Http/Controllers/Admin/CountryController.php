<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('name')->paginate(20);
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:countries,name',
            'code' => 'required|string|size:2|unique:countries,code', // mã ISO 2 chữ (VD: VN, US)
        ]);

        Country::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Thêm quốc gia thành công!');
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:countries,name,' . $country->id,
            'code' => 'required|string|size:2|unique:countries,code,' . $country->id,
        ]);

        $country->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Cập nhật quốc gia thành công!');
    }

    public function destroy(Country $country)
    {
        if ($country->movies()->count() > 0) {
            return back()->with('error', 'Không thể xóa! Có phim đang sử dụng quốc gia này.');
        }

        $country->delete();
        return back()->with('success', 'Xóa quốc gia thành công!');
    }
}