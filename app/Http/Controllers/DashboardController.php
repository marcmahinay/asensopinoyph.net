<?php

namespace App\Http\Controllers;

use App\Models\AssistanceReceived;
use App\Models\Beneficiary;
use App\Models\VoucherCode;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $active_beneficiaries = Beneficiary::where('status', 1)->count();

        $current_month_assistance_received = AssistanceReceived::where('received_at', 'like', date('Y-m') . '%')->count();
        $previous_month_assistance_received = AssistanceReceived::where('received_at', 'like', date('Y-m', strtotime('-1 month')) . '%')->count();
        $assistance_provided_current_year = AssistanceReceived::where('received_at', 'like', date('Y') . '%')->count();
        $assistance_provided_previous_year = AssistanceReceived::where('received_at', 'like', date('Y', strtotime('-1 year')) . '%')->count();
        $percentage_change_year = 0;
        if ($assistance_provided_previous_year > 0) {
            $percentage_change_year = (($assistance_provided_current_year - $assistance_provided_previous_year) / $assistance_provided_previous_year) * 100;
        } elseif ($assistance_provided_current_year > 0) {
            $percentage_change_year = 100; // 100% increase if previous year was 0
        }

        $percentage_change = 0;
        if ($previous_month_assistance_received > 0) {
            $percentage_change = (($current_month_assistance_received - $previous_month_assistance_received) / $previous_month_assistance_received) * 100;
        }

        $current_voucher_redeemed = VoucherCode::where('is_redeemed', 1)->where('redeemed_at', 'like', date('Y-m') . '%')->count();
        $previous_voucher_redeemed = VoucherCode::where('is_redeemed', 1)->where('redeemed_at', 'like', date('Y-m', strtotime('-1 month')) . '%')->count();
        $percentage_change_voucher = 0;
        if ($previous_voucher_redeemed > 0) {
            $percentage_change_voucher = (($current_voucher_redeemed - $previous_voucher_redeemed) / $previous_voucher_redeemed) * 100;
        }
        $current_year_voucher_issued = VoucherCode::where('created_at', 'like', date('Y') . '%')->count();
        $previous_year_voucher_issued = VoucherCode::where('created_at', 'like', date('Y', strtotime('-1 year')) . '%')->count();
        $percentage_change_voucher_issued = 0;
        if ($previous_year_voucher_issued > 0) {
            $percentage_change_voucher_issued = (($current_year_voucher_issued - $previous_year_voucher_issued) / $previous_year_voucher_issued) * 100;
        } elseif ($current_year_voucher_issued > 0) {
            $percentage_change_voucher_issued = 100; // 100% increase if previous year was 0
        }
        // If both are 0, percentage_change_voucher_issued remains 0

        $data = compact(
            'active_beneficiaries',
            'current_month_assistance_received',
            'previous_month_assistance_received',
            'percentage_change',
            'current_voucher_redeemed',
            'previous_voucher_redeemed',
            'percentage_change_voucher',
            'assistance_provided_current_year',
            'assistance_provided_previous_year',
            'percentage_change_year',
            'current_year_voucher_issued',
            'previous_year_voucher_issued',
            'percentage_change_voucher_issued'
        );
        return view('dashboard', $data);
    }
}
