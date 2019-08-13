<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use App\User;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    public function subscribe_process(Request $request)
    {
        try {
            Stripe::setApiKey('sk_test_pVUxs7fuQ3MbjMDt6ZYPtlq100yl4Yjf1i');

            $id = Auth::id();//user_id取得
            $user = User::find($id);
            $user->newSubscription('main', 'plan_FbjLxUIWL3H5Y8')->create($request->stripeToken);

            return back();
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function subscribe_cancel(Request $request)//キャンセル用
    {
        try {
            Stripe::setApiKey('sk_test_pVUxs7fuQ3MbjMDt6ZYPtlq100yl4Yjf1i');

            $id = Auth::id();//user_id取得
            $user = User::find($id);
//            すぐにキャンセル
            $user->subscription('main')->cancelNow();

            return 'Cancel successful';
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

    }
}
