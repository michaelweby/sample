<?php

namespace App\Http\Controllers;

use App\Mail\SubscribeConfirm;
use App\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(){
        $subscribers = Subscriber::paginate(50);
        return view('admin.subscribers.index',['title'=>'Subscriber','subscribers'=>$subscribers]);
    }
    protected function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    public function add(Request $request){
        $token = $this->getToken();
        if (Subscriber::where('mail',$request->email)->count() == 0){
            Subscriber::create([
                'mail'=>$request->email,
                'token'=>$token,
            ]);
            \Mail::to($request->email)->send(new SubscribeConfirm($token));

            return 'added';
        }
        \Mail::to($request->email)->send(new SubscribeConfirm($token));
       return 'exist';
    }
    public function confirm($token){
        $subscriber = Subscriber::where('token',$token)->first();
        if($subscriber){

            $subscriber->confirmed = 1;
            $subscriber->save();
        }
        return redirect('/');
    }

    public function destroy(Subscriber $subscriber){
        $subscriber->delete();
        return back();
    }
}
