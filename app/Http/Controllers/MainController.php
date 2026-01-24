<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Attendence;
use Carbon\Carbon;
class MainController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function validate(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        
        if(Auth::attempt(['email'=>$email,'password'=>$password]))
        {
            return redirect()->route('dashboard');
        }
        else
        {
            return back()->with('error','Invalid Email or Password');
        }
    }
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
    public function attendence(Request $request)
    {
        $fingerprint = $request->input('fingerprint');
        $attendence = Attendence::whereRelation('user','id',$fingerprint)->whereDate('created_at',Carbon::today()->toDateString())->first();
        $users = User::where('id',$fingerprint)->first();
        if(!$users)
        {
            return response()->json([
                'status' => 'Not Found',
                'message' => 'User Not Found',
            ]);

        }
        if(!$attendence)
        {
            $attendences = new Attendence();
            $attendences->user_id = $users->id;
            $attendences->enter_time = Carbon::now()->toTimeString();
            $attendences->exit_time = '00:00:00';
            $attendences->attendence_status = 'Present';
            $attendences->save();
            return response()->json([
                'status' => 'ok',
                'message' => 'Attendance marked',
                'user' => $users->name
            ]);

        }
        else
        {
            if($attendence->enter_time == '00:00:00')
            {
                $attendence->enter_time = Carbon::now()->toTimeString();
                $attendence->attendence_status = 'Present';
                $attendence->save();
            }
            else
            {
                $attendence->exit_time = Carbon::now()->toTimeString();
                $attendence->attendence_status = 'Present';
                $attendence->save();
            }
            return response()->json([
                'status' => 'ok',
                'message' => 'Attendance marked',
                'user' => $users->name
            ]);
        }
    }
}
