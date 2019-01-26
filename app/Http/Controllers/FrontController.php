<?php

namespace App\Http\Controllers;

define('FILE_PATH', base_path() . '/public_html/files/');

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Assignment;

use App\Rating;

use App\Assignment_type;

use App\User;

use Auth;

use App\Settings;

use Carbon\Carbon;

class FrontController extends Controller
{
    
    protected $date_today;
    protected $date;

    public function __construct(){
        $this->date_today = date('Y-m-d');
        $this->date = date('Y-m-d');
    }

    public function index(){
        $assignment_types = Assignment_type::get();
    	$assignment_types_min = Assignment_type::limit(6)->get();

        return view('pages.index', [
            'assignment_types'      => $assignment_types,
            'assignment_types_min'  => $assignment_types_min,
        ]);
    }

    public function order(){

    }

    public function getWriter($slug){
        $user = User::where('username', $slug)->where('user_type', 'WRITER')->where('active','1')->first();

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        $user->views = $user->views + 1;
        $user->update();

        $complete_assignments = Assignment::where('writer_id', $user->id)->where('status', 'COMPLETE')->get();
        $active_assignments = Assignment::where('writer_id', $user->id)->where('status', 'PROGRESS')->get();
        $assignments = Assignment::where('user_id', $user->id)->where('deadline', '>=', $this->date_today)->where('status', 'AUCTION')->orderBy('created_at', 'DESC')->get();
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
        

        return view('pages.writer',[
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
    	
        $writers = User::where('user_type', 'WRITER')->orderBy('orders_complete', 'DESC')->paginate(20);

        return view('pages.writers',[
            'writers' => $writers,
            'request' => $request,
        ]);
    }

    public function getWriterReviews($slug){
        $user = User::where('username', $slug)->first();

        if(!$user){
            Session::flash('error', 'Cannot load page, user not found');
            return redirect()->back();
        }

        return view('pages.reviews',[
            'user' => $user,
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
            $query->where('last_seen', '>=', $now->subSeconds(30)->toDateTimeString())->where('last_seen', '<=', $now->toDateTimeString());
        }

        $writers = $query->where('user_type', 'WRITER')->orderBy('views', 'DESC')->paginate(20);

        return view('pages.writers',[
            'writers' => $writers,
            'request' => $request,
        ]);        

    }

    public function getAssignment($id){
        $assignment = Assignment::find($id);

        if(!$assignment){
            Session::flash('error', 'Cannot load page, assignment not found');
            return redirect()->back();
        }

        if(Auth::check()){
            if(Auth::user()->is_admin == 1){
                return redirect()->route('getAdminDashboard');
            }

            elseif(Auth::user()->user_type == 'CLIENT'){
                return redirect()->route('getSingleClientOrder', ['id'=>$id]);
            }

            elseif(Auth::user()->user_type == 'WRITER'){
                return redirect()->route('getSingleWriterOrder', ['id'=>$id]);
            }
            else{
                return redirect()->route('getDashboard');
            }
        }else{

        }

        
    }

    public function getClient($slug){
    	return view('pages.client');
    }

    public function getClients(){
    	return view('pages.clients');
    }

    public function getRules(){
        return view('pages.rules');
    }

    public function getPrivacyPolicy(){
        return view('pages.privacy-policy');
    }

    public function getRecentOrders(){
        return view('pages.recent-orders');
    }

    public function getAbout(){
        return view('pages.about');
    }

    public function getNoPlagiarism(){
        return view('pages.no-plagiarism');
    }

    public function getTerms(){
        return view('pages.terms');
    }

    public function getFaqWriter(){
        return view('pages.faq-writer');
    }

    public function getFaqStudent(){
        return view('pages.faq-student');
    }

    
}
