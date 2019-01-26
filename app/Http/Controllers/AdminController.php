<?php

namespace App\Http\Controllers;

define('FILE_PATH', base_path() . '/public_html/files/');

use App\Http\Requests;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Carbon\Carbon;

use App\Academic_level;

use App\Format;

use App\Language;

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

use App\Country;

use App\Settings;

use App\Transaction;

use App\PayPal_Transaction;

use Auth;

use Hash;

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

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.dashboard',[
            'page'=>'dashboard',
        ]);
    }

    public function getWriters($type){

        $query = User::query();

        if($type == 'active'){
            $query->where('active','1');
            $sub_page = 'active_writers';

        }elseif($type == 'inactive'){
            $query->where('active','0');
            $sub_page = 'inactive_writers';

        }elseif($type == 'blocked'){
            $query->where('attempts_left','0');
            $sub_page = 'blocked_writers';

        }else{
            return redirect()->route('getDashboard');
        }

        $users = $query->where('user_type','WRITER')->where('is_admin','0')->orderBy('username','asc')->paginate(20);

        return view('pages.admin.writers',[
            'users'=>$users,
            'page'=>'writers',
            'sub_page'=>$sub_page,
        ]);
    }

    public function getClients($type){
        $query = User::query();

        if($type == 'active'){
            $query->where('active','1');
            $sub_page = 'active_clients';

        }elseif($type == 'inactive'){
            $query->where('active','0');
            $sub_page = 'inactive_clients';

        }elseif($type == 'blocked'){
            $query->where('attempts_left','0');
            $sub_page = 'blocked_clients';

        }else{
            return redirect()->route('getDashboard');
        }

        $users = $query->where('user_type','CLIENT')->where('is_admin','0')->orderBy('username','asc')->paginate(20);

        return view('pages.admin.clients',[
            'users'=>$users,
            'page'=>'clients',
            'sub_page'=>$sub_page,
        ]);
    }

    public function getUser($id){
        $user = User::find($id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        return view('pages.admin.single-user',[
            'user'=>$user,
            'page'=>'user',
        ]);
    }

    public function postUpdateUser($id, Request $request){
        $user = User::find($id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        if($user->email == $request->email || $user->username == $request->username){
            if($user->email == $request->email && $user->username == $request->username){
                $this->validate($request,[
                    'name'=>'required|max:255',
                    'username'=>'required|max:255',
                    'email'=>'email|required|max:255',
                    'user_type'=>'max:255|required',
                    'dob'=>'date_format:Y-m-d|before:today',
                    'phone'=>'max:255',
                    'address'=>'max:255',
                    'city'=>'max:255',
                    'country_id'=>'numeric',
                    'school'=>'max:255',
                    'academic_level_id'=>'numeric',
                    'field_of_specialization'=>'max:255',
                    'about'=>'max:255',
                    'professional_bio'=>'max:500',
                    'my_details'=>'max:255',
                    'academic_experience'=>'max:500',
                ]);
            }elseif($user->email == $request->email && $user->username != $request->username){
                $this->validate($request,[
                    'name'=>'required|max:255',
                    'username'=>'required|unique:users,username|max:255',
                    'email'=>'email|required|max:255',
                    'user_type'=>'max:255|required',
                    'dob'=>'date_format:Y-m-d|before:today',
                    'phone'=>'max:255',
                    'address'=>'max:255',
                    'city'=>'max:255',
                    'country_id'=>'numeric',
                    'school'=>'max:255',
                    'academic_level_id'=>'numeric',
                    'field_of_specialization'=>'max:255',
                    'about'=>'max:255',
                    'professional_bio'=>'max:500',
                    'my_details'=>'max:255',
                    'academic_experience'=>'max:500',
                ]);
            }elseif($user->email != $request->email && $user->username == $request->username){
                $this->validate($request,[
                    'name'=>'required|max:255',
                    'username'=>'required|max:255',
                    'email'=>'email|required|unique:users,email|max:255',
                    'user_type'=>'max:255|required',
                    'dob'=>'date_format:Y-m-d|before:today',
                    'phone'=>'max:255',
                    'address'=>'max:255',
                    'city'=>'max:255',
                    'country_id'=>'numeric',
                    'school'=>'max:255',
                    'academic_level_id'=>'numeric',
                    'field_of_specialization'=>'max:255',
                    'about'=>'max:255',
                    'professional_bio'=>'max:500',
                    'my_details'=>'max:255',
                    'academic_experience'=>'max:500',
                ]);
            }
        }else{
            $this->validate($request,[
                'name'=>'required|max:255',
                'username'=>'required|max:255|unique:users,username',
                'email'=>'email|required|max:255|unique:users,email',
                'user_type'=>'max:255|required',
                'dob'=>'date_format:Y-m-d|before:today',
                'phone'=>'max:255',
                'address'=>'max:255',
                'city'=>'max:255',
                'country_id'=>'numeric',
                'school'=>'max:255',
                'academic_level_id'=>'numeric',
                'field_of_specialization'=>'max:255',
                'about'=>'max:255',
                'professional_bio'=>'max:500',
                'my_details'=>'max:255',
                'academic_experience'=>'max:500',
            ]);
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $user->dob = $request->dob;
        $user->phone = $request->phone;
        $user->address = $request->address;

        $user->city = $request->city;
        $user->country_id = $request->country_id;
        $user->school = $request->school;
        $user->academic_level_id = $request->academic_level_id;
        $user->field_of_specialization = $request->field_of_specialization;
        
        if($user->user_type == 'WRITER'){
            $user->about = $request->about;
            $user->professional_bio = $request->professional_bio;
            $user->my_details = $request->my_details;
            $user->academic_experience = $request->academic_experience;
        }


        $user->update();

        Session::flash('success', 'User updated');

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

    public function postAdminProfile(Request $request){
        $user = User::find(Auth::user()->id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        if($user->email == $request->email || $user->username == $request->username){
            if($user->email == $request->email && $user->username == $request->username){
                $this->validate($request,[
                    'username'=>'required|max:255',
                    'email'=>'email|required|max:255',
                ]);
            }elseif($user->email == $request->email && $user->username != $request->username){
                $this->validate($request,[
                    'username'=>'required|unique:users,username|max:255',
                    'email'=>'email|required|max:255',
                ]);
            }elseif($user->email != $request->email && $user->username == $request->username){
                $this->validate($request,[
                    'username'=>'required|max:255',
                    'email'=>'email|required|unique:users,email|max:255',
                ]);
            }
        }else{
            $this->validate($request,[
                'username'=>'required|max:255|unique:users,username',
                'email'=>'email|required|max:255|unique:users,email',
            ]);
        }

        $this->validate($request,[
            'name' => 'required|max:255',
            'address' => 'max:255',
            'city' => 'max:255',
            'country_id' => 'numeric',
            'about' => 'max:500',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->country_id = $request->country_id;
        $user->about = $request->about;

        $user->update();

        Session::flash('success', 'Profile updated');

        return redirect()->back();
    }


    public function activateUser($id){
        $user = User::find($id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        $user->active = 1;
        $user->attempts_left = 3;
        $user->update();

        Session::flash('success','User activated');

        return redirect()->back();
    }

    public function deactivateUser($id){
        $user = User::find($id);

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        $user->active = 0;
        $user->update();

        Session::flash('success','User deactivated');

        return redirect()->back();
    }

    public function getWithdrawalRequests($type){
        $query = WithdrawalRequest::query();

        if($type == 'pending'){
            $query->where('status','PENDING');
            $sub_page = 'pending_requests';
        }elseif($type == 'complete' ){
            $query->where('status','APPROVED');
            $sub_page = 'complete_requests';
        }elseif($type == 'rejected'){
            $query->where('status','REJECTED');
            $sub_page = 'rejected_requests';
        }else{
            return redirect()->back();
        }

        $requests = $query->orderBy('created_at','DESC')->paginate(20);

        return view('pages.admin.withdrawal-requests',[
            'requests'=>$requests,
            'page'=>'withdrawal-requests',
            'sub_page'=> $sub_page,
            'type'=>$type,
        ]);
    }

    public function postApproveWithdrawalRequest($id){

        $withdrawal_request = WithdrawalRequest::find($id);

        if(!$withdrawal_request){
            Session::flash('error', 'Cannot load page, withdrawal request not found');
            return redirect()->back();
        }

        if($withdrawal_request->status == 'PENDING'){
            $user = User::find($withdrawal_request->user_id);

            if(!$user){
                Session::flash('error', 'Cannot load page, user not found');
                return redirect()->back();
            }

            $transaction = Transaction::where('id',$withdrawal_request->transaction_id)->where('status','PENDING')->where('type','OUTGOING')->first();

            if(!$transaction){
                Session::flash('error', 'Cannot load page, transaction not found');
                return redirect()->back();
            }
            
            if($transaction->status == 'PENDING'){
                if($user->balance >= $transaction->amount){
                    $withdrawal_request->status = 'APPROVED';
                    $withdrawal_request->approved_at = Carbon::now()->toDateTimeString();
                    $withdrawal_request->admin_id = Auth::user()->id;
                    $withdrawal_request->update();

                    $transaction->status = 'COMPLETE';
                    $transaction->transferred_at = Carbon::now()->toDateTimeString();
                    $transaction->update();

                    $user->balance = (float)$user->balance - (float)$transaction->amount;
                    $user->update();

                    $notification = new Notification;
                    $notification->from_id = Auth::user()->id;
                    $notification->to_id = $user->id;
                    $notification->type = 'withdrawal_approved';
                    $notification->message = ' transfered $' . number_format($transaction->amount,2) . ' to your paypal account';
                    $notification->refference_id = null;
                    $notification->save();

                    Session::flash('success', 'Withdrawal approved');
                }else{
                    Session::flash('success', 'Withdrawal not approved, writer does not have sufficient funds($'  . number_format($user->balance) . ')');
                }
            }else{
                Session::flash('error', 'The transaction has already been approved');
            }
            
        }else{
            Session::flash('error', 'The request had already been approved/rejected');
            
        }

        return redirect()->back();
    }

    public function postRejectWithdrawalRequest($id, Request $request){
        $this->validate($request,[
            'message' => 'required|max:255'
        ]);

        $withdrawal_request = WithdrawalRequest::find($id);

        if(!$withdrawal_request){
            Session::flash('error', 'Cannot load page, withdrawal request not found');
            return redirect()->back();
        }

        if($withdrawal_request->status == 'PENDING'){
            $user = User::find($withdrawal_request->user_id);

            if(!$user){
                Session::flash('error', 'Cannot load page, user not found');
                return redirect()->back();
            }

            $transaction = Transaction::where('id',$withdrawal_request->transaction_id)->where('status','PENDING')->where('type','OUTGOING')->first();

            if(!$transaction){
                Session::flash('error', 'Cannot load page, transaction not found');
                return redirect()->back();
            }
            
            if($transaction->status == 'PENDING'){
                $withdrawal_request->status = 'REJECTED';
                $withdrawal_request->approved_at = Carbon::now()->toDateTimeString();
                $withdrawal_request->message = $request->message;
                $withdrawal_request->admin_id = Auth::user()->id;
                $withdrawal_request->update();

                $transaction->status = 'REJECTED';
                $transaction->transferred_at = Carbon::now()->toDateTimeString();
                $transaction->update();

                $notification = new Notification;
                $notification->from_id = Auth::user()->id;
                $notification->to_id = $user->id;
                $notification->type = 'withdrawal_rejected';
                $notification->message = ' your withdrawal request was rejected because ' . $request->message;
                $notification->refference_id = null;
                $notification->save();

                Session::flash('success', 'Withdrawal rejected');
            }else{
                Session::flash('error', 'The transaction has already been approved/rejected');
            }
            
        }else{
            Session::flash('error', 'The request had already been approved/rejected');
            
        }

        return redirect()->back();
    }

    public function getAssignments($type){
        $query = Assignment::query();

        

        if($type == 'auction'){
            $sub_page = 'auction';
            
            $query->where('status','AUCTION')->where('deadline', '>=', Carbon::now()->toDateTimeString());

        }elseif($type == 'progress'){
            $sub_page = 'progress';
            $query->where('status','PROGRESS');

        }elseif($type == 'complete'){
            $sub_page = 'complete';
            $query->where('status','COMPLETE');

        }elseif($type == 'rejected'){
            $sub_page = 'rejected';
            $query->where('status','REJECTED');

        }elseif($type == 'late'){
            $sub_page = 'late';
            $query->where('status','COMPLETE')->whereRaw('assignments.completed_at > assignments.deadline');

        }elseif($type == 'expired'){
            $sub_page = 'expired';
            $query->where('status','AUCTION')->whereRaw('NOW() > assignments.deadline');
            
        }else{
            return redirect()->back();
        }

        $assignments = $query->orderBy('created_at','DESC')->paginate(20);

        return view('pages.admin.assignments',[
            'assignments'=>$assignments,
            'page'=>'assignments',
            'sub_page'=>$sub_page,
            'type'=>$type,
        ]);
    }

    public function getTransactions($type,$amount){

        $query = Transaction::query();
        $query2 = PayPal_Transaction::query();

        if($type == "insite" && $amount == "all"){
            $sub_page = 'insite_all';

        }

        elseif($type == "insite" && $amount == "incoming"){
            $sub_page = 'insite_incoming';
            $query->where('type','INCOMING');
        }

        elseif($type == "insite" && $amount == "outgoing"){
            $sub_page = 'insite_outgoing';
            $query->where('type','OUTGOING');
        }

        elseif($type == "paypal" && $amount == "all"){
            $sub_page = 'paypal_all';
        }

        elseif($type == "paypal" && $amount == "incoming"){
            $sub_page = 'paypal_incoming';
            $query2->where('type','INCOMING');
        }

        elseif($type == "paypal" && $amount == "outgoing"){
            $sub_page = 'paypal_outgoing';
            $query2->where('type','OUTGOING');
        }

        

        else{
            abort(404);
        }

        $transactions = $query->orderBy('created_at','DESC')->paginate(50);
        $paypals = $query2->orderBy('created_at','DESC')->paginate(50);

        return view('pages.admin.transactions',[
            'transactions'=>$transactions,
            'paypals' => $paypals,
            'type' => $type,
            'page'=>'transactions',
            'sub_page'=> $sub_page,
        ]);
    }

    public function getSettings(){
        $users = User::where('user_type','CLIENT')->orderBy('username', 'ASC')->get();

        return view('pages.admin.settings',[
            'users'=>$users,
            'page'=>'settings',
            'sub_page'=>'',
        ]);
    }

    public function getProfile(){
        $users = User::where('user_type','CLIENT')->orderBy('username', 'ASC')->get();

        return view('pages.admin.profile',[
            'users'=>$users,
            'page'=>'profile',
            'sub_page'=>'',
        ]);
    }

    public function getDisciplines(){
        $disciplines = Discipline::orderBy('name','ASC')->paginate(15);

        return view('pages.admin.disciplines',[
            'disciplines' => $disciplines,
            'page' => 'assignments',
            'sub_page' => 'disciplines',
        ]);
    }

    public function postDisciplines(Request $request){
        $this->validate($request,[
            'name' => 'required|max:255',
        ]);

        $discipline = new Discipline;
        $discipline->name = $request->discipline;
        $discipline->save();

        Session::flash('success', 'Discipline Added');

        return redirect()->back();
    }


    public function updateDisciplines($id, Request $request){
        $this->validate($request,[
            'name' => 'required|max:255',
        ]);

        $discipline = Discipline::find($id);

        if(!$discipline){
            Session::flash('error', 'Cannot load page, discipline not found');
            return redirect()->back();
        }

        $discipline->name = $request->discipline;
        $discipline->update();

        Session::flash('success', 'Discipline Updated');

        return redirect()->back();
    }

    public function deleteDisciplines($id){

        $discipline = Discipline::find($id);

        if(!$discipline){
            Session::flash('error', 'Cannot load page, discipline not found');
            return redirect()->back();
        }

        $discipline->delete();

        Session::flash('success', 'Discipline Deleted');

        return redirect()->back();
    }

    public function getSubjects(){
         $disciplines = Discipline::orderBy('name','ASC')->get();
         $subjects = Sub_discipline::orderBy('name','ASC')->paginate(15);

        return view('pages.admin.subjects',[
            'disciplines' => $disciplines,
            'subjects' => $subjects,
            'page' => 'assignments',
            'sub_page' => 'subjects',
        ]);
    }

    public function postSubjects(Request $request){
        $this->validate($request,[
            'name' => 'required|max:255',
            'discipline_id' => 'required|numeric',
        ]);

        $discipline = Discipline::find($request->discipline_id);

        if(!$discipline){
            Session::flash('error', 'Cannot load page, discipline not found');
            return redirect()->back();
        }

        $subject = new Sub_discipline;
        $subject->name = $request->name;
        $subject->discipline_id = $request->discipline_id;
        $subject->save();

        Session::flash('success', 'Subject Added');

        return redirect()->back();
    }

    public function updateSubjects($id, Request $request){
        $this->validate($request,[
            'name' => 'required|max:255',
            'discipline_id' => 'required|numeric',
        ]);

        $discipline = Discipline::find($request->discipline_id);

        if(!$discipline){
            Session::flash('error', 'Cannot load page, discipline not found');
            return redirect()->back();
        }

        $subject = Sub_discipline::find($id);

        if(!$subject){
            Session::flash('error', 'Cannot load page, subject not found');
            return redirect()->back();
        }

        $subject->name = $request->name;
        $subject->discipline_id = $request->discipline_id;
        $subject->update();

        Session::flash('success', 'Subject Updated');

        return redirect()->back();
    }

    public function deleteSubjects($id){

        $subject = Sub_discipline::find($id);

        if(!$subject){
            Session::flash('error', 'Cannot load page, subject not found');
            return redirect()->back();
        }

        $subject->delete();

        Session::flash('success', 'Subject Deleted');

        return redirect()->back();
    }

    public function getAssignmentTypes(){
        $assignment_types = Assignment_type::orderBy('name','ASC')->paginate(15);

        return view('pages.admin.assignment-types',[
            'assignment_types' => $assignment_types,
            'page' => 'assignments',
            'sub_page' => 'assignment_types',
        ]);
    }

    public function postAssignmentTypes(Request $request){
        $this->validate($request,[
            'name' => 'required|max:255',
        ]);

        $assignment_type = new Assignment_type;
        $assignment_type->name = $request->name;
        $assignment_type->save();

        Session::flash('success', 'Assignment Type Added');

        return redirect()->back();
    }


    public function updateAssignmentTypes($id, Request $request){
        $this->validate($request,[
            'name' => 'required|max:255',
        ]);

        $assignment_type = Assignment_type::find($id);

        if(!$assignment_type){
            Session::flash('error', 'Cannot load page, assignment type not found');
            return redirect()->back();
        }

        $assignment_type->name = $request->name;
        $assignment_type->update();

        Session::flash('success', 'Assignment Type Updated');

        return redirect()->back();
    }

    public function deleteAssignmentTypes($id){

        $assignment_type = Assignment_type::find($id);

        if(!$assignment_type){
            Session::flash('error', 'Cannot load page, assignment type not found');
            return redirect()->back();
        }

        $assignment_type->delete();

        Session::flash('success', 'Assignment Type Deleted');

        return redirect()->back();
    }

    public function getLanguages(){
        $languages = Language::orderBy('name','ASC')->paginate(15);

        return view('pages.admin.languages',[
            'languages' => $languages,
            'page' => 'assignments',
            'sub_page' => 'languages',
        ]);
    }

    public function postLanguages(Request $request){
        $this->validate($request,[
            'name' => 'required|max:255',
        ]);

        $language = new Language;
        $language->name = $request->name;
        $language->save();

        Session::flash('success', 'Language Added');

        return redirect()->back();
    }


    public function updateLanguages($id, Request $request){
        $this->validate($request,[
            'name' => 'required|max:255',
        ]);

        $language = Language::find($id);

        if(!$language){
            Session::flash('error', 'Cannot load page, language not found');
            return redirect()->back();
        }

        $language->name = $request->name;
        $language->update();

        Session::flash('success', 'Language Updated');

        return redirect()->back();
    }

    public function deleteLanguages($id){

        $language = Language::find($id);

        if(!$language){
            Session::flash('error', 'Cannot load page, language not found');
            return redirect()->back();
        }

        $language->delete();

        Session::flash('success', 'Language Deleted');

        return redirect()->back();
    }

    public function postSitePrefferences(Request $request){
        $this->validate($request, [
            'mature_duration'=>'required|numeric',
            'paypal_email'=>'required|email',
            'commission_percent'=>'required|numeric|min:0|max:100',
            'minimum_threshold'=>'required|numeric',
        ]);

        $setting = Settings::where('name','mature_duration')->first();
        $setting->value = $request->mature_duration;
        $setting->update();

        $setting = Settings::where('name','paypal_email')->first();
        $setting->value = $request->paypal_email;
        $setting->update();

        $setting = Settings::where('name','commission_percent')->first();
        $setting->value = $request->commission_percent;
        $setting->update();

        $setting = Settings::where('name','minimum_threshold')->first();
        $setting->value = $request->minimum_threshold;
        $setting->update();

        Session::flash('success', 'Site prefferences updated');

        return redirect()->back();


    }

    public function postSiteContactInfo(Request $request){
        $this->validate($request, [
            'support_email'=>'required|email',
            'notification_email'=>'required|email',
            'phone_number'=>'required',
        ]);

        $setting = Settings::where('name','support_email')->first();
        $setting->value = $request->support_email;
        $setting->update();

        $setting = Settings::where('name','notification_email')->first();
        $setting->value = $request->notification_email;
        $setting->update();

        $setting = Settings::where('name','phone_number')->first();
        $setting->value = $request->phone_number;
        $setting->update();

        Session::flash('success', 'Site contact info updated');

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
