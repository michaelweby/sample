<?php
/**
 * Created by Michael.
 * Date: 6/15/2018
 * Time: 1:00 AM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends ApiController
{
    protected $userTransformer;

    /**
     * LoginController constructor.
     * @param $userTransformer
     */
    public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    public function login(Request $request){
        $request = json_decode($request->getContent());
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (auth()->attempt([$field=>$request->login,'password'=>$request->password]) and auth()->user()->activated){
            return $this->responseSuccess($this->userTransformer->transform(auth()->user()));
        }
        if (!auth()->guest()){
            if(!auth()->user()->activated){
                return $this->responseWrongData('User dosn\'t verified his mail yet');
            }
        }

        return $this->responseWrongData('User or Password you entered is invalid');
    }

    public function socialLogin(Request $request){
        $request = json_decode($request->getContent());

        $id = $request->social_type == 'facebook'?'facebook_id':'google_id';
        if ( $user = User::where($id,$request->social_id)->first() ){
            if(Hash::check($request->password,$user->password)){
                return $this->responseSuccess($this->userTransformer->transform($user));
            }
            return $this->responseWithError('unauthenticated User');
        }
        return $this->responseWithError('ID you sent is not registered yet');
    }
    public function signIn(Request $request){
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (auth()->attempt([$field=>$request->login,'password'=>$request->password]) and auth()->user()->activated){
          return redirect('/');
        }
        if (!auth()->guest()){
            if(!auth()->user()->activated){
                return redirect('sign')->with('error','\'User dosn\'t verified his mail yet');
            }
        }
        return redirect('sign')->with('error','User or Password you entered is invalid');
    }
    public function logout(){
        if (auth()->check()) {
            auth()->user()->AauthAcessToken()->delete();
        }
    }
}