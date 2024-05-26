<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Models\AffiliateProduct;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class AffiliateProductController extends Controller
{
    public function per_delivered()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $countries = Country::all();
        $categories = Category::all();
        $products = AffiliateProduct::where('type', 'delivered')->orderBy('id', 'DESC')->paginate(COUNT);
        return view('seller.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));
    }

    public function per_confirmed()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $countries = Country::all();
        $categories = Category::all();
        $products = AffiliateProduct::where('type', 'confirmed')->orderBy('id', 'DESC')->paginate(COUNT);
        return view('seller.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));
    }

    public function show($id)
    {
        $product = AffiliateProduct::findorfail($id);
        return view('seller.affiliateproduct.show', compact('product'));
    }

    public function import($id)
    {
        $existingRecord = DB::table('affiliate_product_seller')
            ->where('affiliate_product_id', $id)
            ->where('seller_id', auth()->guard('seller')->user()->id)
            ->first();

        if ($existingRecord) {
            return redirect()->back()->with('Import', 'Already imported');
        }

        DB::table('affiliate_product_seller')->insert([
            'affiliate_product_id' => $id,
            'seller_id' => auth()->guard('seller')->user()->id,
        ]);

        return redirect()->back()->with('Import', 'Product Imported');
    }


    public function exclude($id)
    {
        $productSeller = DB::table('affiliate_product_seller')
            ->where('affiliate_product_id', $id)
            ->where('seller_id', auth()->guard('seller')->user()->id)
            ->first();

        if (!$productSeller) {
            return redirect()->back()->with('Exclude', 'Already Excluded');
        }

        DB::table('affiliate_product_seller')
            ->where('affiliate_product_id', $id)
            ->where('seller_id', auth()->guard('seller')->user()->id)
            ->delete();

        return redirect()->back()->with('Exclude', 'Product Excluded');
    }


//    public function country_filter(Request $request, $country)
//    {
//        // Now you can use the $country variable to filter your products
//        $products = AffiliateProduct::whereHas('affiliatecountries', function ($query) use ($country) {
//            $query->where('countries.id', $country);
//        })->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
//
//        $countries = Country::all();
//        $categories = Category::all();
//        return view('seller.affiliateproduct.index', compact('products', 'countries', 'categories'));
//    }
//
//    public function new_product()
//    {
//        $products = AffiliateProduct::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
//        $countries = Country::all();
//        $categories = Category::all();
//        return view('seller.affiliateproduct.index', compact('products', 'countries', 'categories'));
//    }
//
//    public function suggested_product()
//    {
//        $affiliate_products = DB::table('affiliate_product_seller')->pluck('affiliate_product_id')->toArray();
//
//        $products = AffiliateProduct::whereIn('id', $affiliate_products)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
//        $countries = Country::all();
//        $categories = Category::all();
//        return view('seller.affiliateproduct.index', compact('products', 'countries', 'categories'));
//    }
//
//    public function search(Request $request)
//    {
//        $query = AffiliateProduct::query();
//
//        if ($request->has('title') && $request->title != '') {
//            $query->where('title', 'like', '%' . $request->title . '%');
//        }
//
//        if ($request->has('sku') && $request->sku != '') {
//            $query->orWhere('sku', 'like', '%' . $request->sku . '%');
//        }
//
//        if ($request->has('category_id') && $request->category_id != '') {
//            $query->orWhere('category_id', $request->category_id);
//        }
//
//        $products = $query->orderBy('id', 'DESC')->paginate(COUNT);// Replace 10 with your desired number of items per page
//
//        $countries = Country::all();
//        $categories = Category::all();
//        return view('seller.affiliateproduct.index', compact('products', 'countries', 'categories'));
//    }

    public function country_filter_per_delivered(Request $request, $country)
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        // Now you can use the $selectedCountry variable to filter your products
        $products = AffiliateProduct::where('type', 'delivered')->whereHas('affiliatecountries', function ($query) use ($country) {
            $query->where('country_id', $country);
        })->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $categories = Category::all();
        return view('seller.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));
    }

    public function new_product_per_delivered()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $products = AffiliateProduct::where('type', 'delivered')->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $categories = Category::all();
        return view('seller.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));
    }

    public function suggested_product_per_delivered()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $affiliate_products = DB::table('affiliate_product_seller')->pluck('affiliate_product_id')->toArray();

        $products = AffiliateProduct::where('type', 'delivered')->whereIn('id', $affiliate_products)->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $categories = Category::all();
        return view('seller.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));
    }

    public function search_per_delivered(Request $request)
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
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


        $products = $query->orderBy('id', 'DESC')->paginate(COUNT);// Replace 10 with your desired number of items per page

        $countries = Country::all();
        $categories = Category::all();
        return view('seller.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));

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
        return view('seller.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));
    }

    public function new_product_per_confirmed()
    {
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $products = AffiliateProduct::where('type', 'confirmed')->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $categories = Category::all();
        return view('seller.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));
    }

    public function suggested_product_per_confirmed()
    {
        $affiliate_products = DB::table('affiliate_product_seller')->pluck('affiliate_product_id')->toArray();
        $offer = Offer::where('end_date', '>', now())->orderBy('id', 'DESC')->get();
        $products = AffiliateProduct::where('type', 'confirmed')->whereIn('id', $affiliate_products)->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $categories = Category::all();
        return view('seller.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));
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


        $products = $query->orderBy('id', 'DESC')->paginate(COUNT);// Replace 10 with your desired number of items per page

        $countries = Country::all();
        $categories = Category::all();
        return view('seller.affiliateproduct.perdelivered', compact('products', 'countries', 'categories', 'offer'));

    }
}
