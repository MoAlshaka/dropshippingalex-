<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadExport implements FromArray, WithHeadings
{
    /**
     * @return array
     */
    public function array(): array
    {
        $leads = [];
        $all_leads = Lead::all();
        foreach ($all_leads as $lead) {
            $leads[] = [
                $lead->order_date,
                $lead->store_reference,
                $lead->store_name,
                $lead->customer_name,
                $lead->customer_email,
                $lead->customer_phone,
                $lead->customer_mobile,
                $lead->customer_address,
                $lead->customer_city,
                $lead->customer_country,
                $lead->item_sku,
                $lead->warehouse,
                $lead->quantity,
                $lead->total,
                $lead->currency,
                $lead->status,
                $lead->seller_id,

            ];
        }
        return $leads;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Order Date',
            'Store Reference',
            'Store Name',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Customer Mobile',
            'Customer Address',
            'Customer City',
            'Customer Country',
            'Item SKU',
            'Warehouse',
            'Quantity',
            'Total',
            'Currency',
            'Status',
            'Seller REF',

        ];
    }
}
