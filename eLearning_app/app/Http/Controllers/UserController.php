<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;

use Auth;
use App\User;
use App\Lesson;

class UserController extends Controller
{
    public function showUsers() {
        $users = User::where("id" , "!=" , Auth::user()->id)->paginate(10);

        return view('users.index', compact('users'));
    }

    public function edit($id) {
        $user = User::find($id);

        return view('users.editUser', compact('user'));
    }

    public function editStore($id)
    {
        request()->validate([
            'name' => ['required', 'max:255', 'unique:users,name,'.auth()->user()->id],
            'email' => ['required', 'max:255', 'unique:users,email,'.auth()->user()->id],
        ]);

        if(request()->avatar) {
            request()->validate([
                'avatar' => ['file', 'image', 'mimes:jpeg,png'],
            ]);
            $image = request()->file('avatar');
            $file = $image->getClientOriginalName();
            $image->storeAs('public/images' , $file);
            $user = Auth::user()->update([
                'avatar' => '/storage/images/'.$file,
            ]);
        }

        $user = Auth::user()->update([
            'name' => request()->name,
            'email' => request()->email,
        ]);

        return redirect('home');
    }

    public function showFollowing(){
        $users = Auth::user()->following()->paginate(10);

        return view('users.followinglist', compact('users'));
    }

    public function showFollowers(){
        $users = Auth::user()->followers()->paginate(10);
        return view('users.followerslist', compact('users'));
    }

    public function showOtherUserFollowing($id){
        $users = User::find($id)->following()->paginate(10);

        return view('users.followinglistOther', compact('users'));
    }

    public function showOtherUserFollowers($id){
        $users = User::find($id)->followers()->paginate(10);
        return view('users.followerslistOther', compact('users'));
    }

    public function changePassword($id) {
        $user = User::find($id);

        return view('users.changePassword', compact('user'));
    }

    public function passwordStore($id , MessageBag $message_bag)
    {
        request()->validate([
            // confirmed check the password and password_confirmation
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        if(Hash::check(request()->current_password, Auth::user()->password)){
            Auth::user()->update([
                'password' => Hash::make(request()->password)
            ]);
        } else {
            $message_bag->add("password" ,"Incorrect Password");
            return back()->withErrors($message_bag);
        }
            

        return redirect('home');
    }

    public function showUser($id)
    {     
        $user = User::find($id);
        $lessons = Lesson::paginate(3);
        
        return view('home', compact('user', 'lessons'));
        
    }

    public function follow($id) {
        Auth::user()->following()->attach($id);

        return redirect()->back();
    }

    public function unfollow($id) {
        Auth::user()->following()->detach($id);

        return redirect()->back();
    }
}
