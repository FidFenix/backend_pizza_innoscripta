<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\User;

use Response;

class InvoiceController extends Controller
{
    public static $model = Invoice::class;

    public function createInvoice(Request $request) 
    {
        try{

            $user_id = $this->getUserIdFromToken($request);

            $data = json_decode($request->getContent(), true);
            $userinfo = $data["userinfo"];
            $user = $data["user"];
            $invoice = new Invoice;
            $invoice->client_ip = $userinfo["client_ip"];
            $invoice->email = $userinfo["email"];
            $invoice->type = $userinfo["type"];
            $invoice->address_city = $userinfo["card"]["address_city"];
            $invoice->address_country = $userinfo["card"]["address_country"];
            $invoice->address_line1 = $userinfo["card"]["address_line1"];
            $invoice->address_zip = $userinfo["card"]["address_zip"];
            $invoice->brand = $userinfo["card"]["brand"];
            $invoice->country = $userinfo["card"]["country"];
            $invoice->name = $userinfo["card"]["name"];
            $invoice->last4 = $userinfo["card"]["last4"];
            $invoice->total = $data["price"];
            $invoice->user_id = $user_id;

            $invoice = $invoice->toArray();
            
            $newInvoice = Invoice::create($invoice);
            
            //Now creating the items to store as details
            $items = $data["items"];
            foreach ($items as $item) {
                $newInvoiceDetail = new InvoiceDetails;
                $newInvoiceDetail->id = $item["id"];
                $newInvoiceDetail->quantity = $item["quantity"];
                $newInvoiceDetail->price = $item["price"];
                $newInvoiceDetail->imageUrl = $item["imageUrl"];
                $newInvoiceDetail->name = $item["name"];
                $newInvoiceDetail->invoice_id = $newInvoice->invoice_id;
                $newInvoiceDetail = $newInvoiceDetail->toArray();
                InvoiceDetails::create($newInvoiceDetail);
            }
            
            return Response::json(['message' => 'Successful Payment'], 200);

        } catch(Exception $e) {
            return Response::json(['message' => 'Please fill all the Form'], 400);
        }

    }

    public function getBuys(Request $request) {

        $user_id = $this->getUserIdFromToken($request);
        $data = Invoice::where("user_id", "=", $user_id)->get(['invoice_id', 'email', 'address_city','address_line1', 'last4','total','name','address_zip', 'created_at']);
        return Response::json(['response' => $data], 200);
    }

    public function getUserIdFromToken($request) {
        $authHeader = $request->header('Authorization');
        $token = trim(substr($authHeader, 6));
        if (Cache::has($token)) {
            $user_id = Cache::get($token);
            return $user_id;
        }else {
            return Response::json(['message' => 'Security Problems'], 500);
        }
    }
}
