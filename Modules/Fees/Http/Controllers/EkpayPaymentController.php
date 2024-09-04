<?php

namespace Modules\Fees\Http\Controllers;

use App\User;
use App\SmSchool;
use App\SmAddIncome;
use App\SmBankAccount;


use App\SmBankStatement;
use App\SmPaymentMethhod;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Fees\Entities\FmFeesInvoice;
use Illuminate\Contracts\Support\Renderable;
use Modules\Fees\Entities\FmFeesTransaction;
use Modules\Fees\Entities\FmFeesInvoiceChield;
use Modules\Wallet\Entities\WalletTransaction;
use Modules\Fees\Entities\FmFeesTransactionChield;


class EkpayPaymentController extends Controller
{
    public function ekPay($transiction_no, $paymentData)
    {
        // return $paymentData;
        $amount = $paymentData['amount'];

        $date = date('Y-m-d H:i:s');
        $BackUrl = url('');
        $paymentUrl = 'https://sandbox.ekpay.gov.bd/ekpaypg/';
        $userName = 'bbs_test';
        $password = 'BbstaT@tsT12';
        $mac_addr = '1.1.1.1';
        $responseUrlSuccess = $BackUrl . '/ek-payment-success';
        $ipnUrlTrxinfo = $BackUrl . '/response-ekpay-ipn-tax';
        $responseUrlCancel = $BackUrl . '/ek-payment-cancel';
        // return $responseUrlSuccess;


        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $paymentUrl . 'v1/merchant-api',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "mer_info":
            {
                "mer_reg_id":"' . $userName . '",
                "mer_pas_key":"' . $password . '"
            },
            "req_timestamp":"' . $date . ' GMT+6",
            "feed_uri":
                {
                    "s_uri":"' . $responseUrlSuccess . '",
                    "f_uri":"' . $responseUrlCancel . '",
                    "c_uri":"' . $responseUrlCancel . '"
                },
                "cust_info":
                {
                    "cust_id":"' . $paymentData['transcationId'] . '",
                    "cust_name":"' . $paymentData['student_name'] . '",
                    "cust_mobo_no":"+88' . $paymentData['student_mobile'] . '",
                    "cust_mail_addr":"' . $paymentData['student_email'] . '"

                },
                "trns_info":
                {
                    "trnx_id":"' . $transiction_no . '",
                    "trnx_amt":"' . $amount . '",
                    "trnx_currency":"BDT",
                    "ord_id":"' . $transiction_no . '",
                    "ord_det":"license fee"

                },
                "ipn_info":
                {
                    "ipn_channel":"0",
                    "ipn_email":"mafizur.mysoftheaven@gmail.com",
                    "ipn_uri":"' . $ipnUrlTrxinfo . '"

                },
                "mac_addr":"' . $mac_addr . '"

        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $info = json_decode($response);
        // return $info;

        $data = [
            'payment_amount' => $amount,
            'ekpay_transiction_no' => $transiction_no,
            'fees_transcation_id' => $paymentData['transcationId'],
            'payment_user_name' => $paymentData['student_name'],
            'payment_user_phone' => $paymentData['student_mobile'],
            'payment_user_email' => $paymentData['student_email'],
            'payment_date' => $date,
            'status' => 0, // status 0=unpaid, 1=paid 2=Cancel
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // return $data;

        DB::table('ekpay_payment_history')->updateOrInsert($data);
        // dd($response);
        return $info->secure_token;
    }


    public function ekPaySuccess(Request $request)
    {
        //  dd(1);
        // return "llslsjdlfj";
        // return redirect()->url('fees/student-fees-list')->with('message', 'Payment Successfull');
        // return $request->transId;
        $transiction_no = $request->transId;


        // $alljson = json_encode($request->all());
        $date = date('Y-m-d');
        $userName = 'bbs-test';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.ekpay.gov.bd/ekpaypg/v1/get-status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "username":"' . $userName . '",
            "trnx_id": "' . $request->transId . '",
            "trans_date": "' . $date . '"
        }',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response);
        $transcation_id = $res->cust_info->cust_id;
        $this->addStudentFeesAmount($transcation_id);

        DB::table('ekpay_payment_history')->where('ekpay_transiction_no', $transiction_no)->update([
            'payment_details' => $response,
            'status' => 1, // status 0=unpaid, 1=paid 2=Cancel
            'updated_at' => now()
        ]);
      
        Toastr::success('Payment Successfull', 'Success');
        sendNotification("Payment Successfull", null, Auth::user()->id, 2);
        return redirect()->route('fees.student-fees-list');
    }

