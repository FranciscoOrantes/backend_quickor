<?php

namespace App\Http\Controllers;

use App\Mail\NotificacionSesion;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use App\Mail\CambiarPassword;
use Illuminate\Http\Request;
use App\Mail\DesactivarCuenta;
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
            
            $usuario = User::select('tipo_usuario','id')->where('email', $request->email)->get();
            $usuarioStatus = User::select('status')->where('email',$request->email)->get();    
            if($usuario[0]->tipo_usuario=='gerente'){
                $usuario = User::select('users.tipo_usuario','gerentes.id','users.status','gerentes.user_id')
                ->join('gerentes','users.id','=','gerentes.user_id')
                ->where('email', $request->email)->first()->toArray();
            }else{
                $usuario = User::select('users.tipo_usuario','proveedors.id','users.status','proveedors.user_id')
                ->join('proveedors','users.id','=','proveedors.user_id')
                ->where('email', $request->email)->first()->toArray();
            }
            if($usuario['status']==0){
                Log::info('Ha iniciado sesión con éxito '.$request->email);
                Mail::to($request->email)->send(new NotificacionSesion($_SERVER['REMOTE_ADDR']));
            }else{
                Log::info('Intento de inicio de sesión por cuenta desactivada: '.$request->email);
                //$usuarioStatus->status=0;
                //$usuarioStatus->update();
                //Mail::to($request->email)->send(new DesactivarCuenta($_SERVER['REMOTE_ADDR']));
            }
            $token =  [
                'token' => $jwt_token,
                'email' => $request->email
            ];
            return json_encode($usuario + $token);
        }

       
        }
        public function checarId($id){
            $usuario_id = User::select('users.id','proveedors.id')
            ->join('proveedors','users.id','=','proveedors.user_id')
            ->where('email')->first()->toArray();
            if($usuario_id==null){
                $id = User::select('users.id','gerentes.id')
            ->join('gerentes','users.id','=','gerentes.user_id')
            ->where('users.id','=',$id)->first()->toArray();
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

               
               public function actualizarPassword(Request $request){
                $usuario = User::select('users.email,users.tipo_usuario,users.id')
                ->where('email', $request->email)->get();
                   
                $usuario->password = bcrypt($request->password);
                $usuario->update();
                print($usuario);
                return $usuario;
            }
            public function solicitarCambioPassword(Request $request){
                $codigo = uniqid();
                
                $correo = $request->correo;
               
                Mail::to($correo)->send(new CambiarPassword($codigo));
                
                return response()->json([
                    'codigo' => $codigo,
                    
                    ], 200);
            }
            public function actualizarStatus($id){
                $usuarioStatusLog = User::find($id);
                $usuarioStatusLog->status = 0;
                $usuarioStatusLog->update();
            }

            public function desactivarCuenta($id){
                $email = User::select('users.email')
                ->where('id','=',$id)->get();       
                $usuario = User::find($id);
                $usuario->status = 1;
                $usuario->update();
                Log::info('Se ha desactivado la cuenta de: '.$email);
                Mail::to($email)->send(new DesactivarCuenta($_SERVER['REMOTE_ADDR']));
                return $usuario;        
        
                #priuenafsddf        
            }
}
