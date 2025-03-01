<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;


class AuthController extends Controller
{
    use HasApiTokens;
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|confirmed',
       
    ]); // if we want to insert we need those 3 form 

    $avatar_path = null;
    
    if ($request->hasFile('avatar')) {
        $avatar = $request->file('avatar');
        $avatar_name = time() . '.' . $avatar->getClientOriginalExtension();// this mean give back what the user give 
         //Retrieves the file extension from the uploaded image (e.g., png, jpg).
///Example: If the uploaded file is "profile.png", this returns "png".
        
         $avatar_path = $avatar->storeAs('avatars', $avatar_name, 'public'); 
        // Store in storage/app/public/avatars
    }


    /// after those above condition it will crete so that mean you need to check condition before create ;
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'avatar' => $avatar_path // Store only relative path
    ]); 
     /// in this case avatar can null but if we can have the avatar we will get it that a

    $user->avatar = url(Storage::url($user->avatar)); // Convert to public URL

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user,
        'message' => 'User registered successfully'
    ]);
}


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
         /// it check the email between the user input and what we have in the database  ; 
        $user = User::where('email', $request->email)->first();
        // ah nis mean ney tha ber ot mean email trov te or email trov tea password khos  
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                "message" => "Invalid credentials",
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        // this create the token and plainTextToken in generate the token 

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user'=>$user,
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
    
        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }
    

    
    
    
}
