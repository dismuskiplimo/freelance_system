<?php

namespace App\Http\Controllers;

define('FILE_PATH', base_path() . '/public_html/files/');

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use App\Mail\OrderCreated;

use App\Mail\NewOrderCreated;

use Carbon\Carbon;

use App\Http\Requests;

use App\Academic_level;

use App\Format;

use App\Notification;

use App\WithdrawalRequest;

use App\Assignment;

use App\Bid;

use App\Conversation;

use App\Message;

use App\Message_notification;

use App\Rating;

use App\Discipline;

use App\Sub_discipline;

use App\Assignment_type;

use App\User;

use App\Download;

use App\Comment;

use App\Country;

use App\Settings;

use App\Transaction;

use App\PayPal_Transaction;

use App\Portofolio;

use App\MyAssignmentTypes;

use App\MyDisciplines;

use App\MyLanguage;

use Auth;

use Hash;

use Mail;

use Session;

use \PayPal\Rest\ApiContext;

use \PayPal\Auth\OAuthTokenCredential;

use \PayPal\Api\Payer;

use \PayPal\Api\Item;

use \PayPal\Api\ItemList;

use \PayPal\Api\Details;

use \PayPal\Api\Amount;

use \PayPal\Api\Transaction as PaypalTransaction;

use \PayPal\Api\RedirectUrls;

use \PayPal\Api\Payment as PaypalPayment;

use \PayPal\Api\PaymentExecution;

use \PayPal\Service\AdaptiveAccountsService;

use \PayPal\Types\AA\AccountIdentifierType;

use \PayPal\Types\AA\GetVerifiedStatusRequest;

class ClientController extends Controller
{
    
    protected $date_today,
              $_date,
              $_paypal_client_id,
              $_paypal_secret,
              $_paypal_currency,
              $_paypal_mode,
              $_paypal_config,
              $_app_name;
    
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('client');
        $this->middleware('not_admin');
        $this->middleware('account_not_blocked');
        $this->middleware('account_active');
        $this->date_today = date('Y-m-d');
        $this->_date = Carbon::now();

        $mode = env('PAYPAL_MODE');

        $this->_app_name = env('SITE_NAME');
        
        $this->_paypal_currency = env('PAYPAL_CURRENCY');

        if($mode == 'sandbox'){
            $this->_paypal_client_id = env('PAYPAL_CLIENT_ID_SANDBOX');
            $this->_paypal_secret = env('PAYPAL_SECRET_SANDBOX');
            $this->_paypal_mode = 'sandbox';
        }elseif($mode == 'live'){
            $this->_paypal_client_id = env('PAYPAL_CLIENT_ID_LIVE');
            $this->_paypal_secret = env('PAYPAL_SECRET_LIVE');
            $this->_paypal_mode = 'live';
        }else{
            $this->_paypal_mode = 'test';
        }

        $this->_paypal_config = [
            'mode' => $this->_paypal_mode,
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => '../PayPal.log',
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $date = date('Y-m-d');
        $orders = Assignment::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        $orders_auction = Assignment::where('user_id', Auth::user()->id)->where('status','AUCTION')->where('deadline','>=',$date)->orderBy('created_at', 'DESC')->take(5)->get();
        $orders_active = Assignment::where('user_id', Auth::user()->id)->where('status','PROGRESS')->orderBy('created_at', 'DESC')->take(5)->get();
        $days_guranteed = Settings::where('name','mature_duration')->first();
        if(!$days_guranteed){
            Session::flash('error', 'Cannot load page, invalid settings');
            return redirect()->back();
        }

        return view('pages.client.dashboard',[
            'orders' => $orders,
            'orders_auction' => $orders_auction,
            'orders_active' => $orders_active,
            'days_guranteed' => $days_guranteed->value,
        ]);
    }

    public function getClientOrders(){
        $date = new Carbon();
        $orders_auction = Assignment::where('user_id', Auth::user()->id)->where('status','AUCTION')->where('deadline','>=', $date->toDateTimeString())->orderBy('created_at', 'DESC')->get();
        $orders_active = Assignment::where('user_id', Auth::user()->id)->where('status','PROGRESS')->orderBy('created_at', 'DESC')->get();
        $orders_complete = Assignment::where('user_id', Auth::user()->id)->where('status','COMPLETE')->orderBy('created_at', 'DESC')->get();
        $orders_expired = Assignment::where('user_id', Auth::user()->id)->where('status','AUCTION')->where('deadline','<', $date->toDateTimeString())->orderBy('created_at', 'DESC')->get();
        
        return view('pages.client.my-orders',[
            'orders_auction' => $orders_auction,
            'orders_active' => $orders_active,
            'orders_complete' => $orders_complete,
            'orders_expired' => $orders_expired,
        ]);
    }

    public function getMyClientRatings(){
        return view('pages.client.ratings');
    }

    public function getCreateOrder(){
        $academic_levels = Academic_level::get();
        $formats = Format::get();
        $disciplines = Discipline::get();
        $assignment_types = Assignment_type::get();
        $commission = Settings::where('name', 'commission_percent')->first();

        return view('pages.client.create-order',[
            'academic_levels' => $academic_levels,
            'formats' => $formats,
            'disciplines' => $disciplines,
            'assignment_types' => $assignment_types,
            'commission' => $commission->value, 
        ]);
    }

