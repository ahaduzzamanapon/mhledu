<?php

namespace Modules\Fees\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class EkpayPaymentController extends Controller
{
    public function ekPay($transiction_no, $paymentData)
    {
        $amount = $paymentData['amount'];

        $date = date('Y-m-d H:i:s');
        $BackUrl = url('');
        $paymentUrl = 'https://sandbox.ekpay.gov.bd/ekpaypg/';
        $userName = 'bbs_test';
        $password = 'BbstaT@tsT12';
        $mac_addr = '1.1.1.1';
        $responseUrlSuccess = $BackUrl . '/ek-payment-success';
        // return $responseUrlSuccess;
        $ipnUrlTrxinfo = $BackUrl . '/response-ekpay-ipn-tax';
        $responseUrlCancel = $BackUrl . '/ek-payment-cancel';


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
                    "cust_id":"' . $paymentData['invoice_id'] . '",
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

        // $data = [
        //     'tracking_no' => $paymentData['tracking_no'],
        //     'application_id' => $paymentData['application_id'],
        //     'amount' => $amount,
        //     'transiction_no' => $transiction_no,
        //     'applicant_name' => $paymentData['name'],
        //     'applicant_phone' => $paymentData['phone'],
        //     'applicant_email' => $paymentData['email'],
        //     'payment_date' => $date,
        //     'payment_processed_date' => $date,
        //     'status' => 0, // status 0=unpaid, 1=paid 2=Cancel
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ];

        // return $data;

        // DB::table('citizen_payments')->updateOrInsert($data);
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
        // return $res->trnx_info->trnx_amt;
        $invoice_id = $res->cust_info->cust_id;
        $dueAmount = DB::table('fm_fees_invoice_chields')->where('fees_invoice_id', $invoice_id)->first();
        // return $dueAmount->due_amount;
        $paidAmount = $res->trnx_info->trnx_amt;

        $updateAmount = $dueAmount->due_amount - $paidAmount;
        DB::table('fm_fees_invoice_chields')->where('fees_invoice_id', $invoice_id)->update([
            'due_amount' => $updateAmount
        ]);
        // $redirect_url = url('fees/student-fees-list', $student_id);

        // DB::table('citizen_payments')->where('transiction_no', $transiction_no)->update([
        //     'payment_details' => $response,
        //     'status' => 1, // status 0=unpaid, 1=paid 2=Cancel
        //     'updated_at' => now()
        // ]);

        // $application_id = DB::table('citizen_payments')->where('transiction_no', $transiction_no)->first()->application_id;

        // $this->paymentStatus($application_id, 1);

        // DB::table('companyinfo')->where('application_id', $application_id)->update([
        //     'payment_status' => 1,
        // ]);

        // return redirect()->url('fees/student-fees-list', $student_id)->with('message', 'Payment Successfull');
        return redirect()->route('fees.student-fees-list')->with('message', 'Payment Successfull');
    }

    public function ekPayCancel(Request $request)
    {

        return $request->all();
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

        DB::table('citizen_payments')->where('transiction_no', $transiction_no)->update([
            'payment_details' => $response,
            'status' => 2, // status 0=unpaid, 1=paid 2=Cancel
            'updated_at' => now()
        ]);

        $application_id = DB::table('citizen_payments')->where('transiction_no', $transiction_no)->first()->application_id;

        $this->paymentStatus($application_id, 0);

        DB::table('companyinfo')->where('application_id', $application_id)->update([
            'payment_status' => 0,
        ]);


        return redirect()->route('home')->with('message', 'Payment Cancelled');
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
