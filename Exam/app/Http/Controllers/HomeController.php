<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Registration_requests;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['applications_get','applications_post']);;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$ipAddr=\request()->ip();
        $user = Auth::user();
        $isAdmin=$user->is_admin;
        if ($isAdmin)
        {
            $tasks=Task::all();
            return view('adminHome',compact('tasks'));
        }
        $tasks = Task::select('id','title','start_date', 'end_date')
            ->where('user_id', $user->id)
            ->where('status',0)
            ->get();
        return view('home',compact('tasks'));
    }
    public function applications_get()
    {
        return view('applicationForm');
    }
    public function add_task_form()
    {
        $emails= User::select('email')->get();
        return view('addTask', compact('emails'));
    }
    public function applications_show()
    {
        $user = Auth::user();
        $isAdmin=$user->is_admin;
        if ($isAdmin)
        {
            $registration_requests=Registration_requests::all();
            return view('applications', compact('registration_requests'));
        }
        return redirect()->route('home');
    }
    public function applications_post(Request $request)
    {
// `/u` использовалось для работы с юникодными символами. Оно указывает на использование модификатора `u`, который позволяет обрабатывать символы Юникода в строках.
     $request->validate([
            'firstname' => ['required', 'string', 'regex:/^[A-ZА-ЯЁ][a-zа-яё]+$/u'],
            'lastname' => ['required', 'string', 'regex:/^[A-ZА-ЯЁ][a-zа-яё]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'message' => ['nullable', 'regex:/^[-a-zA-Zа-яА-ЯёЁ0-9 .,!?]+$/u'],
        ],[
            'firstname.regex' => 'The first name field must start with a capital letter and contain only letters.',
            'lastname.regex' => 'The last name field must start with a capital letter and contain only letters.',
            'message.regex' => 'The message field must only contain letters, numbers, and punctuation marks.',
        ]);

        $registration_requests = new Registration_requests();
        $registration_requests->firstname = $request->firstname;
        $registration_requests->lastname = $request->lastname;
        $registration_requests->email = $request->email;
        $registration_requests->message = $request->message;
        $registration_requests->save();
        return view('auth/login');
    }

    public function create_task(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string','regex:/^[a-zA-Z0-9]+(_[a-zA-Z0-9]+)*$/'],
            'start_date' => ['required', 'date', 'after_or_equal:' . Carbon::now()->format('Y-m-d'),],
            'end_date' => ['required', 'date', 'after_or_equal:start_date',]
        ]);
        $user = Auth::user();
        $isAdmin=$user->is_admin;
        if ($isAdmin){
            $user_id = User::where('email', $request->email)->value('id');
            $task = new Task;
            $task->title = $request->title;
            $task->user_id = $user_id;
            $task->start_date = $request->start_date;
            $task->end_date = $request->end_date;
            $task->save();
        }
        else{
            $task = new Task;
            $task->title = $request->title;
            $task->user_id = $user->id;
            $task->start_date = $request->start_date;
            $task->end_date = $request->end_date;
            $task->save();
        }
        return redirect()->route("home");
    }

    public function register_form($id)
    {
        $user = Auth::user();
        $isAdmin=$user->is_admin;
        if ($isAdmin)
        {
            $registration_request = Registration_requests::find($id);
            return view('auth/register',compact('registration_request'));
        }
        return redirect()->route('home');
    }
    public function edit($id)
    {
        $task = Task::find($id);
        $emails= User::select('id','email')->get();
        return view('editTask', ['task' => $task,'emails' => $emails]);
    }
    public function create_employee(Request $request)
    {
        $user = Auth::user();
        $isAdmin=$user->is_admin;
        if ($isAdmin)
        {
            $user = new User();
            $user->firstName = $request->firstname;
            $user->lastName = $request->lastname;
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->password = bcrypt($request->password);
            $user->remember_token = null;
            $user->save();

            $registration_request = Registration_requests::find($request->id);
            $registration_request->delete();
        }
        return redirect()->route('home');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
        'title' => ['required', 'string','regex:/^[a-zA-Z0-9]+(_[a-zA-Z0-9]+)*$/'],
        'start_date' => ['required', 'date'],
        'end_date' => ['required', 'date', 'after_or_equal:start_date',]
        ]);
        $user = Auth::user();
        $isAdmin=$user->is_admin;
        if ($isAdmin){
            $user_id = User::where('email', $request->email)->value('id');
            $task = Task::find($id);
            $task->title = $request->title;
            $task->user_id = $user_id;
            $task->start_date = $request->start_date;
            $task->end_date = $request->end_date;
            $task->status =  (bool)$request->status;
            $task->save();
        }
        else{
            $task = Task::find($id);
            $task->title = $request->title;
            $task->start_date = $request->start_date;
            $task->end_date = $request->end_date;
            $task->status =  (bool)$request->status;
            $task->save();
        }
        return redirect()->route('home');
    }
    public function delete_task($id)
    {
        $user = Auth::user();
        $isAdmin=$user->is_admin;
        if ($isAdmin)
        {
            $task = Task::find($id);
            $task->delete();

        }
        return redirect()->route('home');
    }
    public function employees()
    {
        $user = Auth::user();
        $isAdmin=$user->is_admin;
        if ($isAdmin)
        {
            $employees = User::select('id','lastname', 'firstname', 'email')
                ->where('id', '!=',  Auth::id())
                ->get();
            return view('employee', compact('employees'));
        }
        return redirect()->route('home');
    }
    public function delete_employee($id)
    {
        $user = Auth::user();
        $isAdmin=$user->is_admin;
        if ($isAdmin)
        {
            $user = User::find($id);
            $user->delete();

        }
        return redirect()->route('home');
    }
}
