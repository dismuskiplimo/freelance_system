<?php

namespace App\Http\Controllers;

define('FILE_PATH', base_path() . '/public_html/files/');

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Academic_level;

use App\Format;

use App\Download;

use App\Comment;

use App\Discipline;

use App\Sub_discipline;

use App\Assignment_type;

use App\Notification;

use App\Conversation;

use App\Message;

use App\Settings;

use App\Message_notification;

use Auth;

use Session;

use App\User;

use App\Bid;

use App\Rating;

use App\Transaction;

use App\Assignment;

use App\Country;

use App\WithdrawalRequest;

use App\Portofolio;

use App\MyAssignmentTypes;

use App\MyDisciplines;

use App\MyLanguage;

use Illuminate\Support\Str;

use Hash;

use Carbon\Carbon;

class WriterController extends Controller

{
    protected $date, $date_today;


    public function __construct(){
        $this->middleware('auth');
        $this->middleware('writer');
        $this->middleware('not_admin');
        $this->middleware('account_not_blocked');
        $this->middleware('account_active');
        $this->date = date('Y-m-d');
        $this->date_today = date('Y-m-d');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::where('type', 'INCOMING')->where('status', 'PENDING')->where('frozen',0)->get();
        $now = new Carbon();

        foreach($transactions as $transaction){
            if($now->gte($transaction->matures_at)){
                $user = $transaction->to;
                $user->balance = (float)$user->balance + (float)$transaction->amount; 
                $user->update();

                $transaction->status = 'COMPLETE';
                $transaction->transferred_at = $now->toDateTimeString();
                $transaction->update();

                $notification = new Notification;
                $notification->from_id = $transaction->from_id;
                $notification->to_id = $transaction->to_id;
                $notification->type = 'assignment_completed';
                $notification->message = '$'. number_format($transaction->amount,2) . ' matured and has been added to your account';
                $notification->refference_id = $transaction->assignment_id;
                $notification->save();
            }
        }

        $completed_orders = Assignment::where('status','COMPLETE')->where('writer_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        $active_orders = Assignment::where('status','PROGRESS')->where('writer_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        $orders = Assignment::where('status', 'AUCTION')->where('deadline', '>=', $this->date)->take(5)->get();

        return view('pages.writer.dashboard', [
            'completed_orders' => $completed_orders,
            'active_orders' => $active_orders,
            'rejected_orders' => '',
            'user' => Auth::user(),
            'orders' => $orders,
        ]);
    }

    public function getOrderSearch(Request $request){
        $date_today = date('Y-m-d');
        
        $assignments = Assignment::where('status', 'AUCTION')->whereDate('deadline', '>=' , $date_today)->orderBy('updated_at','DESC')->paginate(10);

        $disciplines = Discipline::get();
        $academic_levels = Academic_level::get();
        
        return view('pages.writer.search',[
            'assignments' => $assignments,
            'disciplines' => $disciplines,
            'academic_levels' => $academic_levels,
            'request' => $request,
        ]);
    }

    public function getOrderSearchFilter(Request $request){

        $date_today = date('Y-m-d');
        
        $assignments = Assignment::query();
        
        $assignments->where('status', 'AUCTION')->where('deadline', '>=' , $date_today);

        if($request->has('name') && !empty($request->name)){
            $name = '%' . $request->name . '%';
            $assignments->where('title', 'LIKE', $name);
        }

        if($request->has('academic_level_id') && $request->academic_level_id != 0){
            $assignments->where('academic_level_id', $request->academic_level_id);
        }

        if($request->has('discipline_id') && $request->discipline_id != 0){
            $assignments->where('sub_discipline_id', $request->discipline_id);
        }

        if($request->has('bids')){
            $assignments->where('bids', '0');
        }

        $assignments = $assignments->orderBy('updated_at','DESC')->paginate(10);

        $disciplines = Discipline::get();

        $academic_levels = Academic_level::get();
        
        return view('pages.writer.search',[
            'assignments' => $assignments,
            'disciplines' => $disciplines,
            'academic_levels' => $academic_levels,
            'request' => $request,
        ]);
    }

    public function viewOrder($id){
        $assignment = Assignment::find($id);

        if(!$assignment){
            Session::flash('error', 'Cannot load page, assignment not found');
            return redirect()->back();
        }

        $assignment->views = $assignment->views + 1;
        $assignment->save();
        $my_bid = Bid::where('assignment_id',$id)->where('user_id', Auth::user()->id)->first();

        return view('pages.writer.single-order',[
            'assignment' => $assignment,
            'my_bid' => $my_bid,
        ]);
    }

    public function getOrders(){
        $date= date('Y-m-d');

        $completed_orders = Assignment::where('status','COMPLETE')->where('writer_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        $active_orders = Assignment::where('status','PROGRESS')->where('writer_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        $orders = Assignment::where('status', 'AUCTION')->where('deadline', '>=', $this->date)->take(5)->get();

        return view('pages.writer.orders',[
            'completed_orders'=> $completed_orders,
            'active_orders'=> $active_orders,
            'rejected_orders' => null,
            'orders' => $orders,

        ]);
    }

    public function getBalance(){
        $transactions = Transaction::where('type', 'INCOMING')->where('status', 'PENDING')->where('frozen',0)->get();
        $now = new Carbon();

        foreach($transactions as $transaction){
            if($now->gte($transaction->matures_at)){
                $user = $transaction->to;
                $user->balance = (float)$user->balance + (float)$transaction->amount; 
                $user->update();

                $transaction->status = 'COMPLETE';
                $transaction->transferred_at = $now->toDateTimeString();
                $transaction->update();

                $notification = new Notification;
                $notification->from_id = $transaction->from_id;
                $notification->to_id = $transaction->to_id;
                $notification->type = 'assignment_completed';
                $notification->message = '$'. number_format($transaction->amount,2) . ' matured and has been added to your account';
                $notification->refference_id = $transaction->assignment_id;
                $notification->save();
            }
        }

        $user = User::find(Auth::user()->id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }
        
        $fundsOnHold = Transaction::where('to_id', $user->id)->where('type', 'INCOMING')->where('status', 'PENDING')->where('frozen',0)->orderBy('created_at', 'DESC')->get();
        $transactions = Transaction::where('to_id', $user->id)->where('type','INCOMING')->where('status', 'COMPLETE')->where('frozen',0)->orderBy('transferred_at', 'DESC')->get();
        $outgoing = Transaction::where('from_id', $user->id)->where('type','OUTGOING')->where('frozen',0)->orderBy('transferred_at', 'DESC')->get();
        $withdrawal_requests = WithdrawalRequest::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();

        return view('pages.writer.balance',[
            'user' => $user,
            'funds_on_hold' => $fundsOnHold,
            'transactions' => $transactions,
            'outgoing' => $outgoing,
            'withdrawal_requests' => $withdrawal_requests,
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
            Session::flash('error', 'Cannot load page, invalid configuration');
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

        return redirect()->route('getWriterBalance');
    }

    public function getProfile(){
        $countries = Country::get();
        return view('pages.writer.profile',[
            'countries' => $countries,
        ]);
    }

    public function getUserProfile($slug){
        
        $user = User::where('username', $slug)->where('user_type', 'WRITER')->where('active','1')->first();

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        $orders = Assignment::where('status', 'AUCTION')->where('deadline', '>=', $this->date)->take(5)->get();


        $user->views = $user->views + 1;
        $user->update();

        $complete_assignments = Assignment::where('writer_id', $user->id)->where('status', 'COMPLETE')->get();
        $active_assignments = Assignment::where('writer_id', $user->id)->where('status', 'PROGRESS')->get();
        $assignments = Assignment::where('user_id', Auth::user()->id)->where('deadline', '>=', $this->date_today)->where('status', 'AUCTION')->orderBy('created_at', 'DESC')->get();
        $commission_percent = Settings::where('name','commission_percent')->first();

        if(!$commission_percent){
            Session::flash('error', 'Cannot load page, invalid configuration');
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
        

        return view('pages.writer.user-profile',[
            'user' => $user,
            'orders' => $orders,
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

    public function getSettings(){
        return view('pages.writer.settings');
    }

    public function getNotifications(){
        return view('pages.writer.notifications');
    }

    public function getNotification($id){
        $notification = Notification::find($id);

        if(!$notification){
            Session::flash('error', 'Cannot load page, notification not found');
            return redirect()->back();
        }

        $notification->read_status = 1;
        $notification->update();

        if($notification->type == "bid_placed" || $notification->type == "assignment_awarded" || $notification->type == "assignment_completed" || $notification->type == "bid_comment"){
            return redirect()->route('getSingleWriterOrder', ['id' => $notification->refference_id]);
        }

        if($notification->type == "review_made"){
            return redirect()->route('getWriterReviews',['slug'=>$notification->to->username]);
        }

        if($notification->type == "withdrawal_rejected" || $notification->type == "withdrawal_approved"){
            return redirect()->route('getWriterBalance');
        }

    }

    public function postAddAttachment($id, Request $request){
        if($request->hasFile('attachment') && $request->file('attachment')->isValid()){
            $this->validate($request,[
                'attachment'=>'mimes:docx,doc,pdf,jpg,jpeg,png|max:51200',
                'section' => 'max:255',
            ]);

            $assignment = Assignment::find($id);

            if(!$assignment){
                Session::flash('error', 'Cannot load page, assignment not found');
                return redirect()->back();
            }
            
            if($assignment->writer_id != Auth::user()->id){
                abort(403, 'Forbidden');
            }

            $attachment = $request->file('attachment');

            $section = $request->has('section') ? 'WRITER' : NULL;
            
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
            $download->section = $section;
            $download->save();

            $notification = new Notification;
            $notification->from_id = Auth::user()->id;
            $notification->to_id = $assignment->user->id;
            $notification->type = 'bid_placed';
            $notification->message = 'uploaded a completed assignment';
            $notification->refference_id = $assignment->id;
            $notification->save();

            Session::flash('success', 'Assignment Uploaded');

        }

        return redirect()->back();
    }

    public function destroyAttachment($id){
        $download = Download::find($id);

        $assignment = $download->assignment;

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

        $notification = new Notification;
        $notification->from_id = Auth::user()->id;
        $notification->to_id = $assignment->user->id;
        $notification->type = 'bid_placed';
        $notification->message = 'deleted a completed assignment';
        $notification->refference_id = $assignment->id;
        $notification->save();  

        Session::flash('success', 'Removed');

        return redirect()->back();
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
        
        return view('pages.writer.messages',[
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
            Session::flash('error', 'Cannot load page, client not found');
            return redirect()->back();
        }

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
        
            return view('pages.writer.conversation',[
                'messages' => $messages,
                'conversation' => $conversation,
                'recepient' =>  $recepient,
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

        $clnt = User::where('id',$id)->where('active','1')->first();

        if(!$clnt){
            Session::flash('error', 'Mwssage not sent, client account is not active');
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
        }
        else{
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

        return redirect()->route('getWriterConversation', ['id'=>$conversation_id]);
    }

    public function getCommission(){
        return view('pages.writer.commission');
    }

    public function getBlacklist(){
        return view('pages.writer.blacklist');
    }

    public function getWithdraw(){
        $threshold = Settings::where('name','minimum_threshold')->first();

        if(!$threshold){
            Session::flash('error', 'Cannot load page, invalid configuration');
            return redirect()->back();
        }

        return view('pages.writer.withdraw',[
            'threshold'=> $threshold->value,
        ]);
    }

    public function getQualification(){
        $academic_levels = Academic_level::get();

        return view('pages.writer.qualification',[
            'academic_levels' => $academic_levels,
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

    }


    public function postAbout(Request $request){
        $this->validate($request,[
            'about' => 'required|max:255',
            'professional_bio' => 'required|max:240',
        ]);

        $user = User::find(Auth::user()->id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        $user->about = $request->about;
        $user->professional_bio = $request->professional_bio;

        $user->update();

        Session::flash('success', 'Details updated successfully');

        return redirect()->back();

    }

    public function postEducation(Request $request){
        $this->validate($request,[
            'academic_level_id' => 'required|numeric',
            'school' => 'required|max:255',
            'field_of_specialization' => 'required|max:255',
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

        Session::flash('success', 'Details updated successfully');

        return redirect()->back();
    }

    public function postPrivateInfo(Request $request){
         $this->validate($request,[
            'my_details' => 'required|max:255',
            'academic_experience' => 'required|max:240',
        ]);

        $user = User::find(Auth::user()->id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        $user->my_details = $request->my_details;
        $user->academic_experience = $request->academic_experience;

        $user->update();

        Session::flash('success', 'Details updated successfully');

        return redirect()->back();
    }

    public function postDOB(Request $request){
         $this->validate($request,[
            'dob' => 'date_format:Y-m-d|before:today',
        ]);

        $user = User::find(Auth::user()->id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        $user->dob = $request->dob;
        
        $user->update();

        Session::flash('success', 'Date of Birth updated successfully');

        return redirect()->back();
    }

    public function postContactInfo(Request $request){
         $this->validate($request,[
            'country_id' => 'required|numeric',
            'city' => 'max:255',
            'phone' => 'max:255',
            'address' => 'max:255',
        ]);

        $user = User::find(Auth::user()->id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        $user->country_id = $request->country_id;
        $user->city = $request->city;
        $user->phone = $request->phone;
        $user->address = $request->address;

        $user->update();

        Session::flash('success', 'Contact details updated successfully');

        return redirect()->back();
    }

    public function postUpdatePassword(Request $request){
         $this->validate($request,[
            'old_password' => 'required|min:6|max:255',
            'new_password' => 'required|min:6|max:255|confirmed',
            'new_password_confirmation' => 'required|min:6|max:255',
        ]);

        if(Hash::check($request->old_password,Auth::user()->password)){
            $user = User::find(Auth::user()->id);

            if(!$user){
                Session::flash('error', 'Cannot load page, user not found');
                return redirect()->back();
            }

            $user->password = Hash::make($request->new_password);
            
            $user->update();

            Session::flash('success', 'Password updated successfully');
        }else{
            Session::flash('error', 'The password provided does not match the one in our database');
        }

        return redirect()->back();
    }

    public function postBid($id, Request $request){
        $assignment = Assignment::find($id);

        if(!$assignment){
            Session::flash('error', 'Cannot load page, assignment not found');
            return redirect()->back();
        }

        $this->validate($request, [
            'amount' => 'numeric|min:5',
            'comment' => 'max:255|min:10|required',
        ]);

        if(empty($request->amount)){
            $request->amount = null;
        }

        $bid = Bid::where('assignment_id',$id)->where('user_id',Auth::user()->id)->first();

        if(count($bid)){
            if(empty($bid->amount) || is_null($bid->amount)){
                $bid->amount = $request->amount;
                $bid->update();

                $notification = new Notification;
                $notification->from_id = Auth::user()->id;
                $notification->to_id = $assignment->user->id;
                $notification->type = 'bid_placed';
                $notification->message = 'updated bid';
                $notification->refference_id = $assignment->id;
                $notification->save();

                if($request->ajax()){
                    return response()->json(['code' => 200, 'message' => 'Bid updated ;)']);
                }

                Session::flash('success','Bid updated ;)');

            }else{
                if($request->ajax()){
                    return response()->json(['code' => 403, 'message' => 'You cant bid twice on a single assignment ;(']);
                }

                Session::flash('error','You cant bid twice on a single assignment ;(');
            }
        }else{
            $bid = new Bid;
            $bid->assignment_id = $id;
            $bid->user_id = Auth::user()->id;
            $bid->amount = $request->amount; 
            $bid->comment = $request->comment;

            $bid->save();

            $notification = new Notification;
            $notification->from_id = Auth::user()->id;
            $notification->to_id = $assignment->user->id;
            $notification->type = 'bid_placed';
            $notification->message = 'placed a bid';
            $notification->refference_id = $assignment->id;
            $notification->save();

            $assignment->bids = $assignment->bids + 1;
            $assignment->update();

            if($request->ajax()){
                return response()->json(['code' => 200, 'message' => 'Bid submitted ;)']);
            }

            Session::flash('success','Bid submitted ;)'); 
        }

        return redirect()->back();
    }

    public function getReviews($slug){
        $user = User::where('username', $slug)->first();

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }


        return view('pages.writer.reviews',[
            'user' => $user,
        ]);
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
        $notification->to_id = $bid->assignment->user->id;
        $notification->type = 'bid_comment';
        $notification->message = ' commented on a bid';
        $notification->refference_id = $bid->assignment->id;
        $notification->save();

        if($bid->user->id != Auth::user()->id){
            $notification = new Notification;
            $notification->from_id = Auth::user()->id;
            $notification->to_id = $bid->user->id;
            $notification->type = 'bid_comment';
            $notification->message = ' commented on your bid';
            $notification->refference_id = $bid->assignment->id;
            $notification->save();
        }

        Session::flash('success', 'Comment posted');

        return redirect()->back();

    }    

    public function postPortfolio(Request $request){
        if($request->hasFile('file') && $request->file('file')->isValid()){
            $this->validate($request,[
                'file'=>'mimes:docx,doc,pdf,jpg,jpeg,png|max:51200',
                'information' => 'max:255',
            ]);

            $attachment = $request->file('file');
            
            $extension = $attachment->getClientOriginalExtension(); 
            $name = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);

            $fileName = Str::slug($name) . '-' . mt_rand(1,200).'.'.$extension;

            $attachment->move(FILE_PATH, $fileName);
            
            $portfolio = new Portofolio;
            $portfolio->filename = $fileName;
            $portfolio->type = $extension;
            $portfolio->information = $request->information;
            $portfolio->user_id = Auth::user()->id;
            $portfolio->save();

            Session::flash('success', 'Portfolio added');

        }

        return redirect()->back();
    }

    public function deletePortfolio($id){
        $portfolio = Portofolio::find($id);

        if(!$portfolio){
            Session::flash('error', 'Cannot load page, portfolio not found');
            return redirect()->back();
        }
        
        if($portfolio->user_id != Auth::user()->id){
            
            Session::flash('error', "You don't have authority to remove this portfolio");

            return redirect()->back();
        }

        $file = FILE_PATH . $portfolio->filename;

        if(file_exists($file)){
            unlink($file);
        }

        $portfolio->delete();

        Session::flash('success', 'Portfolio removed');

        return redirect()->back();
    }

    public function postLanguage(Request $request){
        $this->validate($request,[
            'language_id' => 'numeric|required',
        ]);

        $language = new MyLanguage;
        $language->user_id = Auth::user()->id;
        $language->language_id = $request->language_id;
        $language->save();

        Session::flash('success', 'Language added');

        return redirect()->back();
    }

    public function deleteLanguage($id){
        

        $language = MyLanguage::find($id);

        if(!$language){
            Session::flash('error', 'Cannot load page, language not found');
            return redirect()->back();
        }

        if($language->user_id == Auth::user()->id){
            $language->delete();

            Session::flash('success', 'Language removed');
        }else{
            Session::flash('error', 'Language not removed, access denied');
        }
        
        

        return redirect()->back();
    }

    public function postAssignmentType(Request $request){
        $this->validate($request,[
            'assignment_type_id' => 'numeric|required',
        ]);

        $assignmentType = new MyAssignmentTypes;
        $assignmentType->user_id = Auth::user()->id;
        $assignmentType->assignment_type_id = $request->assignment_type_id;
        $assignmentType->save();

        Session::flash('success', 'Assignment type added');

        return redirect()->back();
    }

    public function deleteAssignmentType($id){
        

        $assignmentType = MyAssignmentTypes::find($id);

        if(!$assignmentType){
            Session::flash('error', 'Cannot load page, assignment type not found');
            return redirect()->back();
        }

        if($assignmentType->user_id == Auth::user()->id){
            $assignmentType->delete();

            Session::flash('success', 'Assignment Type removed');
        }else{
            Session::flash('error', 'Assignment type not removed, access denied');
        }

        return redirect()->back();
    }

    public function postDiscipline(Request $request){
        $this->validate($request,[
            'discipline_id' => 'numeric|required',
        ]);

        $discipline = new MyDisciplines;
        $discipline->user_id = Auth::user()->id;
        $discipline->discipline_id = $request->discipline_id;
        $discipline->save();

        Session::flash('success', 'Discipline added');

        return redirect()->back();
    }

    public function deleteDiscipline($id){
        

        $discipline = MyDisciplines::find($id);

        if(!$discipline){
            Session::flash('error', 'Cannot load page, discipline not found');
            return redirect()->back();
        }

        if($discipline->user_id == Auth::user()->id){
            $discipline->delete();

            Session::flash('success', 'Discipline removed');
        }else{
            Session::flash('error', 'Discipline not removed, access denied');
        }
        
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
