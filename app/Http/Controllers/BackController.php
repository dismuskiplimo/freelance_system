<?php

namespace App\Http\Controllers;

define('FILE_PATH', base_path() . '/public_html/files/');

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Transaction;

use App\Notification;

use App\Message_notification;
use App\Conversation;
use App\Message;

use App\User;

use App\Download;
use App\Portofolio;

use Auth;

use Carbon\Carbon;

class BackController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}


    public function index(){
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

    	if(Auth::user()->is_admin){
    		return redirect()->route('getAdminDashboard');
    	}

    	elseif(Auth::user()->user_type === 'WRITER'){
    		return redirect()->route('getWriterDashboard');
    	}

    	elseif(Auth::user()->user_type === 'CLIENT'){
    		return redirect()->route('getClientDashboard');
    	}

    	else{
    		return redirect('/');
    	}
    }

    public function getUpdateLastSeen(){
        $user = User::find(Auth::user()->id);

        if(!$user){
            return response()->json(['code'=>404, 'message'=>'user not found']);
        }

        $user->last_seen = Carbon::now()->toDateTimeString();
        $user->update();
    }

    public function download($id){
        $file = Download::find($id);

        if(!$file){
            Session::flash('error', 'Cannot download attachment, file not found');
            return redirect()->back();
        }
        $path = FILE_PATH .$file->filename;
        
        if(file_exists($path)){
            $path = FILE_PATH .$file->filename ;
            return response()->download($path);
        }

    }

    public function downloadPortfolio($id){
        $file = Portofolio::find($id);

        if(!$file){
            Session::flash('error', 'Cannot download portfolio, file not found');
            return redirect()->back();
        }

        $path = FILE_PATH .$file->filename;
        
        if(file_exists($path)){
            $path = FILE_PATH .$file->filename ;
            return response()->download($path);
        }

    }

    public function getNotifications(){
        $count = Notification::where('to_id', Auth::user()->id)->where('read_status', 0)->get();
        
        $notifications = Notification::where('to_id', Auth::user()->id)->orderBy('created_at','DESC')->limit('10')->get();

        $data = [];
        if(Auth::user()->user_type == 'WRITER'){
            foreach ($notifications as $notification) {
                $data[] = [
                    'username'=>$notification->author->username,
                    'type' => $notification->type,
                    'message' => $notification->message,
                    'refference_id' => $notification->refference_id,
                    'read_status' => $notification->read_status,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'url' => url(route('getWriterNotification', ['id'=>$notification->id])),
                ];
            }
        }

        elseif(Auth::user()->user_type == 'CLIENT'){
            foreach ($notifications as $notification) {
                $data[] = [
                    'username'=>$notification->author->username,
                    'type' => $notification->type,
                    'message' => $notification->message,
                    'refference_id' => $notification->refference_id,
                    'read_status' => $notification->read_status,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'url' => url(route('getClientNotification', ['id'=>$notification->id])),
                ];
            }
        }    
        
        $notifications = ['count'=>count($count), 'notifications'=>$data];

        return response()->json($notifications);
    }

    public function getMessages(){
        $messages = Message::where('to_id', Auth::user()->id)->where('read_status', 0)->get();
        return response()->json($messages);
    }

    public function getConversation($id){
        $conversation = Conversation::find($id);
        
        if($conversation){
            $recepient_id = $conversation->to_id == Auth::user()->id ? $conversation->from_id : $conversation->to_id;

            $recepient = User::find($recepient_id);

            if(!$recepient){
                
                return response()->json(['code'=>404,'message'=>'Recepient not found']);
            }
            
            if(count($conversation->messages()->where('read_status',0)->where('to_id',Auth::user()->id)->get())){
                $messages = $conversation->messages()->orderBy('created_at','ASC')->get();
                $messageString = '';
                
                foreach($messages as $message){
                    $message->read_status = 1;
                    $message->update();

                    if($message->from_id == Auth::user()->id && $message->to_id == $recepient->id){
                        $sen_image = empty(Auth::user()->image) ? asset('images/new-user.png') : asset('images/uploads/' . Auth::user()->image);
                        $messageString .= '
                        
                        <div class="inner-grey margin-b-20">
                            <div class="row">
                                <div class = "col-xs-11 text-right">
                                    <p><strong>me</strong></p>
                                    <p>'. clean($message->message) .'</p>
                                    <small><span class = "pull-left">'. $message->created_at->diffForHumans() .'</span></small>
                                </div>  
                                
                                <div class="col-xs-1">
                                    <img class = "img-responsive img-circle" src="'. $sen_image .'" alt="'. Auth::user()->username .'">
                                </div>

                            </div>  
                        </div>';
                    }
                    
                    elseif($message->from_id == $recepient->id && $message->to_id == Auth::user()->id){
                        $rec_image =empty($recepient->image) ? asset('images/new-user.png') : asset('images/uploads/' . $recepient->image);
                        $messageString .= '
                        
                        <div class="inner-grey margin-b-20" style = "background-color: rgba(0,0,255,0.1)">
                            <div class="row">
                                <div class="col-xs-1">
                                    <img class = "img-responsive img-circle" src="'. $rec_image .'" alt="'. $recepient->username .'">
                                </div>

                                <div class = "col-xs-11">
                                    <p><strong style = "margin-right:15px">'. $recepient->name .'</strong></p>
                                    <p>'. clean($message->message) .'</p>
                                    <small><span class = "pull-right">'. $message->created_at->diffForHumans() .'</span></small>
                                </div>  
                            </div>  
                        </div>';
                    }
                }

                die($messageString);

                return $messageString;
            }
            
        }

        return 'false';
    }

    public function getBlockedPage(){
        return view('pages.blocked-account');
    }

    public function getInactivePage(){
        return view('pages.inactive-account');
    }
}