    public function postUpdatePaypal(Request $request){
        $this->validate($request,[
            'paypal_email' => 'required|email',
            'fName' => 'required',
            'lName' => 'required',
        ]);

        $user = User::find(Auth::user()->id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }
        $user->paypal_email = $request->paypal_email;
        $user->update();

        Session::flash('success', 'Paypal email updated');

        return redirect()->back();

        /*
        $getVerifiedStatus = new GetVerifiedStatusRequest();
        
        // (Optional - must be present if the emailAddress field above
        // is not) The identifier of the PayPal account holder. If
        // present, must be one (and only one) of these account
        // identifier types: 1. emailAddress 2. mobilePhoneNumber 3.
        // accountId
        
        $accountIdentifier=new AccountIdentifierType();
        
        // (Required)Email address associated with the PayPal account:
        // one of the unique identifiers of the account.
        $accountIdentifier->emailAddress = $request->paypal_email;
        $getVerifiedStatus->accountIdentifier=$accountIdentifier;
        
        // (Required) The first name of the PayPal account holder.
        // Required if matchCriteria is NAME. 
        $getVerifiedStatus->firstName = $request->firstName;
                         
        // (Required) The last name of the PayPal account holder.
        // Required if matchCriteria is NAME.
        $getVerifiedStatus->lastName = $request->lastName;
        $getVerifiedStatus->matchCriteria = 'NAME';
        
        // ## Creating service wrapper object
        // Creating service wrapper object to make API call
        //Configuration::getAcctAndConfig() returns array that contains credential and config parameters
        
        $service  = new AdaptiveAccountsService(Configuration::getAcctAndConfig());
        
        try {
            
            // ## Making API call
            // invoke the appropriate method corresponding to API in service
            // wrapper object
            $response = $service->GetVerifiedStatus($getVerifiedStatus);
        } catch(Exception $e) {
            dd($e);
        } 
        
        // ## Accessing response parameters
        // You can access the response parameters as shown below
        $ack = strtoupper($response->responseEnvelope->ack);
        if($ack != "SUCCESS"){
            echo "<b>Error </b>";
            echo "<pre>";
            print_r($response);
            echo "</pre>";      
        } else {
            echo "<pre>";
            print_r($response);
            echo "</pre>";
            echo "<table>";
            echo "<tr><td>Ack :</td><td><div id='Ack'>$ack</div> </td></tr>";
            echo "</table>";        
        }

        */
    }

     public function postCreateOrder(Request $request){
        $this->validate($request,[
            'title' => 'required|min:5|max:255',
            'assignment_type_id' => 'numeric|required',
            'sub_discipline_id' => 'numeric|required',
            'pages' => 'required|numeric|min:1',
            'deadline' => 'required|date|after:today',
            'price' => 'numeric|min:5',
            'type_of_service' => 'required',
            'academic_level_id'=> 'required|numeric',
            'format_id' => 'required|numeric',
            
        ]);

        $user = User::find(Auth::user()->id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        $file_upload = false;

        if($request->hasFile('attachment') && $request->file('attachment')->isValid()){
            $this->validate($request,[
                'attachment'=>'mimes:docx,doc,pdf,jpg,jpeg,png|max:51200',
                'message' => 'max:500',
            ]);

            $attachment = $request->file('attachment');
            
            $extension = $attachment->getClientOriginalExtension(); 
            $name = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);

            $fileName = Str::slug($name) . '-' . mt_rand(1,200).'.'.$extension;

            $file_upload = true;
        }

        if(empty($request->price)){
            $request->price = null;
        }

        $assignment = new Assignment;

        $assignment->title = $request->title;
        $assignment->assignment_type_id = $request->assignment_type_id;
        $assignment->sub_discipline_id = $request->sub_discipline_id;
        $assignment->pages = $request->pages;
        $assignment->deadline = $request->deadline;
        $assignment->type_of_service = $request->type_of_service;
        $assignment->academic_level_id = $request->academic_level_id;
        $assignment->format_id = $request->format_id;
        $assignment->instructions = $request->instructions;
        $assignment->user_id = Auth::user()->id;

        $assignment->save();

        $assignment->price = round($assignment->pages * $assignment->assignment_type->price, 2);
        $assignment->update();

        if($file_upload){
            $attachment->move(FILE_PATH, $fileName);
            
            $download = new Download;
            $download->filename = $fileName;
            $download->type = $extension;
            $download->assignment_id = $assignment->id;
            $download->from_id = Auth::user()->id;
            $download->to_id = null;
            $download->save();
        }


        $support_email = Settings::where('name', 'notification_email')->first();
        if(!$support_email){
            Session::flash('error', 'Cannot load page, invalid settings');
            return redirect()->back();
        }
        $support_email = $support_email->value;

        try{
            $writers = User::where('user_type','WRITER')->get();
            $wr_array = [];
            foreach($writers as $writer){
                $tmp = [];
                $tmp['email'] = $writer->email;
                $tmp['name'] = $writer->name;
                $wr_array[] = (object)$tmp;
            }


            Mail::to(Auth::user()->email)->send(new OrderCreated($assignment,$user));
            //Mail::to(Auth::user()->email)->bcc($wr_array)->send(new OrderCreated($assignment,$user));
        }
        catch(\Exception $e){
            Session::flash('error','user notification email not sent ' . $e->getMessage());
        }

        try{
            Mail::to($support_email)->send(new NewOrderCreated($assignment));
        }catch(\Exception $e){
            Session::flash('error','support notification email not sent' . $e->getMessage());
        }

        Session::flash('success', 'Assignment Created');

        return redirect()->route('getClientOrders');

     }

