<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Models\SharedProduct;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class SharedProductController extends Controller
{
    public function index()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $countries = Country::all();
        $categories = Category::all();
        $products = SharedProduct::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('seller.sharedproduct.index', compact('products', 'countries', 'categories', 'offer'));
    }

    public function show($id)
    {
        $product = SharedProduct::findorfail($id);
        return view('seller.sharedproduct.show', compact('product'));
    }

    public function import($id)
    {
        $existingRecord = DB::table('shared_product_seller')
            ->where('shared_product_id', $id)
            ->where('seller_id', auth()->guard('seller')->user()->id)
            ->first();

        if ($existingRecord) {
            return redirect()->back()->with('Import', 'Already imported');
        }

        DB::table('shared_product_seller')->insert([
            'shared_product_id' => $id,
            'seller_id' => auth()->guard('seller')->user()->id,
        ]);

        return redirect()->back()->with('Import', 'Product Imported');
    }


    public function exclude($id)
    {
        $productSeller = DB::table('shared_product_seller')
            ->where('shared_product_id', $id)
            ->where('seller_id', auth()->guard('seller')->user()->id)
            ->first();

        if (!$productSeller) {
            return redirect()->back()->with('Exclude', 'Already Excluded');
        }

        DB::table('shared_product_seller')
            ->where('shared_product_id', $id)
            ->where('seller_id', auth()->guard('seller')->user()->id)
            ->delete();

        return redirect()->back()->with('Exclude', 'Product Excluded');
    }

    public function imported_products()
    {

        $seller = auth()->guard('seller')->user();
        $importedProducts = SharedProduct::whereHas('sellers', function ($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);

        return view('seller.sharedproduct.imported', compact('importedProducts'));
    }

    public function country_filter(Request $request, $country)
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        // Now you can use the $country variable to filter your products
        $products = SharedProduct::whereHas('sharedcountries', function ($query) use ($country) {
            $query->where('countries.id', $country);
        })->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);

        $countries = Country::all();
        $categories = Category::all();
        return view('seller.sharedproduct.index', compact('products', 'countries', 'categories', 'offer'));
    }

    public function new_product()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $products = SharedProduct::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        $countries = Country::all();
        $categories = Category::all();
        return view('seller.sharedproduct.index', compact('products', 'countries', 'categories', 'offer'));
    }

    public function suggested_product()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $shared_products = DB::table('shared_product_seller')->pluck('shared_product_id')->toArray();
        $products = SharedProduct::whereIn('id', $shared_products)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        $countries = Country::all();
        $categories = Category::all();

        return view('seller.sharedproduct.index', compact('products', 'countries', 'categories', 'offer'));
    }

    public function search(Request $request)
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $query = SharedProduct::query();

        if ($request->has('title') && $request->title != '') {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('sku') && $request->sku != '') {
            $query->orWhere('sku', 'like', '%' . $request->sku . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->orWhere('category_id', $request->category_id);
        }

        $products = $query->orderBy('id', 'DESC')->paginate(COUNT);// Replace 10 with your desired number of items per page

        $countries = Country::all();
        $categories = Category::all();
        return view('seller.sharedproduct.index', compact('products', 'countries', 'categories', 'offer'));
    }
}