    public function addStudentFeesAmount($transcation_id)
    {
        $transcation = FmFeesTransaction::find($transcation_id);
        $fees_invoice = FmFeesInvoice::find($transcation->fees_invoice_id);
        $allTranscations = FmFeesTransactionChield::where('fees_transaction_id', $transcation->id)->get();

        foreach ($allTranscations as $key => $allTranscation) {
            $transcationId = FmFeesTransaction::find($allTranscation->fees_transaction_id);
            $fesInvoiceId = FmFeesInvoiceChield::where('fees_invoice_id', $transcationId->fees_invoice_id)
                ->where('fees_type', $allTranscation->fees_type)
                ->first();

            $storeFeesInvoiceChield = FmFeesInvoiceChield::find($fesInvoiceId->id);
            $storeFeesInvoiceChield->due_amount = $storeFeesInvoiceChield->due_amount - $allTranscation->paid_amount;
            $storeFeesInvoiceChield->paid_amount = $storeFeesInvoiceChield->paid_amount + $allTranscation->paid_amount;
            $storeFeesInvoiceChield->service_charge = chargeAmount($transcation->payment_method, $allTranscation->paid_amount);
            $storeFeesInvoiceChield->update();

            // Income
            $payment_method = SmPaymentMethhod::where('method', $transcation->payment_method)->first();
            $income_head = generalSetting();

            $add_income = new SmAddIncome();
            $add_income->name = 'Fees Collect';
            $add_income->date = date('Y-m-d');
            $add_income->amount = $allTranscation->paid_amount;
            $add_income->fees_collection_id = $transcation->fees_invoice_id;
            $add_income->active_status = 1;
            $add_income->income_head_id = $income_head->income_head_id;
            $add_income->payment_method_id = $payment_method->id;
            if ($payment_method->id == 3) {
                $add_income->account_id = $transcation->bank_id;
            }
            $add_income->created_by = Auth()->user()->id;
            $add_income->school_id = Auth::user()->school_id;
            $add_income->academic_id = getAcademicId();
            $add_income->save();

            // if ($transcation->payment_method == "Bank") {
            //     $bank = SmBankAccount::where('id', $transcation->bank_id)
            //         ->where('school_id', Auth::user()->school_id)
            //         ->first();

            //     $after_balance = $bank->current_balance + $total_paid_amount;

            //     $bank_statement = new SmBankStatement();
            //     $bank_statement->amount = $allTranscation->paid_amount;
            //     $bank_statement->after_balance = $after_balance;
            //     $bank_statement->type = 1;
            //     $bank_statement->details = "Fees Payment";
            //     $bank_statement->payment_date = date('Y-m-d');
            //     $bank_statement->item_sell_id = $transcation->id;
            //     $bank_statement->bank_id = $transcation->bank_id;
            //     $bank_statement->school_id = Auth::user()->school_id;
            //     $bank_statement->payment_method = $payment_method->id;
            //     $bank_statement->save();

            //     $current_balance = SmBankAccount::find($transcation->bank_id);
            //     $current_balance->current_balance = $after_balance;
            //     $current_balance->update();
            // }
            $fees_transcation = FmFeesTransaction::find($transcation->id);
            $fees_transcation->paid_status = 'approve';
            $fees_transcation->update();

            // return $fees_transcation;
           
        }

       

        if($fees_invoice){
            $balance = ($fees_invoice->Tamount + $fees_invoice->Tfine) - ($fees_invoice->Tpaidamount + $fees_invoice->Tweaver);
            if($balance == 0){
                $fees_invoice->payment_status = "paid"; 
                $fees_invoice->update();
                Cache::forget('have_due_fees_'.$transcation->user_id);
            }else{
                $fees_invoice->payment_status = "partial"; 
                $fees_invoice->update();
            }
        }
      
        if ($transcation->add_wallet_money > 0) {
            $user = User::find($transcation->user_id);
            $walletBalance = $user->wallet_balance;
            $user->wallet_balance = $walletBalance + $transcation->add_wallet_money;
            $user->update();

            $addPayment = new WalletTransaction();
            $addPayment->amount = $transcation->add_wallet_money;
            $addPayment->payment_method = $transcation->payment_method;
            $addPayment->user_id = $user->id;
            $addPayment->type = 'diposit';
            $addPayment->status = 'approve';
            $addPayment->note = 'Fees Extra Payment Add';
            $addPayment->school_id = Auth::user()->school_id;
            $addPayment->academic_id = getAcademicId();
            $addPayment->save();

           

            $school = SmSchool::find($user->school_id);
            $compact['full_name'] = $user->full_name;
            $compact['method'] = $transcation->payment_method;
            $compact['create_date'] = date('Y-m-d');
            $compact['school_name'] = $school->school_name;
            $compact['current_balance'] = $user->wallet_balance;
            $compact['add_balance'] = $transcation->add_wallet_money;
            $compact['previous_balance'] = $user->wallet_balance - $transcation->add_wallet_money;

            @send_mail($user->email, $user->full_name, "fees_extra_amount_add", $compact);

            sendNotification($user->id, null, null, $user->role_id, "Fees Xtra Amount Add");
        }
    }

    public function ekPayCancel(Request $request)
    {

        // return $request->all();
        $transiction_no = $request->transId;
        $date = date('Y-m-d');
        $userName = 'bbs-test';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.ekpay.gov.bd/ekpaypg/v1/get-status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "username":"' . $userName . '",
            "trnx_id": "' . $request->transId . '",
            "trans_date": "' . $date . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // $res = json_decode($response);

        // return $res;

        DB::table('ekpay_payment_history')->where('ekpay_transiction_no', $transiction_no)->update([
            'payment_details' => $response,
            'status' => 2, // status 0=unpaid, 1=paid 2=Cancel
            'updated_at' => now()
        ]);

        Toastr::error('Payment Cancelled', 'Failed');
        return redirect()->route('fees.student-fees-list');
    }


    public function paymentStatus($application_id, $stauts)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('APP_workflow') . 'api/v2/payment-status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'application_id' => $application_id,
                'stauts' => $stauts
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return;
    }
}