     public function getOrder($id){
        $assignment = Assignment::find($id);

        if(!$assignment){
            Session::flash('error', 'Cannot load page, assignment not found');
            return redirect()->back();
        }

        $commission = Settings::where('name','commission_percent')->first();

        if(!$commission){
            Session::flash('error', 'Cannot load page, invalid settings');
            return redirect()->back();
        }

        if($assignment->user_id == Auth::user()->id){
            return view('pages.client.single-order',[
                'assignment'=> $assignment,
                'commission'=> $commission->value,
            ]);
        }
        
     }

     public function postEducation(Request $request){
        $this->validate($request,[
            'academic_level_id' => 'numeric',
            'school' => 'max:255',
            'field_of_specialization' => 'max:255',
        ]);

        $user = User::find(Auth::user()->id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        $user->academic_level_id = $request->academic_level_id;
        $user->school = $request->school;
        $user->field_of_specialization = $request->field_of_specialization;

        $user->update();

        Session::flash('success', 'Education details updated');

        return redirect()->back();


     }

     public function postClientContacts(Request $request){
        $this->validate($request,[
            'country_id' => 'numeric',
            'city' => 'max:255',
            'phone' => 'numeric',
        ]);

        $user = User::find(Auth::user()->id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        $user->country_id = $request->country_id;
        $user->city = $request->city;
        $user->phone = $request->phone;

        $user->update();

        Session::flash('success', 'Contact details updated');

        return redirect()->back();
    }

    public function postUpdatePassword(Request $request){
        $this->validate($request, [
            'old_password' => 'required|min:6|max:255',
            'new_password' => 'required|min:6|max:255|confirmed',
            'new_password_confirmation' => 'required|min:6|max:255',
        ]);

        $user = User::find(Auth::user()->id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        

        if(Hash::check($request->old_password ,Auth::user()->password)){

            $user->password = Hash::make($request->new_password);

            $user->update();

            Session::flash('success', 'Password updated successfully');

        }else{
            Session::flash('error', 'Your old password provided does not match the one in our database');
        }

        return redirect()->back();

    }



    public function getBalance(){
        $incoming_transactions = Transaction::where('to_id', Auth::user()->id)->where('type','INCOMING')->orderBy('created_at', 'DESC')->get();
        $outgoing_transactions = Transaction::where('from_id', Auth::user()->id)->where('type','OUTGOING')->orderBy('created_at', 'DESC')->get();

        return view('pages.client.balance',[
            'incoming_transactions' => $incoming_transactions,
            'outgoing_transactions' => $outgoing_transactions,
        ]);
    }

    public function getProfile(){
        $academic_levels = Academic_level::get();
        $countries = Country::get();

        return view('pages.client.profile', [
            'academic_levels' => $academic_levels,
            'countries' => $countries,
        ]);
    }   

    public function getNotification($id){
        $notification = Notification::find($id);

        if(!$notification){
            Session::flash('error', 'Cannot load page, notification not found');
            return redirect()->back();
        }

        $notification->read_status = 1;
        $notification->update();

        if($notification->to_id != Auth::user()->id){
            return redirect()->back();
        }

        if($notification->type == "bid_placed" || $notification->type == "bid_updated" || $notification->type == "bid_comment"){
            return redirect()->route('getSingleClientOrder',['id'=>$notification->refference_id]);
        }elseif($notification->type == "withdrawal_rejected" || $notification->type == "withdrawal_approved"){
            return redirect()->route('getClientBalance');
        }

    }

    public function getNotifications(){
        return view('pages.client.notifications');
    }

    public function getConversations(){
        $conversations = Conversation::where('from_id', Auth::user()->id)->orWhere('to_id', Auth::user()->id)->orderBy('updated_at','DESC')->get();

        $message_notifications = Message_notification::where('to_id', Auth::user()->id)->get();
        if(count($message_notifications)){
            foreach($message_notifications as $message_notification){
                $message_notification->read_status = 1;
                $message_notification->update();
            }
            
        }
        
        return view('pages.client.messages',[
            'conversations' => $conversations,
        ]);
    }

    public function getConversation($id){
        $conversation = Conversation::find($id);

        if(!$conversation){
            Session::flash('error', 'Cannot load page, conversation not found');
            return redirect()->back();
        }

        $recepient_id = $conversation->to_id == Auth::user()->id ? $conversation->from_id : $conversation->to_id;

        $recepient = User::find($recepient_id);

        if(!$recepient){
            Session::flash('error', 'Cannot load page, recepient not found');
            return redirect()->back();
        }

        $commission_percent = Settings::where('name','commission_percent')->first();
        if(!$commission_percent){
            Session::flash('error', 'Cannot load page, invalid settings');
            return redirect()->back();
        }

        $assignments = Assignment::where('user_id', Auth::user()->id)->where('deadline', '>=', $this->date_today)->where('status', 'AUCTION')->orderBy('created_at', 'DESC')->get();

        if($conversation->to_id == Auth::user()->id  || $conversation->from_id == Auth::user()->id){
            $messages = Message::where('conversation_id', $id)->orderBy('created_at','ASC')->get();
            
            if(count($messages)){
                foreach($messages as $message){
                    if($message->read_status == 0 && $message->to_id == Auth::user()->id){
                        $message->read_status = 1;
                        $message->update();
                    }
                }
            }
        
            return view('pages.client.conversation',[
                'messages' => $messages,
                'conversation' => $conversation,
                'recepient' =>  $recepient,
                'assignments' =>  $assignments,
                'commission' =>  $commission_percent->value,
            ]);
        }

        abort(403, 'Unauthorised action');

    }

    public function postMessage($id, Request $request){
        $attachment = '';
        
        if($request->hasFile('attachment') && $request->file('attachment')->isValid()){
            $this->validate($request,[
                'attachment'=>'mimes:docx,doc,pdf,jpg,jpeg,png|max:51200',
                'message' => 'max:500',
            ]);

            $attachment = $request->file('attachment');
            
            $extension = $attachment->getClientOriginalExtension(); 
            $name = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);

            $fileName = Str::slug($name) . '-' . mt_rand(1,200).'.'.$extension;

            $attachment->move(FILE_PATH, $fileName);

            
            $download = new Download;
            $download->filename = $fileName;
            $download->type = $extension;
            $download->assignment_id = null;
            $download->from_id = Auth::user()->id;
            $download->to_id = $id;
            $download->save();

            $attachment ='<p><strong class = "text-warning"><a href = "'. route('getDownload',['id'=>$download->id]) .'">'  . $name . '.' . $extension .  '</strong></a></p>';

        }else{
            $this->validate($request,[
                'message' => 'required|max:500',
            ]);
        }

        $wrt = User::where('id',$id)->where('active','1')->first();
        
        if(!$wrt){
            Session::flash('error','Message not sent because the writers account is inactive');
            return redirect()->back();
        }

       
        $from_id = Auth::user()->id;
        $to_id = $id;

        $sender = Conversation::where('from_id', $from_id)->where('to_id', $to_id)->first();

        $recepient = Conversation::where('from_id', $to_id)->where('to_id', $from_id)->first();

        if($sender){
            $conversation_id = $sender->id;
            $sender->update();
        }elseif($recepient){
            $conversation_id = $recepient->id;
            $recepient->update();
        }else{
            $conversation = new Conversation;
            $conversation->from_id = $from_id;
            $conversation->to_id = $to_id;
            $conversation->save();

            $conversation_id = $conversation->id;
        }
        if(messageIsClean($request->message)){
            $message = new Message;

            $message->from_id = $from_id;
            $message->to_id = $to_id;
            $message->message = $attachment . $request->message;
            $message->conversation_id = $conversation_id;

            $message->save();

            $message_notification = new Message_notification;
            $message_notification->to_id = $to_id;
            $message_notification->save();


            if($request->ajax()){
                return response()->json(['code' => 200]);
            }

            Session::flash('success','Message sent');
        }else{
            $user = User::find(Auth::user()->id);

            if(!$user){
                Session::flash('error', 'Cannot load page, user not found');
                return redirect()->back();
            }

            if($user->attempts_left <= 1){
                $user->attempts_left = 0;
                $user->active = 0;
                Session::flash('error','Message not sent because you tried to send contact details, your account is now blocked, contact support to get your account reactivated');
            }else{
                $user->attempts_left = $user->attempts_left - 1;
                Session::flash('error','Message not sent because you tried to send contact details, you have (' . $user->attempts_left . ') warnings left before your account is blocked');
            }

            $user->update();
        }

        return redirect()->route('getClientConversation', ['id'=>$conversation_id]);
    }

    public function postHireWriter($writer_id,Request $request){
        $this->validate($request,[
            'assignment_id' => 'required|numeric',
        ]);

        $now = new Carbon();

        $mature_duration = Settings::where('name','mature_duration')->first();
        
        $commission_percent = Settings::where('name','commission_percent')->first();

        if(!$commission_percent){
            Session::flash('error', 'Cannot load page, invalid settings');
            return redirect()->back();
        }

        $account_balance = Settings::where('name','account_balance')->first();

        if(!$account_balance){
            Session::flash('error', 'Cannot load page, invalid settings');
            return redirect()->back();
        }

        if(!$mature_duration || !$commission_percent || !$account_balance){
            Session::flash('error', 'Cannot load page, invalid settings');
            return redirect()->back();
        }

        $mature_duration = (float)$mature_duration->value;

        $user = User::find(Auth()->user()->id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        $writer = User::where('id',$writer_id)->where('active','1')->first();
        
        if(!$writer){
            Session::flash('error', 'Cannot hire the writer because the writer\'s account is inactive');
            return redirect()->back();
        }

        $assignment = Assignment::find($request->assignment_id);

        if(!$assignment){
            Session::flash('error', 'Cannot load page, assignment not found');
            return redirect()->back();
        }

        if($assignment->user_id != $user->id){
            abort(403, 'Unauthorised access');
        }

        if($assignment->price == null || $assignment->price == 0 || $request->has('amount')){
            $this->validate($request, [
                'amount' => 'required|min:4|numeric',
            ]); 

            $assignment->price = $request->amount;
        }


        $commission = $commission_percent->value * 0.01 * $assignment->price;
        $commission = round($commission, 2);
        
        $total_price = (float)$assignment->price;

        $writer_commission = $commission;

        if($assignment->status == "AUCTION" && $assignment->deadline >= $this->_date){
            if($user->balance >= $total_price){

                $user->balance = $user->balance - $assignment->price;
                $user->update();

                $account_balance->value = $account_balance->value;
                $account_balance->update();

                $assignment->status = 'PROGRESS';
                $assignment->writer_id = $writer->id;
                $assignment->assigned_at = $now;
                $assignment->update();
                
                $transaction = new Transaction;
                $transaction->amount = $assignment->price;
                $transaction->type = 'OUTGOING';
                $transaction->status = 'COMPLETE';
                $transaction->to_id = $writer->id;
                $transaction->from_id = $user->id;
                $transaction->assignment_id = $assignment->id;
                $transaction->details = 'Payment for "' . $assignment->title . '" (#' . $assignment->id . ')';
                $transaction->matures_at = $now->addDays($mature_duration)->toDateTimeString();
                $transaction->save();

                

                $transaction = new Transaction;
                $transaction->amount = $commission;
                $transaction->type = 'OUTGOING';
                $transaction->status = 'COMPLETE';
                $transaction->to_id = null;
                $transaction->from_id = $writer->id;
                $transaction->assignment_id = $assignment->id;
                $transaction->details = $commission_percent->value . '% Writer Commission for assignment #' . $assignment->id;
                $transaction->matures_at = $now->toDateTimeString();
                $transaction->save();

                $transaction = new Transaction;
                $transaction->amount = $assignment->price - $commission;
                $transaction->type = 'INCOMING';
                $transaction->to_id = $writer->id;
                $transaction->from_id = $user->id;
                $transaction->assignment_id = $assignment->id;
                $transaction->details = 'Payment for "' . $assignment->title . '" (#' . $assignment->id . ')';
                $transaction->matures_at = $now->addDays($mature_duration)->toDateTimeString();
                $transaction->save();

                $transaction = new Transaction;
                $transaction->amount = $commission;
                $transaction->type = 'INCOMING';
                $transaction->to_id = null;
                $transaction->from_id = $writer->id;
                $transaction->assignment_id = $assignment->id;
                $transaction->details = $commission_percent->value . '% Writer Commission for assignment #' . $assignment->id;
                $transaction->matures_at = $now->toDateTimeString();
                $transaction->save();

                $notification = new Notification;
                $notification->from_id = $user->id;
                $notification->to_id = $writer->id;
                $notification->type = 'assignment_awarded';
                $notification->message = 'assigned you an assignment';
                $notification->refference_id = $assignment->id;
                $notification->save();

                $from_id = $user->id;
                $to_id = $writer_id;

                $sender = Conversation::where('from_id', $from_id)->where('to_id', $to_id)->first();
                $recepient = Conversation::where('from_id', $to_id)->where('to_id', $from_id)->first();

                if($sender){
                    $conversation_id = $sender->id;
                    $sender->update();
                }elseif($recepient){
                    $conversation_id = $recepient->id;
                    $recepient->update();
                }else{
                    $conversation = new Conversation;
                    $conversation->from_id = $from_id;
                    $conversation->to_id = $to_id;
                    $conversation->save();

                    $conversation_id = $conversation->id;
                }

                $message = new Message;

                $message->from_id = $from_id;
                $message->to_id = $to_id;
                $message->message = 'I have an assignment for you with the title "' . $assignment->title . '". You can find it under your notifications';
                $message->conversation_id = $conversation_id;

                $message->save();

                $message_notification = new Message_notification;
                $message_notification->to_id = $to_id;
                $message_notification->save();

                Session::flash('success', 'Assignment assigned to <strong>' . $writer->username . '</strong> successfully');

            }else{

                Session::flash('error', 'Please recharge your account with an extra <strong>$' . (round($total_price,2) - $user->balance) . '</strong> before proceeding to assign the job');
                return redirect()->route('getClientBalance');
            }
        }else{
            Session::flash('error', 'Assignment not assigned, it may be beyond specified deadline');
        }

        return redirect()->back();

    }

    public function getWriter($slug){
        $user = User::where('username', $slug)->where('user_type', 'WRITER')->where('active','1')->first();
        if(!$user){
            Session::flash('error', 'User not found');
            return redirect()->back();
        }

        $user->views = $user->views + 1;
        $user->update();

        $complete_assignments = Assignment::where('writer_id', $user->id)->where('status', 'COMPLETE')->get();
        $active_assignments = Assignment::where('writer_id', $user->id)->where('status', 'PROGRESS')->get();
        $assignments = Assignment::where('user_id', Auth::user()->id)->where('deadline', '>=', $this->date_today)->where('status', 'AUCTION')->orderBy('created_at', 'DESC')->get();
        $commission_percent = Settings::where('name','commission_percent')->first();

        if(!$commission_percent){
            Session::flash('error', 'Cannot load page, invalid settings');
            return redirect()->back();
        }

        $positive_reviews = Rating::where('reaction','POSITIVE')->where('writer_id', $user->id)->get();
        $negative_reviews = Rating::where('reaction','NEGATIVE')->where('writer_id', $user->id)->get();

        if(count($positive_reviews) == 0 && count($negative_reviews) == 0){
            $positive_percent = 50;
            $negative_percent = 50;
        }else{
            $total = count($positive_reviews) + count($negative_reviews);
            $positive_percent = (count($positive_reviews) / $total) * 100;
            $negative_percent = (count($positive_reviews) / $total) * 100;

            $positive_percent = round($positive_percent);
            $negative_percent = round($negative_percent);
        }

        $late = $user->orders_assigned()->whereRaw('assignments.completed_at > assignments.deadline')->where('status', 'COMPLETE')->get();
        $on_time = $user->orders_assigned()->whereRaw('assignments.completed_at <= assignments.deadline')->where('status', 'COMPLETE')->get();
        

        if(count($late) == 0 && count($on_time) == 0){
            $late_percent = 50;
            $on_time_percent = 50;
        }else{
            $total = count($late) + count($on_time);
            $late_percent = (count($late) / $total) * 100;
            $on_time_percent = (count($on_time) / $total) * 100;

            $late_percent = round($late_percent);
            $on_time_percent = round($on_time_percent);
        }

        if($count = count($user->ratings)){
            $stars = $user->ratings()->sum('stars');
            $stars = $stars / $count;
        }else{
            $stars = 0;
        }
        

        return view('pages.client.writer',[
            'user' => $user,
            'complete_assignments' => $complete_assignments,
            'active_assignments' => $active_assignments,
            'assignments' => $assignments,
            'commission' => $commission_percent->value,
            'stars' => $stars,

            'positive_reviews' => count($positive_reviews),
            'negative_reviews' => count($negative_reviews),
            'positive_percent' => $positive_percent,
            'negative_percent' => $negative_percent,

            'late'=> count($late),
            'on_time'=> count($on_time),
            'late_percent' => $late_percent,
            'on_time_percent' => $on_time_percent,
        ]);
    }

    public function getWriters(Request $request){
        $writers = User::where('user_type', 'WRITER')->where('active','1')->orderBy('orders_complete', 'DESC')->paginate(20);

        return view('pages.client.writers',[
            'writers' => $writers,
            'request' => $request,
        ]);
    }

    public function getSearchWriter(Request $request){
        $this->validate($request,[
            'username'=>'max:255',
        ]);

        $now = new Carbon();

        $query = User::query();

        if($request->has('username') && !empty($request->username)){
            $like_string = '%' . $request->username . '%';
            $query->where('username','LIKE',$like_string);
        }

        if($request->has('online')){
            $query->where('last_seen', '>=', $now->subSeconds(30)->toDateTimeString());
        }

        $writers = $query->where('user_type', 'WRITER')->where('active','1')->orderBy('views', 'DESC')->paginate(20);

        return view('pages.client.writers',[
            'writers' => $writers,
            'request' => $request,
        ]);        

    }

    public function postMarkComplete($id, Request $request){
        $assignment = Assignment::find($id);

        if(!$assignment){
            Session::flash('error', 'Cannot load page, assignment not found');
            return redirect()->back();
        }

        $user = Auth::user();
        $writer = User::find($assignment->writer_id);

        if(!$writer){
            Session::flash('error', 'Cannot load page, writer not found');
            return redirect()->back();
        }


        $now = new Carbon();

        if($assignment->status == "COMPLETE"){
            Session::flash('error', 'The assignment you are trying to mark down is already complete');
            return redirect()->back();
        }

        if($assignment->user_id != $user->id){
            abort(403);
        }

        $transaction = Transaction::where('from_id', $user->id)->where('to_id', $writer->id)->where('status', 'PENDING')->where('assignment_id', $id)->where('frozen', 0)->first();

        if(!$transaction){
            Session::flash('error', 'Cannot load page, initial transaction not found');
            return redirect()->back();
        }

        $transaction->status = 'COMPLETE';
        $transaction->transferred_at = $now;
        $transaction->update();

        $writer->balance = $writer->balance + $transaction->amount;
        $writer->orders_complete = $writer->orders_complete + 1;
        $writer->update();

        $assignment->status = 'COMPLETE';
        $assignment->completed_at = $now->toDateTimeString();
        $assignment->update();

        $notification = new Notification;
        $notification->from_id = $user->id;
        $notification->to_id = $writer->id;
        $notification->type = 'assignment_completed';
        $notification->message = 'marked your assignment as complete';
        $notification->refference_id = $assignment->id;
        $notification->save();

        Session::flash('success', 'Assignment marked as completed');

        return redirect()->route('getCreateReview', ['writer_id'=>$writer->id, 'assignment_id'=>$assignment->id]);
    }

    public function getWithdraw(){
        $threshold = Settings::where('name','minimum_threshold')->first();

        if(!$threshold){
            Session::flash('error', 'Cannot load page, invalid settings');
            return redirect()->back();
        }

        return view('pages.client.withdraw',[
            'threshold'=> $threshold->value,
        ]);
    }

    public function postWithdrawRequest(Request $request){
        $withdrawal_requests = WithdrawalRequest::where('user_id', Auth::user()->id)->where('status','PENDING')->get();

        if(count($withdrawal_requests)){
            Session::flash('error', 'You have an active withdrawal request, please wait for the request to be processed before withdrawing again');
            return redirect()->back();
        }

        $min_amount = Settings::where('name','minimum_threshold')->first();

        if(!$min_amount){
            Session::flash('error', 'Cannot load page, invalid settings');
            return redirect()->back();
        }

        $min_amount = $min_amount->value;

        $this->validate($request,[
            "amount" => "required|min:{$min_amount}|numeric",
        ]);

        $amount = (float)$request->amount;

        if($amount > Auth::user()->balance){
            Session::flash('error','Your dont have enough account balance to withdraw $' . number_format($amount,2));
        }else{
            $transaction = new Transaction;
            $transaction->amount = $amount;
            $transaction->type = "OUTGOING";
            $transaction->to_id = null;
            $transaction->from_id = Auth::user()->id;
            $transaction->assignment_id = null;
            $transaction->matures_at = null;
            $transaction->transferred_at = null;
            $transaction->details = "Withdrawal request";
            $transaction->save();

            $withdrawal_request = new WithdrawalRequest;
            $withdrawal_request->transaction_id = $transaction->id ;
            $withdrawal_request->user_id = Auth::user()->id;
            $withdrawal_request->amount = $amount;
            $withdrawal_request->status = 'PENDING';
            $withdrawal_request->approved_at = null;
            $withdrawal_request->save();

            Session::flash('success', 'Withdrawal request for $' . number_format($amount,2) . ' sent, please allow a few minutes for your transaction to be processed');
            

        }

        return redirect()->route('getClientBalance');
    }

    public function getReviews($slug){
        $user = User::where('username', $slug)->first();

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        return view('pages.client.reviews',[
            'user' => $user,
        ]);
    }

    public function getAssignments($slug){
        return view('pages.client.assignments');
    }
    
    public function postAddFunds(Request $request){
        $this->validate($request,[
            'amount' => 'numeric|required',
        ]);

        $amount_to_pay = (float)$request->amount;

        if($this->_paypal_mode == 'test'){
            $user = User::find(Auth::user()->id);

            if(!$user){
                Session::flash('error', 'Cannot load page, user not found');
                return redirect()->back();
            }

            $user->balance = $user->balance + $amount_to_pay;
            $user->update();

            Session::flash('success', '<strong>$' . number_format($amount_to_pay,2) . '</strong> has been credited to your account');

            return redirect()->back();
        }else{
            $credential = new OAuthTokenCredential($this->_paypal_client_id, $this->_paypal_secret);
            $paypal = new ApiContext($credential);
            
            $paypal->setConfig($this->_paypal_config);

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $item = new Item();
            $item->setName('Deposit funds to your ' . $this->_app_name . ' account')
                 ->setCurrency($this->_paypal_currency)
                 ->setQuantity(1)
                 ->setPrice($amount_to_pay);

            $itemList = new ItemList();
            $itemList->setItems([$item]);

            $details = new Details();
            $details->setSubTotal($amount_to_pay);

            $amount = new Amount();
            $amount->setCurrency($this->_paypal_currency)
                   ->setTotal($amount_to_pay)
                   ->setDetails($details);

            $transaction = new PaypalTransaction();
            $transaction->setAmount($amount)
                        ->setItemList($itemList)
                        ->setDescription('Deposit funds to your ' . $this->_app_name . 'Account' )
                        ->setInvoiceNumber(time());           

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(url(route('getClientVerifyPayment',['success'=>'true', 'amount' => $amount_to_pay])))
                         ->setCancelUrl(url(route('getClientVerifyPayment',['success'=>'true'])));

            $payment = new PaypalPayment();
            $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirectUrls)
                    ->setTransactions([$transaction]);


            try{
                $payment->create($paypal);
            }catch(Exception $e){
                die($e);
            }

            $approvalUrl = $payment->getApprovalLink();

            return redirect($approvalUrl);
        }

    }

    public function getVerifyPayment(Request $request){
        $credential = new OAuthTokenCredential($this->_paypal_client_id,$this->_paypal_secret);
        $paypal = new ApiContext($credential);

        $paypal->setConfig($this->_paypal_config);
        
        $now = new Carbon();

        if($request->has('success') && (bool)$request->success == true){
            if($request->has('paymentId') && $request->has('PayerID') && $request->has('token') && $request->has('amount')){
                $success = (bool)$request->success;
                $paymentId = $request->paymentId;
                $payerId = $request->PayerID;
                $token = $request->token;
                $amount = (float)$request->amount;

                $payment = PaypalPayment::get($paymentId, $paypal);
                
                $execute = new PaymentExecution();
                $execute->setPayerId($payerId);

                try{
                    $result = $payment->execute($execute, $paypal);
                }catch(\PayPal\Exception\PayPalConnectionException $e){
                    Session::flash('error','There was an error processing your payment, the token has already been used');
                    return redirect()->route('getClientBalance');
                }

                $paypal_transaction = new PayPal_Transaction;
                $paypal_transaction->user_id = Auth::user()->id;
                $paypal_transaction->payment_id = $paymentId;
                $paypal_transaction->payer_id = $payerId;
                $paypal_transaction->token = $token;
                $paypal_transaction->amount = $amount;
                $paypal_transaction->type = 'INCOMING';
                $paypal_transaction->save();

                $transaction = new Transaction;
                $transaction->amount = $amount;
                $transaction->type = 'INCOMING';
                $transaction->status = 'COMPLETE';
                $transaction->to_id = Auth::user()->id;
                $transaction->from_id = null;
                $transaction->assignment_id = null;
                $transaction->details = 'Received from paypal';
                $transaction->matures_at = $now->toDateTimeString();
                $transaction->save();

                $user = User::find(Auth::user()->id);


                if(!$user){
                    Session::flash('error', 'Cannot load page, user not found');
                    return redirect()->back();
                }

                $user->balance = $user->balance + $amount;
                $user->update();

                Session::flash('success', '<strong>$' . number_format($amount,2) . '</strong> has been credited to your account');

            }else{
                Session::flash('error','There was an error processing your payment, no money was deducted however');
            }
        }else{
            Session::flash('error','There was an error processing your payment, no money was deducted however');
        }

        return redirect()->route('getClientBalance');
    }

    public function postUpdateDeadline($id, Request $request){
        $assignment = Assignment::find($id);

        if(!$assignment){
            Session::flash('error', 'Cannot load page, assignment not found');
            return redirect()->back();
        }

        if($assignment->user_id != Auth::user()->id){
            abort(403);
        }

        $this->validate($request,[
            'deadline'=>'after:today|date|required',
        ]);

        $assignment->deadline = $request->deadline;
        $assignment->update();

        Session::flash('success', 'Deadline extended to '. $request->deadline);

        return redirect()->back();

    }

    public function getCreateReview($assignment_id, $writer_id){
        $assignment = Assignment::where('id',$assignment_id)->where('status','COMPLETE')->first();
        
        if(!$assignment){
            Session::flash('error', 'Sorry, you can only rate a completed assignment');
            return redirect()->route('getClientOrders');
        }
        
        $writer = User::find($writer_id);

        if(!$writer){
            Session::flash('error', 'Cannot load page, writer not found');
            return redirect()->back();
        }

        return view('pages.client.review',[
            'assignment' => $assignment,
            'writer' => $writer,
        ]);
    }

    public function postCreateReview($assignment_id, $writer_id,  Request $request){
        $assignment = Assignment::where('id',$assignment_id)->where('status','COMPLETE')->first();
        if(!$assignment){
            Session::flash('error', 'Sorry, you can only rate a completed assignment');
            return redirect()->route('getClientOrders');
        }
        
        $writer = User::find($writer_id);

        if(!$writer){
            Session::flash('error', 'Cannot load page, writer not found');
            return redirect()->back();
        }


        $client = User::find(Auth::user()->id);

        if(!$client){
            Session::flash('error', 'Cannot load page, client not found');
            return redirect()->back();
        }

        $rating = Rating::where('client_id',$client->id)->where('assignment_id', $assignment->id)->get();

        if(count($rating)){
            Session::flash('error', 'Sorry, you can only rate once per assignment');
            return redirect()->route('getClientDashboard');
        }

        $this->validate($request,[
            'title' => 'required|max:255',
            'content' => 'max:500',
            'reaction' => 'required',
            'stars' => 'required|numeric|min:1|max:5',
        ]);

        $rating = new Rating;

        $rating->assignment_id = $assignment->id;
        $rating->writer_id = $writer->id;
        $rating->client_id = $client->id;
        $rating->title = $request->title;
        $rating->content = $request->content;
        $rating->reaction = $request->reaction;
        $rating->stars = $request->stars;
        $rating->save();

        $notification = new Notification;
        $notification->from_id = $client->id;
        $notification->to_id = $writer->id;
        $notification->type = 'review_made';
        $notification->message = 'made a review on your assignment';
        $notification->refference_id = $assignment->id;
        $notification->save();

        Session::flash('success', 'Review posted successfully');
        return redirect()->route('getClientOrders');
    }

    public function postAddAttachment($id, Request $request){
        if($request->hasFile('attachment') && $request->file('attachment')->isValid()){
            $this->validate($request,[
                'attachment'=>'mimes:docx,doc,pdf,jpg,jpeg,png|max:51200',
                'message' => 'max:500',
            ]);

            $assignment = Assignment::find($id);

            if(!$assignment){
                Session::flash('error', 'Cannot load page, assignment not found');
                return redirect()->back();
            }
            
            if($assignment->user_id != Auth::user()->id){
                abort(403, 'Forbidden');
            }

            $attachment = $request->file('attachment');
            
            $extension = $attachment->getClientOriginalExtension(); 
            $name = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);

            $fileName = Str::slug($name) . '-' . mt_rand(1,200).'.'.$extension;

            $attachment->move(FILE_PATH, $fileName);
            
            $download = new Download;
            $download->filename = $fileName;
            $download->type = $extension;
            $download->assignment_id = $id;
            $download->from_id = Auth::user()->id;
            $download->to_id = null;
            $download->save();

            Session::flash('success', 'Attachment added');

        }

        return redirect()->back();
    }

    public function destroyAttachment($id){
        $download = Download::find($id);

        if(!$download){
            Session::flash('error', 'Cannot load page, file not found');
            return redirect()->back();
        }
        
        if($download->from_id != Auth::user()->id){
            Session::flash('error', "You don't have authority to remove this attachment");

            return redirect()->back();
        }

        $file = FILE_PATH . $download->filename;

        if(file_exists($file)){
            unlink($file);
        }

        $download->delete();

        Session::flash('success', 'Attachment removed');

        return redirect()->back();
    }


    public function postComment($id,Request $request){
        $bid = Bid::find($id);

        if(!$bid){
            Session::flash('error', 'Cannot load page, bid not found');
            return redirect()->back();
        }

        $assignment = Assignment::find($bid->assignment->id);

        if(!$assignment){
            Session::flash('error', 'Cannot load page, assignment not found');
            return redirect()->back();
        }

        if($assignment->status != 'AUCTION'){
            Session::flash('error','You cannot comment if the assignment is already taken');

            return redirect()-back();
        }

        $this->validate($request, [
            'bid_id' => 'required|numeric',
            'message' => 'required',
        ]);

        $comment = new Comment;
        $comment->bid_id = $request->bid_id;
        $comment->user_id = Auth::user()->id;
        $comment->message = $request->message;
        $comment->save();
       
        $notification = new Notification;
        $notification->from_id = Auth::user()->id;
        $notification->to_id = $bid->user->id;
        $notification->type = 'bid_comment';
        $notification->message = ' commented on your bid';
        $notification->refference_id = $bid->assignment->id;
        $notification->save();
        
        Session::flash('success', 'Comment posted');

        return redirect()->back();

    }   



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
