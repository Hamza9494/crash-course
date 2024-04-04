<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('listings.index',  ['listings' => Listing::latest()->filter(request('tag'), request('search'))->paginate(4)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('listings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated_Job = $request->validate([
            "title" => "required|min:12|max:42",
            "comapny" => "unique:listings|required",
            "location" => "required",
            "email" => "email|required",
            "website" => "required",
            "tags" => "required|min:3",
            "description" => "required"
        ]);
        if ($request->hasFile('logo')) {
            $validated_Job['logo'] = $request->file('logo')->store('logos', 'public');
        };

        $validated_Job['user_id'] = auth()->id();
        Listing::create($validated_Job);

        return redirect('/')->with('success', 'listing added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        return view('listings.show', ['listing' => $listing]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Listing $listing)
    {
        $validated_Job = request()->validate([
            "title" => "required|min:12|max:42",
            "comapny" => "required",
            "location" => "required",
            "email" => "email|required",
            "website" => "required",
            "tags" => "required|min:3",
            "description" => "required"
        ]);
        if (request()->hasFile('logo')) {
            $validated_Job['logo'] = request()->file('logo')->store('logos', 'public');
        };
        $listing->update($validated_Job);

        return redirect("/listings/$listing->id")->with('success', 'listing updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();
        return redirect('/')->with('success', 'listing deleted successfully');
    }

    public function manage()
    {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
