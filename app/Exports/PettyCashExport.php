<?php

namespace App\Exports;

use App\Models\PettyCash;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;

class PettyCashExport implements WithMapping, FromQuery
{
    public function query()
    {
        return PettyCash::with('paylist');
    }

    public function map($petty_cash): array
    {
        return $petty_cash->paylist->map(function ($paylist) use ($petty_cash) {
            return [
                "\{TAB 3}",
                "PCT-00001",
                "\{TAB}",
                "เงินสด",
                "\{TAB}",
                "64/10/001",
                "\{TAB}",
                $petty_cash->created_at->format('d-m-Y'),
                "\{TAB}",
                $petty_cash->created_at->format('d-m-Y'),
                "\{TAB}",
                $paylist->amount,
                "\{TAB}",
                $petty_cash->pay_to." "."/"." ".$paylist->description,
                "\{TAB}",
                $petty_cash->created_at->format('d-m-Y'),
                $petty_cash->created_at->format('d-m-Y'),
                $petty_cash->created_at->format('d-m-Y'),
                "\{TAB}",
                $paylist->invoice_id,
                "\{TAB}",
                "64/10/001",
                "\%O",
                "*SL1",
                "\%2",
                "\%",
                "*SL2",
                "\{TAB 2}"
            ];
        })->toArray();
    }
}
