<?php
namespace App\Classes;

use App\Models\User;
use App\Models\verify_user;
use Illuminate\Support\Str;
use App\Models\password_reset;
use App\Traits\comman;

use Validator;
use Session;
use Auth;
use Mail;

class custom_auth
{
    use comman;
    public function signup($request)
    {
        //validation
        //$request should have vars =>  name , email , phone , password , britday , gender

        //return $request;

        $rules = [
            'name' => 'required|max:20' ,
            //'first_name' => 'required|max:20' ,
            //'last_name' => 'required|max:20' ,
            'email' => 'required|email|unique:users,email' ,
            'phone' => 'required|max:11|min:11|unique:users,phone_number',
            'password' => 'required|confirmed|min:8|max:25',
            'birthday' => 'required' ,
            //'gender'   => 'required' ,
            
        ];
        $error_massage = [
            'name.required' => 'Name Required',
            'name.max' => 'Name Long Enter Smiliest First Name',
            //'first_name.required' => 'First Name Required',
            //'first_name.max' => 'First Name Long Enter Smiliest First Name',
            //'last_name.required' => 'Last Name Required',
            //'last_name.max' => 'Last Name Long Enter Smiliest Last Name',
            'email.required' => 'Email Required' ,
            'email.email' => ' Invaild Email' ,
            'email.unique' => 'This Email Used By Another User' ,
            'phone.required' => 'Phone Number  Required' ,
            'phone.min' => 'Phone Number  Must Be 11 Number' ,
            'phone.max' => 'Phone Number  Must Be 11 Number' ,
            'phone.unique' => 'Phone Number  Used By Another User' ,
            'birthday.required' => 'Birthday  Required' ,
            'password.required'   => 'Password Required' ,
            'password.min'   => 'Password must be atleast 8 charactiers' ,
            'password.max'   => 'Password Too Long Enter Smail Password' ,
            'password.confirmed'   => 'Password And Repassword Does Not Matched' 
           // 'gender.required' => 'Gender Required', //this will not be run 
        ];

        $valid = Validator::make($request->all(),$rules , $error_massage);

        
        if($valid->fails())
        {

            return redirect()->back()->withErrors($valid)->with([
                'name' => $request->name ,
                'email' => $request->email ,
                'phone' => $request->phone ,
                'birthday' => $request->birthday 
                //'gender'   => $request->gender  
              ]); 
        }
        
        else
        {
           
            //sql accept date colum on format yy-mm-dd
            $data =  explode('/', $request->birthday);
            $day = $data[0];
            $month = $data[1];
            $yaer = $data[2];
            
            $date =  $yaer . "-" . $month . "-" . $day ;

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone;
            $user->password = bcrypt($request->password);
            $user->birthday = $date ;
            $user->save();

            //to be auth user
            Auth::login($user);

          
            $id= Auth::id();
            $email = $request->email;
            $name = $request->name;
            //send verfication code
            $this->send_verfication_code($id ,$name, $email);

            
            $notification = "Welcome " . $request->name . " to Connecto ." ;
            $this-send_notification($notification , Auth::id());


            return "done";
        }



        
    }
    public function login($request)
    {
       
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $credentials = $request->only(['email', 'password']);


            //remember me option
            $remember_me = true;
            if($request->has('remember_me'))
            {
                $remember_me = true;
            }
            else
            {
                $remember_me = false;
            }            
            if (Auth::attempt($credentials , $remember_me)) {

                
                $notification = "Welcome Back " . $this->get_name(Auth::id()) . " to Connecto ." ;
                $this->send_notification($notification , Auth::id());

                $request->session()->regenerate();
     
                return redirect()->intended('');

               //$token = Auth::guard('web')->attempt($credentials);
                
              
            }
            else
            {
                return back()->withErrors([
                    'error' => 'Email And Password do not match our records.',
                ])->onlyInput('email');
            }
            
            
           
    }
    public function logout($request) 
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
    public function verify_email($token)
    {
        $v_user = verify_user::select('user_id' , 'token')
                            ->where('token', '=' , $token)
                            ->get();

        //return $v_user->user_id;

        
        if( count ($v_user) == 1 ) 
        {
            
            //update colum in users table email_verified_at 
            //$user = $v_user->user();
            $user = User::find($v_user[0]->user_id);

            

            if($user == null)
            {
                return redirect('/login');
            }
            else
            {
                
                if($user->email_verified_at == null)
                {
                    $user->email_verified_at = now();
                    $user->save();
                    return redirect('/home');
    
                }
                else
                {
                    //email verified and he clicked the link again so we will redirect him to home and if he not auth he will be redirected to login
                    return redirect('/home');
                }
            }
           
           
            
        }
        else
        {
            //here user try token so we will redirect him to login form
            return redirect('/login');
        }
    }

