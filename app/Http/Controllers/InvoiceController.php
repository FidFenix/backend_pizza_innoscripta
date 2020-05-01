<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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
            $data = json_decode($request->getContent(), true);
            $userinfo = $data["userinfo"];
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
            
            $newInvoice = Invoice::create($invoice->toArray());
            
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
                InvoiceDetails::create($newInvoiceDetail->toArray());
            }
            
            return Response::json(['success' => 'Successful Payment'], 200);

        } catch(Exception $e) {
            return Response::json(['errors' => 'Please fill all the Form'], 400);
        }

    }
}
