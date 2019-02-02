<?php

namespace App\Http\Controllers;

use App\ActivationService;
use App\Shop;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;


class UserController extends ApiController
{
    public $title = 'User';

    protected $activationService;

    /**
     * UserController constructor.
     * @param $activationService
     */
    public function __construct(ActivationService $activationService)
    {
        $this->activationService = $activationService;
    }


    public function index($type=null){
        if ($type)
            $users  = User::where('type',$type)->paginate(15);
        else
            $users  = User::paginate(15);

        return view('admin.users.index',
            ['admins' => $users,
            'type'=>$type,
            'title' => $this->title]);
    }

    public function create(){
        return view('admin.users.create',['title' => $this->title]);
    }

    public function store(UserRequest $request){
//        dd($request->all());

        if($request->type == 'vendor') {
            $this->validate($request, [
                'shop_title' => 'required|string|max:191',
                'logo' => 'image|nullable',
//                'shop_address' => 'required|string|max:191',
                'bank_account_number' => 'numeric|nullable',
                'bank_account_name' => 'string|max:191||nullable',
                'commission_value' => 'numeric|nullable',
                'commission_type' => 'required',

            ]);
        }
        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone= $request->phone;
        $user->address= $request->address;
        $user->type= $request->type;
        $user->gender= $request->gender;
        $user->birthday= new Carbon($request->birthday);
        $user->password= bcrypt($request->password);
        $user->save();

        if($request->type == 'vendor') {
            $shop = new Shop();
            $shop->title = $request->shop_title;
            if($request->hasFile('logo'))
                $shop->logo = app('help')->help($request->logo);
            else
                $shop->logo='uploads/default.png';
            $shop->address = $request->shop_address;
            $shop->phone = $request->shop_phone;
            $shop->bank_account_name = $request->bank_account_name;
            $shop->bank_account_number = $request->bank_account_number;
            $shop->fixed = $request->commission_type;
            $shop->commission = $shop->fixed?$request->commission_value:0;
            $shop->owner_id = $user->id;
            $shop->description = $request->description;
            if ($request->has('elite')){
                $shop->elite = 1;
            }
            $shop->save();

        }
        return redirect(PATH.'/users');

    }

    public function edit(User $user){
        return view('admin.users.edit',['title' => $this->title,'user'=>$user]);
    }

    public function update(User $user,Request $request){
        $this->validate($request,[
            'email' => 'required|email|unique:users,email,'.$user->id,
            'username'=>'required|unique:users,username,'.$user->id,
            'phone'=>'required',
            'password'=>'confirmed',
            'first_name'=>'required',
            'last_name'=>'required',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone= $request->phone;
        $user->address= $request->address;
        $user->type= $request->type;
        if ($request->has('password')){
            $user->password= bcrypt($request->password);
        }
        $user->save();
        return redirect(PATH.'/users');
    }

    // if user is a vendor delete his shop
    public function destroy(User $user){
        if ($user->type == 'vendor'){
            $user->shop()->delete();
        }
        $user->delete();
        return back();
    }

    // check the username and password and redirect each user as there type
    public function checkLogin(Request $request){
        $field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (auth()->attempt([$field=>$request->login,'password'=>$request->password])){
            if (auth()->user()->type == 'admin'){
                return redirect(PATH.'/');
            }elseif (auth()->user()->type == 'customer'){
                return redirect('/');
            }elseif (auth()->user()->type == 'vendor'){
                return redirect(PATH.'/vendor/'.auth()->user()->id);
            }
        }else{
            return redirect(PATH.'/login');
        }
    }

    public function show(User $user){
        return view('admin.users.show',['title'=>$this->title,'user'=>$user]);
    }


    public function update_image(Request $request){
        $image = url('/').'/'.app('help')->help($request->image);
        auth()->user()->image =$image;
        auth()->user()->save();
        return $this->responseSuccess(['image'=>auth()->user()->image]);
    }

    //
    public function logout(){
        auth()->logout();
        return redirect(PATH.'login');
    }
    public function logoutWeb(){
        auth()->logout();
        return redirect('/');
    }

    //function to check if the value is unique as the column sent
    public static function checkUsername(Request $request){
        return $unique = User::isUnique($request->column,$request->value);
    }

    public function activateUser($token)
    {
        if ($user = $this->activationService->activateUser($token)) {
            auth()->login($user);
            return response()->json('Your account has been active');
        }
        abort(404);
    }

    public function personalInfo(){
        $user = auth()->user();
        return [
            'first_name'=>$user->first_name,
            'last_name'=>$user->last_name,
            'address'=>$user->address,
            'phone'=>$user->phone,
            'email'=>$user->email,
            'image'=>$user->image,
        ];
    }
    public function editPersonalInfo(Request $request){
        $request = json_decode($request->getContent());
        auth()->user()->first_name = $request->first_name;
        auth()->user()->last_name = $request->last_name;
        auth()->user()->address = $request->address;
        auth()->user()->phone = $request->phone;
        auth()->user()->email = $request->email;
        auth()->user()->save();
        $user = auth()->user();
        return $this->responseSuccess([
            'first_name'=>$user->first_name,
            'last_name'=>$user->last_name,
            'address'=>$user->address,
            'phone'=>$user->phone,
            'email'=>$user->email,
            'image'=>$user->image,
        ]);
    }

    public function updatePersonal(Request $request){
//        dd($request->all());
        $validator = $this->validate($request, [
            'email' => 'required|email|unique:users,email,'.auth()->id(),
            'phone'=>'required',
            'password'=>'confirmed',
            'first_name'=>'required',
            'last_name'=>'required',
            'gender' => 'required',
            'birthday' => 'required',
            ]);

        auth()->user()->first_name = $request->first_name;
        auth()->user()->last_name = $request->last_name;
        auth()->user()->address = $request->address;
        auth()->user()->phone = $request->phone;
        auth()->user()->email = $request->email;
        auth()->user()->gender = $request->gender;
        auth()->user()->birthday = new Carbon($request->all()['birthday']);
        if ($request->has('image')){
            auth()->user()->image = app('help')->help($request->image);
        }
        if ($request->password != null){
            auth()->user()->password = bcrypt($request->password);
        }
        auth()->user()->save();
        return redirect('/');
    }
}
