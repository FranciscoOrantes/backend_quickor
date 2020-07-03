<?php

namespace App\Http\Controllers;

use App\Mail\NotificacionSesion;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use JWTAuth;
use App\User;
class LoginController extends Controller
{
    use AuthenticatesUsers,ThrottlesLogins;
    protected $maxAttempts=3;
    protected $decayMinutes=2;
protected $lockoutTime=60;
    public function login(Request $request) {
        
        $input = $request->only('email', 'password');
        $jwt_token = null;
        if ($this->hasTooManyLoginAttempts($request)) {
            Log::alert('Se ha alcanzado el límite de intentos máximos que son: '.$this->maxAttempts.' por parte de: '.$request->email);
            $this->fireLockoutEvent($request);
            return response()->json([
                'intentosMaximos' => $this->maxAttempts(),
                'tiempoEspera' => $this->decayMinutes(),
                'email' => $request->email
            ],429);
        }
        if (!$jwt_token = JWTAuth::attempt($input)) {
        $variable = $this->limiter()->hit($this->throttleKey($request)); 
        Log::alert('Intento de sesión número: '.$variable.' con el email '.$request->email);
        return response()->json([
        'status' => 'invalid_credentials',
        'message' => 'Correo o contraseña no válidos.',
        'intento_actual'=>$variable
        ], 401);
        }else{
            $this->clearLoginAttempts($request);
            Log::info('Ha iniciado sesión con éxito '.$request->email);
            Mail::to($request->email)->send(new NotificacionSesion($_SERVER['REMOTE_ADDR']));
            $usuario = User::select('tipo_usuario')->where('email', $request->email)->first()->toArray(); 
            $token =  [
                'token' => $jwt_token,
                'status' => 'ok',
                'email' => $request->email
            ];
            return json_encode($usuario + $token);
        }
       
        }
        

        public function logout(Request $request) {
            $this->validate($request, [
            'token' => 'required'
            ]);
            try {
            JWTAuth::invalidate($request->token);
            return response()->json([
            'status' => 'ok',
            'message' => 'Cierre de sesión exitoso.'
            ]);
            } catch (JWTException $exception) {
            return response()->json([
            'status' => 'unknown_error',
            'message' => 'Al usuario no se le pudo cerrar la sesión.'
            ], 500);
            }
            }
            public function getAuthUser(Request $request) {
                $this->validate($request, [
                'token' => 'required'
                ]);
                $user = JWTAuth::authenticate($request->token);
                return response()->json(['user' => $user]);
                }
                protected function jsonResponse($data, $code = 200)
               {
                return response()->json($data, $code,
                ['Content-Type' => 'application/json;charset=UTF8','Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
               }

        
       
}
