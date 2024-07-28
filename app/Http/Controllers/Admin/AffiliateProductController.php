<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\Category;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Models\AffiliateProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AffiliateProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Affiliate Per Delivered')->only(['per_delivered', 'country_filter_per_delivered', 'new_product_per_delivered', 'suggested_product_per_delivered', 'search_per_delivereds']);
        $this->middleware('permission:Affiliate Per Confirmed')->only(['per_confirmed', 'country_filter_per_confirmed', 'new_product_per_confirmed', 'suggested_product_per_confirmed', 'search_per_confirmed']);
        $this->middleware('permission:Create Affiliate Product')->only(['create', 'store']);
        $this->middleware('permission:Edit Affiliate Product')->only(['edit', 'update']);
        $this->middleware('permission:Delete Affiliate Product')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function per_delivered()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $countries = Country::all();
        $categories = Category::all();
        $products = AffiliateProduct::where('type', 'delivered')->orderBy('id', 'DESC')->paginate(COUNT);
        return view('admin.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));
    }

    public function per_confirmed()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $countries = Country::all();
        $categories = Category::all();
        $products = AffiliateProduct::where('type', 'confirmed')->orderBy('id', 'DESC')->paginate(COUNT);
        return view('admin.affiliateproduct.perconfirmed', compact('products', 'countries', 'categories', 'offer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'sku' => 'required|max:100',
            'brand' => 'required|max:100',
            'image' => 'required|mimes:png,jpg',
            'description' => 'required|max:830938',
            'minimum_selling_price' => 'required|numeric',
            'commission' => 'required|numeric',
            'weight' => 'required|numeric',
            'type' => 'required',
            'category_id' => 'required',
            'country' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    // Check for duplicate values in the country array
                    if (count($value) !== count(array_unique($value))) {
                        $fail('The ' . $attribute . ' field contains duplicate values.');
                    }
                },
            ],
            'country.*' => 'exists:countries,id',
            'stock' => [
                'required_if:country,*', // Require 'stock' when 'country' is present
                'array',
            ],
            'stock.*' => 'required|integer|min:0', // Each stock item must be required, an integer, and greater than or equal to 0

        ]);
        if ($validator->fails()) {
            $errors = [];

            // Loop through each error message for each field
            foreach ($validator->errors()->all() as $fieldError) {
                // Extract the field name from the error message
                preg_match('/^The (\w+) field/', $fieldError, $matches);

                // Add the error message under the 'message' key
                $errors[] = ['message' => $fieldError];
                break; // Stop after adding the first error for each field
            }

            // Return the formatted errors in JSON response
            return response()->json(['errors' => $errors]);
        }
        // Get the image file
        $image = $request->file('image');
        // Generate a unique image name
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        // Move the uploaded image to the storage directory
        $image->move(public_path('assets/products/affiliateproduct/images'), $imageName);


        $product = AffiliateProduct::create([
            'sku' => $request->sku,
            'title' => $request->title,
            'brand' => $request->brand,
            'description' => $request->description,
            'image' => $imageName,
            'weight' => $request->weight,
            'minimum_selling_price' => $request->minimum_selling_price,
            'commission' => $request->commission,
            'category_id' => $request->category_id,
            'type' => $request->type,
            'admin_id' => auth()->guard('admin')->user()->id,
        ]);

        foreach ($request->country as $index => $countryId) {
            $product->affiliatecountries()->attach($countryId, ['stock' => $request->stock[$index]]);
        }

        return response()->json(['message' => 'Product created successfully'], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        $categories = Category::all();
        return view('admin.affiliateproduct.create', compact('categories', 'countries'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = AffiliateProduct::findorfail($id);
        return view('admin.affiliateproduct.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = AffiliateProduct::findorfail($id);
        $categories = Category::all();
        $countries = Country::all();
        return view('admin.affiliateproduct.edit', compact('product', 'categories', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'sku' => 'required|max:100',
            'brand' => 'required|max:100',
            'image' => 'nullable|mimes:png,jpg',
            'description' => 'required|max:830938',
            'minimum_selling_price' => 'required|numeric',
            'commission' => 'required|numeric',
            'weight' => 'required|numeric',
            'category_id' => 'required',
            'country' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    // Check for duplicate values in the country array
                    if (count($value) !== count(array_unique($value))) {
                        $fail('The ' . $attribute . ' field contains duplicate values.');
                    }
                },
            ],
            'country.*' => 'exists:countries,id',
            'stock' => [
                'required_if:country,*', // Require 'stock' when 'country' is present
                'array',
            ],
            'stock.*' => 'required|integer|min:0', // Each stock item must be required, an integer, and greater than or equal to 0

        ]);
        if ($validator->fails()) {
            $errors = [];

            // Loop through each error message for each field
            foreach ($validator->errors()->all() as $fieldError) {
                // Extract the field name from the error message
                preg_match('/^The (\w+) field/', $fieldError, $matches);

                // Add the error message under the 'message' key
                $errors[] = ['message' => $fieldError];
                break; // Stop after adding the first error for each field
            }

            // Return the formatted errors in JSON response
            return response()->json(['errors' => $errors]);
        }
        $product = AffiliateProduct::findOrFail($id);
        $oldImage = $product->image;

        if ($request->hasFile('image')) {

            if ($oldImage) {
                unlink(public_path('assets/products/affiliateproduct/images/' . $oldImage));
            }

            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/products/affiliateproduct/images'), $imageName);
        } else {
            $imageName = $oldImage;
        }

        $product->update([
            'sku' => $request->sku,
            'title' => $request->title,
            'brand' => $request->brand,
            'description' => $request->description,
            'image' => $imageName,
            'weight' => $request->weight,
            'minimum_selling_price' => $request->minimum_selling_price,
            'commission' => $request->commission,
            'category_id' => $request->category_id,
            'admin_id' => auth()->guard('admin')->user()->id,
        ]);

        $product->affiliatecountries()->detach();
        foreach ($request->country as $index => $countryId) {
            $product->affiliatecountries()->attach($countryId, ['stock' => $request->stock[$index]]);
        }

        return response()->json(['message' => 'Product Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = AffiliateProduct::findOrFail($id);

        if ($product->image) {
            $imagePath = public_path('assets/products/affiliateproduct/images/' . $product->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $product->delete();
        if ($product->type == 'delivered') {
            return redirect()->route('admin.affiliate.per.delivered')->with('Delete', 'Product deleted successfully.');
        } else {

            return redirect()->route('admin.affiliate.per.confirmed')->with('Delete', 'Product deleted successfully.');
        }
    }

    public function country_filter_per_delivered(Request $request, $country)
    {

        // Now you can use the $selectedCountry variable to filter your products
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $products = AffiliateProduct::where('type', 'delivered')->whereHas('affiliatecountries', function ($query) use ($country) {
            $query->where('country_id', $country);
        })->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $categories = Category::all();
        return view('admin.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));
    }

    public function new_product_per_delivered()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $products = AffiliateProduct::where('type', 'delivered')->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $categories = Category::all();
        return view('admin.affiliateproduct.perdelivered', compact('products', 'countries', 'categories' . 'offer'));
    }

    public function suggested_product_per_delivered()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $affiliate_products = DB::table('affiliate_product_seller')->pluck('affiliate_product_id')->toArray();

        $products = AffiliateProduct::where('type', 'delivered')->whereIn('id', $affiliate_products)->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $categories = Category::all();
        return view('admin.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));
    }

    public function search_per_delivered(Request $request)
    {

        $query = AffiliateProduct::where('type', 'delivered')->query();

        if ($request->has('title') && $request->title != '') {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('sku') && $request->sku != '') {
            $query->orWhere('sku', 'like', '%' . $request->sku . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->orWhere('category_id', $request->category_id);
        }

        if ($request->has('type') && $request->type != '') {
            $query->orWhere('type', $request->type);
        }


        $products = $query->orderBy('id', 'DESC')->paginate(COUNT); // Replace 10 with your desired number of items per page
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $countries = Country::all();
        $categories = Category::all();
        return view('admin.affiliateproduct.perdelivered', compact('products', 'countries', 'categories' . 'offer'));
    }

    public function country_filter_per_confirmed(Request $request, $country)
    {

        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        // Now you can use the $selectedCountry variable to filter your products
        $products = AffiliateProduct::where('type', 'confirmed')->whereHas('affiliatecountries', function ($query) use ($country) {
            $query->where('country_id', $country);
        })->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $categories = Category::all();
        return view('admin.affiliateproduct.perconfirmed', compact('products', 'countries', 'categories', 'offer'));
    }

    public function new_product_per_confirmed()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $products = AffiliateProduct::where('type', 'confirmed')->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $categories = Category::all();
        return view('admin.affiliateproduct.perconfirmed', compact('products', 'countries', 'categories' . 'offer'));
    }

    public function suggested_product_per_confirmed()
    {
        $affiliate_products = DB::table('affiliate_product_seller')->pluck('affiliate_product_id')->toArray();
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $products = AffiliateProduct::where('type', 'confirmed')->whereIn('id', $affiliate_products)->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $categories = Category::all();
        return view('admin.affiliateproduct.perconfirmed', compact('products', 'countries', 'categories', 'offer'));
    }

    public function search_per_confirmed(Request $request)
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $query = AffiliateProduct::where('type', 'confirmed')->query();

        if ($request->has('title') && $request->title != '') {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('sku') && $request->sku != '') {
            $query->orWhere('sku', 'like', '%' . $request->sku . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->orWhere('category_id', $request->category_id);
        }

        if ($request->has('type') && $request->type != '') {
            $query->orWhere('type', $request->type);
        }


        $products = $query->orderBy('id', 'DESC')->paginate(COUNT); // Replace 10 with your desired number of items per page

        $countries = Country::all();
        $categories = Category::all();
        return view('admin.affiliateproduct.perconfirmed', compact('products', 'countries', 'categories', 'offer'));
    }
}
