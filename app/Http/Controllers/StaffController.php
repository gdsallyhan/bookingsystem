<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use File;
use Image;


class StaffController extends Controller
{

    /**
     * Create a new controller instance.
     */
     public function __construct()
    {
        $this->middleware('auth'); //sapa nak excesss controlrer  kene login in dulu  kene letak dlm controller
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        if($request->has('search')){


            $users = User::where('name','like','%'.$request->search. '%')
                                ->orWhere('email','like','%'.$request->search. '%')
                                ->orderBy('name', 'ASC')
                                ->paginate(15);
                                
            $users->appends($request->all());

        return view('staff_index',compact('users'));

        }else{

             $users =User::orderBy('name', 'ASC')
                            ->paginate(15);
                            
        }

        // dd($users);

        return view('staff_index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staff = new User;
        return view('staff_form', compact('staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //nakbuat validation
    {
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',


        ]);

        $user = new User;

        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        

        $user->save();

        // return redirect()->route('staff.index');
        // return view('staff_form', compact('staff'),['successMsg' => 'Staff is successfully created']);

        return redirect()->route('staff.create',['successMsg' => 'Staff is successfully created']);

     

    }

    /**
     * upload the avatar image.
     */
    public function getAvatar()
    {
        return User::where('avatar', Auth::users()->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $staff)
    {
        //dd($staff);
         return view('staff_form', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $staff)
    {
        //dd($request);
         $this->validate($request, [
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$staff->id,
            'password'=>'nullable|min:6',
            'avatar'=>'nullable',

        ]);


        $staff->name = $request['name'];
        $staff->email = $request['email'];
        if($request['password']){
        $staff->password = bcrypt($request['password']);
        }

         if($request->hasFile('avatar')){

            $image = $request->file('avatar');

            $directory = $_SERVER['DOCUMENT_ROOT']. "/uploads/profile_picture";
                if(!file_exists($directory)){
                    mkdir($directory, 0755, true);    
                }

                $file_name = "id_".$staff->id."_".time().".".$image->getClientOriginalExtension();
                $image_resize = Image::make($image->getRealPath())->fit(400,400, function ($constraint) {
                $constraint->aspectRatio(); })->save($directory.'/'.$file_name);
                // $image->move($directory,$file_name);
                $staff->avatar = "uploads/profile_picture/" .$file_name;
         }
        
            
        $staff->save();

        // return view('staff_form', compact('staff'));

         return view('staff_form', compact('staff'),['successMsg' => 'Staff details is updated']);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $staff)
    {
        $staff->delete();
         return redirect()->route('staff.index');
     }
}


   

