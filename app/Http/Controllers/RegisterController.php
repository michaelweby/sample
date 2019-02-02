<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 6/15/2018
 * Time: 2:22 AM
 */

namespace App\Http\Controllers;


use App\Http\Controllers\Transformers\UserTransformer;
use App\Http\Requests\UserRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\ActivationService;

class RegisterController extends ApiController
{
    protected $userTransformer;

    protected $activationService;


    /**
     * LoginController constructor.
     * @param $userTransformer
     */
    public function __construct(UserTransformer $userTransformer,ActivationService $activationService)
    {
        $this->userTransformer = $userTransformer;
        $this->activationService = $activationService;
    }

    public function create(Request $request)
    {
        $request = json_decode($request->getContent(),true);
        $validation = Validator::make($request,[
            'email' => 'required|unique:users|email',
            'username' => 'required|unique:users',
            'phone' => 'required',
            'password' => 'required|confirmed',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        if ($validation->fails()){
            return $this->responseWrongValidation($validation->errors()->all());
        }
        $user = User::create([
            'username'=>$request['username'],
            'password'=>bcrypt($request['password']),
            'first_name'=>$request['first_name'],
            'last_name'=>$request['last_name'],
            'phone'=>$request['phone'],
            'email'=>$request['email'],
            'gender'=>$request['gender'],
            'birthday'=>new Carbon($request['birthday']),
            'type'=>'customer',
            'activated'=>1
        ]);
        $this->activationService->sendActivationMail($user);
        return $this->responseDone($this->userTransformer->transform($user));

    }
    public function socialCreate(Request $request)
    {
        $request = json_decode($request->getContent(),true);
        $social = $request['social_type']=='facebook'?'facebook_id':'google_id';
        $validation = Validator::make(
            $request,[
            'email' => 'required|unique:users|email',
            'phone' => 'required',
            'password' => 'required|confirmed',
            'first_name' => 'required',
            'last_name' => 'required',
            'social_id'=>'required',
        ]);

        if ($validation->fails()){
            return $this->responseWrongValidation($validation->errors()->all());
        }
        $username = str_slug($request['first_name'].'-'.$request['last_name'],'-');
        if(User::where('username',$username)->count()){
            $username = $username.rand(0000,9999);
        }
        $user = User::create([
            'username'=>$username,
            'password'=>bcrypt($request['password']),
            'first_name'=>$request['first_name'],
            'last_name'=>$request['last_name'],
            'phone'=>$request['phone'],
            'gender'=>@$request['gender'],
            'image'=>@$request['image'],
            'birthday'=>new Carbon(@$request['birthday']),
            'email'=>$request['email'],
            'type'=>'customer',
            "$social"=>$request['social_id'],
            'activated'=>1
        ]);
        $this->activationService->sendActivationMail($user);
        return $this->responseDone($this->userTransformer->transform($user));
    }

    public function signUp(Request $request){
        $validation = Validator::make($request->all(),[
            'email' => 'required|unique:users|email',
            'username' => 'required|unique:users',
            'phone' => 'required',
            'password' => 'required|confirmed',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
        if ($validation->fails()){

            return redirect('sign?target=signup')->with('errors',$validation->errors()->all());
        }
        $user = User::create([
            'username'=>$request['username'],
            'password'=>bcrypt($request['password']),
            'first_name'=>$request['first_name'],
            'last_name'=>$request['last_name'],
            'phone'=>$request['phone'],
            'email'=>$request['email'],
            'gender'=>$request['gender'],
            'birthday'=>new Carbon($request['birthday']),
            'type'=>'customer',
        ]);
//        $this->activationService->sendActivationMail($user);
        \auth()->loginUsingId($user->id);
        return redirect('/');
    }
}