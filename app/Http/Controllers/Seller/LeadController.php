<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateLeadRequest;
use App\Models\AffiliateProduct;
use App\Models\Country;
use App\Models\Lead;
use App\Models\Order;
use App\Models\SharedProduct;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        $status = Lead::distinct()->pluck('status')->unique();
        $types = Lead::distinct()->pluck('type')->unique();
        $leads = Lead::where('seller_id', auth()->guard('seller')->id())->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('seller.leads.index', compact('leads', 'countries', 'status', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Filter out rows where all indices are empty
        $filteredData = array_filter($request->input('data'), function ($row) {
            // Filter out empty values in the row
            $filteredRow = array_filter($row);
            // Check if the filtered row is empty
            return !empty($filteredRow);
        });

        // If there are no valid rows after filtering, return an error
        if (empty($filteredData)) {
            return response()->json(['errors' => ['data' => ['At least one row of data is required.']]], 422);
        }
        $errors = [];
        foreach ($filteredData as $index => $row) {

            if (empty($row[2])) {
                $errors['message'] = "Warehouse is required at row " . $index + 1 . " cell 2 ";
            }
            if (empty($row[3])) {
                $errors['message'] = "Customer name is required at row " . $index + 1 . " cell 3";
            }
            if (empty($row[4])) {
                $errors['message'] = "Customer phone is required at row " . $index + 1 . " cell 4";
            }
            if (!empty($row[6])) {
                if (!filter_var($row[6], FILTER_VALIDATE_EMAIL)) {

                    $errors['message'] = "Customer email mmust be valid at row " . $index + 1 . " cell 6";
                }
            }
            if (empty($row[7])) {
                $errors['message'] = "Customer country is required at row " . $index + 1 . " cell 7";
            }
            if (empty($row[10])) {
                $errors['message'] = "Item SKU is required at row " . $index + 1 . " cell 10";
            }
            if (!empty($row[11])) {
                if (!is_numeric($row[11])) {
                    $errors['message'] = "Quantity must be a number at row " . $index + 1 . " cell 11 ";
                } else {
                    $maxInt = PHP_INT_MAX;
                    if ($row[11] > $maxInt) {
                        $errors['message'] = "Quantity exceeds the maximum value of integer type at row " . $index + 1 . " cell 11";
                    }
                    if ($row[11] <= 0) {
                        $errors['message'] = "Quantity  value must be gretter than 0  at row " . $index + 1 . " cell 11";
                    }
                }
            } else {
                $errors['message'] = "Quantity is required at row " . $index + 1 . " cell 11";
            }
            if (!empty($row[12])) {
                if (!is_numeric($row[12])) {
                    $errors['message'] = "Total must be a number at row " . $index + 1 . " cell 12";
                }
            } else {
                $errors['message'] = "Total is required at row " . $index + 1 . " cell 12";
            }
            if (empty($row[13])) {
                $errors['message'] = "Currency is required at row " . $index + 1 . " cell 13";
            }
            foreach ($filteredData as $index  => $row) {

                if ($row[7] !== $row[2]) {
                    $errors['country'] = "Customer country must be = product warehouse at row " . $index + 1 . " cell 7";
                }


                $SharedProduct = SharedProduct::where('sku', $row[10])->first();
                $AffiliateProduct = AffiliateProduct::where('sku', $row[10])->first();
                if ($SharedProduct) {
                    $price = $row[12] / $row[11];
                    if ($price < $SharedProduct->unit_cost) {
                        $errors['message'] = "Unit price must be = product unit price bigger at row" .  " . $index + 1 . "  + 1 . "cell 12";
                    }
                } else {
                    $price = $row[12] / $row[11];
                    if ($price < $AffiliateProduct->minimum_selling_price) {
                        $errors['message'] = "Unit price must be = product minimum_selling_price at row " . $index + 1 . " cell 12";
                    }
                }
            }

            // If there are errors for this row, add them to the allErrors array
            // if (!empty($errors)) {
            //     $allErrors["data"] = $errors;
            // }
            if (!empty($errors)) {
                $allErrors['data'] = [
                    'errors' => $errors,
                    'lock' => ['row' => $index + 1, 'cell' => $errors[0] ?? '']
                ];
            }
        }

        if (empty($errors)) {
            foreach ($filteredData as $index => $row) {

                $regular = SharedProduct::where('sku', $row[10])->exists();
                $commission = AffiliateProduct::where('sku', $row[10])->exists();
                $lead = Lead::create([
                    'order_date' => $row[0] ?? now()->toDateString(),
                    'store_reference' => auth()->guard('seller')->user()->id,
                    'store_name' => $row[1] ?? null,
                    'warehouse' => $row[2],
                    'customer_name' => $row[3],
                    'customer_phone' => $row[4],
                    'customer_mobile' => $row[5] ?? null,
                    'customer_email' => $row[6] ?? null,
                    'customer_country' => $row[7],
                    'customer_city' => $row[8] ?? null,
                    'customer_address' => $row[9] ?? null,
                    'item_sku' => $row[10],
                    'quantity' => $row[11],
                    'total' => $row[12],
                    'currency' => $row[13],
                    'notes' => $row[14] ?? null,
                    'type' => $commission ? 'commission' : ($regular ? 'regular' : null),
                    'seller_id' => auth()->guard('seller')->id(),
                ]);
            }
        }

        // If there are errors for any row, return all errors
        if (!empty($allErrors)) {
            return response()->json(['errors' => $allErrors], 422);
        }

        return response()->json(['Add' => 'Lead stored successfully'], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $seller = auth()->guard('seller')->user();
        $importedAffiliateProducts = AffiliateProduct::whereHas('affiliatesellers', function ($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->pluck('sku');

        $importedSharedProducts = SharedProduct::whereHas('sharedsellers', function ($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->pluck('sku');

        // Merge the two collections of SKUs
        $skus = $importedAffiliateProducts->merge($importedSharedProducts);

        $sku = implode(',', $skus->toArray());

        $country = Country::pluck('name');

        $countries = implode(',', $country->toArray());

        // Pass $sku and $countries to the view
        return view('seller.leads.create', compact('sku', 'countries'));
    }





    //return redirect()->route('leads.index')->with(['Add' => 'Lead created successfully.']);

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lead = Lead::findorfail($id);
        $sharedproduct = SharedProduct::where('sku', $lead->item_sku)->first();
        $affiliateproduct = AffiliateProduct::where('sku', $lead->item_sku)->first();
        $country = Country::where('name', $lead->warehouse)->first();
        return view('seller.leads.show', compact('lead', 'country', 'sharedproduct', 'affiliateproduct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $seller = auth()->guard('seller')->user();
        $countries = Country::all();
        $lead = Lead::findorfail($id);
        $importedAffiliateProducts = AffiliateProduct::whereHas('affiliatesellers', function ($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->pluck('sku');

        $importedSharedProducts = SharedProduct::whereHas('sharedsellers', function ($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->pluck('sku');

        // Merge the two collections of SKUs
        $skus = $importedAffiliateProducts->merge($importedSharedProducts);
        return view('seller.leads.edit', compact('lead', 'countries', 'skus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $request, string $id)
    {
        $lead = Lead::findorfail($id);
        if ($request->order_date !== null) {
            $order_date = $request->order_date;
        }
        $lead->update([
            'order_date' => $order_date ?? $lead->order_date,
            'store_reference' => $request->store_reference,
            'store_name' => $request->store_name,
            'warehouse' => $request->warehouse,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_mobile' => $request->customer_mobile,
            'customer_address' => $request->customer_address,
            'customer_city' => $request->customer_city,
            'customer_country' => $request->customer_country,
            'item_sku' => $request->item_sku,
            'quantity' => $request->quantity,
            'total' => $request->total,
            'currency' => $request->currency,

        ]);
        return redirect()->route('leads.index')->with(['Update' => 'Lead updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lead = Lead::findorfail($id);
        if ($lead->status == 'pending' && $lead->seller_id == auth()->guard('seller')->id()) {
            $lead->delete();
            return redirect()->route('leads.index')->with(['Delete' => 'Lead deleted successfully.']);
        }
        return redirect()->route('leads.index')->with(['Warning' => 'Lead cannot be deleted.']);
    }

    public function filter(Request $request)
    {

        $query = Lead::where('seller_id', auth()->guard('seller')->id());
        $start_date = '';
        $end_date = '';
        if ($request->has('created_at') && $request->created_at != '') {
            $dates = explode(' - ', $request->created_at);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->format('Y-m-d');
                $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->format('Y-m-d');

                // Apply the whereBetween condition on the 'order_date' column
                $query->whereBetween('order_date', [$start_date, $end_date]);
            }
        }


        if ($request->has('warehouse') && $request->warehouse != '') {
            $query->whereIn('warehouse', $request->warehouse);
        }

        if ($request->has('country') && $request->country != '') {
            $query->whereIn('customer_country', $request->country);
        }
        if ($request->has('status') && $request->status != '') {
            $query->whereIn('status', $request->status);
        }
        if ($request->has('type') && $request->type != '') {
            $query->whereIn('type', $request->type);
        }

        $leads = $query->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT); // Replace 10 with your desired number of items per page
        $countries = Country::all();
        $status = Lead::distinct()->pluck('status')->unique();
        $types = Lead::distinct()->pluck('type')->unique();
        return view('seller.leads.index', compact('leads', 'countries', 'status', 'types'));
    }
}
