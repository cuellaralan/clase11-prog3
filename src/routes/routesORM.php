<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\cd;
use App\Models\ORM\usuario;
use App\Models\ORM\cdApi;


include_once __DIR__ . '/../../src/app/modelORM/cd.php';
include_once __DIR__ . '/../../src/app/modelORM/cdControler.php';
include_once __DIR__ . '/../../src/app/modelORM/usuario.php';

return function (App $app) {
    $container = $app->getContainer();

     $app->group('/cdORM', function () {   
         
        $this->get('/', function ($request, $response, $args) {
          //return cd::all()->toJson();
          $todosLosCds=cd::all();
          $newResponse = $response->withJson($todosLosCds, 200);  
          return $newResponse;
        });

        $this->get('/login', function ($request, $response, $args) {
            //return cd::all()->toJson();
            // $allUsers=usuario::all();
            $allUsers = "hola usuarios";
            $newResponse = $response->withJson($allUsers, 200);  
            return $newResponse;
          });
    });

    $app->group('/usuarios', function () {   
         
        $this->get('/login', function ($request, $response, $args) {
            //return cd::all()->toJson();
            $allUsers=usuario::all();
            // $allUsers = "hola usuarios";
            $newResponse = $response->withJson($allUsers, 200);  
            return $newResponse;
          });

          $this->post('/guardar', function ($request, $response, $args) {
            //return cd::all()->toJson();
            $arrayParam = $request->getParsedBody();
            $usuario= new usuario;
            $usuario->email = $arrayParam['email'];
            $usuario->clave = $arrayParam['clave'];
            $usuario->tipo = $arrayParam['tipo'];
            $usuario->rol = $arrayParam['rol'];
            //foto
            //obtengo archivos
            $uploadedFiles = $request->getUploadedFiles();
            //una foto
            $unFile = $uploadedFiles['foto'];
            //path de archivo temporal
            $origen = $uploadedFiles["foto"]->file;
            //hacer el moveupload de la foto y guardar en foto la ruta /images/path_creado
            $usuario->foto = $origen;
            // $allUsers = "hola usuarios";
            $usuario->save();
            $userAux = usuario::where('email',$usuario->email);
            if(isset($userAux) )
            {
                $newResponse = $response->withJson('guardado exitosamente', 200);  
            }
            else{
                $newResponse = $response->withJson('error al guardar', 200);  
            }      
            return $newResponse;
          });
    });


    //  $app->group('/cdORM2', function () {   

    //     $this->get('/',cdApi::class . ':traerTodos');
   
    // });

};