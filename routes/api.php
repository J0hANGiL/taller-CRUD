<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ControladorInventario;

route::get('/inventario', [ControladorInventario::class,'index']);

route::get('/inventario/{id}', function (){
    return 'traer inventario';
});

route::post('/inventario', [ControladorInventario::class,'agregar']);

route::put('/inventario/{id}', [ControladorInventario::class,'Actualizar']);

route::delete('/inventario/{id}',[ControladorInventario::class,'Eliminar']);

