<?php

namespace App\Http\Controllers;

use App\Models\CoinDistribution;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\DB;
class SettingController extends Controller
{
    //
    public function index(Request $request)
    {
        $settings = PaymentSetting::find(1);

        $coinDistributions = CoinDistribution::where('status', 'completed')
        ->sum(DB::raw('CAST(amount AS DECIMAL(18,8))'));
        return view('admin.settings',compact('settings','coinDistributions'));
    }

    public function savePaymentSetting(Request $request){
        $validatedData = $request->validate([
            'total_yearly_tokens' => 'required|numeric|regex:/^\d{1,24}(\.\d{1,8})?$/',
            'dev_account_percentage' => 'required|numeric|between:0,100',
            'business_account_percentage' => 'required|numeric|between:0,100',
            'reward_submission_percentage' => 'required|numeric|between:0,100',
            'reward_code_review_percentage' => 'required|numeric|between:0,100',
            'first_place_percentage' => 'required|numeric|between:0,100',
            'second_place_percentage' => 'required|numeric|between:0,100',
            'third_place_percentage' => 'required|numeric|between:0,100',
            'payout_frequency' => 'required|integer|min:1',
        ]);

        PaymentSetting::updateOrCreate(
            ['id' => 1], // Assuming you have a single settings row (change if needed)
            [
                'total_yearly_tokens' => $request->total_yearly_tokens,
                'dev_account_percentage' => $request->dev_account_percentage,
                'business_account_percentage' => $request->business_account_percentage,
                'reward_submission_percentage' => $request->reward_submission_percentage,
                'reward_code_review_percentage' => $request->reward_code_review_percentage,
                'first_place_percentage' => $request->first_place_percentage,
                'second_place_percentage' => $request->second_place_percentage,
                'third_place_percentage' => $request->third_place_percentage,
                'payout_frequency' => $request->payout_frequency,
            ]
        );

        return response()->json(['status'=>200,'message'=>'Payment Setting add successfully']);
    }
}
