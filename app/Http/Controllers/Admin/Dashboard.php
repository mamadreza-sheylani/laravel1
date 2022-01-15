<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {
        $month = 12;
        $succeded_transactions = Transaction::getData($month, 1);
        $chart_succeded_trans = $this->chart($succeded_transactions, $month);

        $faild_transactions = Transaction::getData($month, 0);
        $chart_faild_trans = $this->chart($faild_transactions, $month);

        // dd($this->doughnut($succeded_transactions, $faild_transactions));

        return view("admin.dashboard", [
            "succeded_transactions" => array_values($chart_succeded_trans),
            "faild_transactions" => array_values($chart_faild_trans),
            "labels" => array_keys($chart_succeded_trans),
            "doughnut" => [count($succeded_transactions), count($faild_transactions)]
        ]);
    }

    public function chart($transaction, $month)
    {

        $month_name = $transaction->map(function ($item) {
            return verta($item->created_at)->format("%B %y");
        });

        $amount = $transaction->map(function ($item) {
            return $item->amount;
        });

        foreach ($month_name as $index => $value) {
            if (!isset($result[$value])) {
                $result[$value] = 0;
            }
            $result[$value] += $amount[$index];
        }

        if (count($result) != $month) {
            for ($i = 0; $i < $month; $i++) {
                $month_name = verta()->subMonth($i)->format("%B %y");
                $shamsiMonth[$month_name] = 0;
                // 0 is the amount when there's no faild transaction
                // in a specific month
            }
            return array_reverse(array_merge($shamsiMonth, $result));
        }
        return $result;
    }
}