    private function send_verfication_code($id ,$name, $email)
    {
        //first we will store v code in database and we will send mail 
        $token = Str::random(64); //create token or (verfication code)


        $v_user = new verify_user();
        $v_user->user_id =$id;//we will use this function after auth::login in register function
        $v_user->token = $token;
        $v_user->save();

        $link = url('/register/verify_email/' . $token);
        
        Mail::to($email)->send(new \App\Mail\verfication_code( "Connecto Email Verfication" , "Welcome " . $name ,  $link ));

        
    }
    private function dif_b_dates($date1 , $date2)
    {
       $date1 = explode('-', $date1);
       $date2 = explode('-', $date2);
       $d_year = $date1[0] - $data2[0]; // year الفرق بين السنين بين التاريخين
       $d_month = $date[1] - $date2[1]; // month
       $d_day = $date[2] - $date2[2]; // day


    }

    public function send_forget_mail($email)
    {
        //first check that the email that user entered found in database
        $user_data = User::select('name' , 'email')->where('email' , $email)->get();
        if(count($user_data) > 0)//that meanning the email founded in database
        {
            //first we will store token random code in database and we will send mail 
            $token = Str::random(64); //create token 


            //we will check if user try forget password option or not
            //so we will search about his email in database

            $user = password_reset::select('email' , 'vaild' , 'updated_at')->where('email' , $email)->get();
            if(count($user) > 0)
            {
                //here user tried this option in  past
                //so we will update token that he used and update vaildation of token
                //but before update token and vaildation of token we will check the date of last update (updated_at)
                //if any difference between updated_at and date now so send mail and if equal do not sent mail and do not update any thing tell him to see emails

                $date = $user[0]->updated_at->toDateString();
                $date_now = date('Y-m-d');
                if($date == $date_now && $user[0]->vaild == "vaild")//handle customer hhhhhhh
                {
                    return "Email Sent  Check Your Inbox or maybe in spam folder";
                }
                password_reset::where('email' , $email)->update(['token' => $token , 'vaild' => "vaild"]);
            } 
            else
            {
                $pass_r= new password_reset();
                $pass_r->email = $email;
                $pass_r->token = $token;
                $pass_r->vaild = "vaild";
                $pass_r->save();
            }
            //finally we will send mail

            $link = url('/forget_password/' . $token);
            
            Mail::to($email)->send(new \App\Mail\forget_password( "Connecto " , "Welcome " . $user_data[0]->name ,  $link ));

            return "We Just Send You An Email Please Check Your Inbox";
        }
        else
        {
            return "Email Does Not Match With Our Records You Are Sure that you have Acount if Not Register now";
        }

    }
    public function go_to_reset($token)
    {
        
    }
    public function reset_password($request)
    {
        $rules = [
            'password' => 'required|confirmed|min:8|max:25',
            'token'    => 'required',
        ];

        $error_massage = [
            'password.required'   => 'Password Required' ,
            'password.min'   => 'Password must be atleast 8 charactiers' ,
            'password.max'   => 'Password Too Long Enter Smail Password' ,
            'password.confirmed'   => 'Password And Repassword Does Not Matched' 
        ];

        $valid = Validator::make($request->all(),$rules , $error_massage);
        if($valid->fails())
        {
            return redirect()->back()->withErrors($valid);; 
        }
        else
        {
            $reset1 = password_reset::select('email' ,'token' , 'vaild')->where('token' , $request->token)->get();
            $reset = $reset1[0];
            
            if(count($reset1) > 0)//check if token found in table 
            {
                
                //check valid token or not
                if($reset->vaild == "vaild")
                {
                    //update 
                    User::where('email' , $reset->email)->update(['password' =>  bcrypt($request->password) ]);
                    
                    //change vaild in reset_passwords table to invaild

                    password_reset::where('email' , $reset->email)->update( ["vaild" => "invaild"]);

                    return "done";
                }
                else
                {
                    return "You Aleardy changed the password ";
                }
            }
            else
            {
                //here token not founded in database
                return "invalid URL";
            }
        }
    }
}
?>