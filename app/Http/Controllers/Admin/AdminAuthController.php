<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Auth;
use Illuminate\Http\Request;
use Validator;

class AdminAuthController extends Controller
{
    public function index(Request $request)
    {
        $DataBag = array();
        return view('admin.auth.login', $DataBag);
    }

    public function loginAction(Request $request)
    {
        $requestData = $request->all();
        $validation['rules'] = [
            'username_email' => ['required'],
            'password' => ['required'],
        ];
        $validation['messages'] = [
            'username_email.required' => 'Please enter username or email.',
            'password.required' => 'Please enter password.',
        ];
        $validator = Validator::make($requestData, $validation['rules'], $validation['messages']);
        if ($validator->fails()) {
            return back()->withErrors($validator, 'validationErrors')
                ->withInput()
                ->with('msg', 'Login validation failed. Please enter email or username with password.')
                ->with('msg_class', 'alert alert-danger')
                ->with('msg_title', 'Validation Error');
        }

        if (Auth::guard('admin')->attempt(['email' => $requestData['username_email'], 'password' => $requestData['password']])) {
            $admin = Auth::guard('admin')->user();
            $status = $admin->status;
            if ($status == 1) {
                $this->setCookie($requestData);
                return redirect()->intended(route('admin.account.dashboard.index'));
            } elseif ($status == 2) {
                Auth::guard('admin')->logout();
                return back()
                    ->withInput()
                    ->with('msg', 'Sorry! Your account is temporary blocked by Administrator. Please contact to Administrator.')
                    ->with('msg_class', 'alert alert-danger')
                    ->with('msg_title', 'Account Blocked!');
            } elseif ($status == 0) {
                Auth::guard('admin')->logout();
                return back()
                    ->withInput()
                    ->with('msg', 'Sorry! Your account is inactive. Please contact to Administrator.')
                    ->with('msg_class', 'alert alert-danger')
                    ->with('msg_title', 'Account Inactive!');
            } else {
                Auth::guard('admin')->logout();
                return back()
                    ->with('msg', 'Sorry! Your account is permanently closed by Administrator . Please contact to Administrator.')
                    ->with('msg_class', 'alert alert-danger')
                    ->with('msg_title', 'Account Closed!');
            }
        }

        if (Auth::guard('admin')->attempt(['username' => $requestData['username_email'], 'password' => $requestData['password']])) {
            $admin = Auth::guard('admin')->user();
            $status = $admin->status;
            if ($status == 1) {
                $this->setCookie($requestData);
                return redirect()->intended(route('admin.account.dashboard.index'));
            } elseif ($status == 2) {
                Auth::guard('admin')->logout();
                return back()
                    ->withInput()
                    ->with('msg', 'Sorry! Your account is temporary blocked by Administrator. Please contact to Administrator.')
                    ->with('msg_class', 'alert alert-danger')
                    ->with('msg_title', 'Account Blocked!');
            } elseif ($status == 0) {
                Auth::guard('admin')->logout();
                return back()
                    ->withInput()
                    ->with('msg', 'Sorry! Your account is inactive. Please contact to Administrator.')
                    ->with('msg_class', 'alert alert-danger')
                    ->with('msg_title', 'Account Inactive!');
            } else {
                Auth::guard('admin')->logout();
                return back()
                    ->with('msg', 'Sorry! Your account is permanently closed by Administrator . Please contact to Administrator.')
                    ->with('msg_class', 'alert alert-danger')
                    ->with('msg_title', 'Account Closed!');
            }
        }

        return back()
            ->withInput()
            ->with('msg', 'Login failed due to incorrect credentials.')
            ->with('msg_class', 'alert alert-danger')
            ->with('msg_title', 'Authentication Error');
    }

    public function setCookie($requestData)
    {
        if (isset($requestData['remember_me']) && $requestData['remember_me'] == 1) {
            setcookie("brainStormAdminEmail", $requestData['username_email'], time() + (86400 * 30 * 30), "/");
            setcookie("brainStormAdminPassword", $requestData['password'], time() + (86400 * 30 * 30), "/");
        }
        if (!isset($requestData['remember_me'])) {
            setcookie("brainStormAdminEmail", "", time() - 3600, "/");
            setcookie("brainStormAdminPassword", "", time() - 3600, "/");
            unset($_COOKIE['brainStormAdminEmail']);
            unset($_COOKIE['brainStormAdminPassword']);
        }
    }
}
