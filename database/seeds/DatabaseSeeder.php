<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('configuracion')->insert([
            'id'                       => 1,
            'nombre_empresa'           => "OS-Inventario",
            'slogan'                   => "Inventory & Stock Control",
            'codigo_empresa'           => "OS-0001",
            'telefono'                 => "000000000",
            'idioma'                   => "en",
            'correo'                   => "contact@oswcript.com",
            'moneda'                   => "USD",
            'tributo'                  => "ACTIVO", //Activo e Inactivo
            'recuperar_clave_login'    => "on",
            'registro_usuario_login'   => "on",
        ]);

        DB::table('roles')->insert([
            'id'       => 1,
            'nombre'   => "SUPERADMIN",
            'status'   => 1,
        ]);

        DB::table('roles')->insert([
        'id'       => 2,
        'nombre'   => "ADMINISTRADOR",
        'status'   => 1,
        ]);

        DB::table('roles')->insert([
            'id'       => 3,
            'nombre'   => "USUARIO",
            'status'   => 1,
        ]);

        DB::table('permisos')->insert([
            'id'          => 1,
            'catego_i'    => 1,
            'catego_r'    => 1,
            'catego_e'    => 1,
            'catego_b'    => 1,
            'subcatego_i' => 1,
            'subcatego_r' => 1,
            'subcatego_e' => 1,
            'subcatego_b' => 1,
            'producto_i'  => 1,
            'producto_r'  => 1,
            'producto_e'  => 1,
            'producto_b'  => 1,
            'gasto_i'     => 1,
            'gasto_r'     => 1,
            'gasto_e'     => 1,
            'gasto_b'     => 1,
            'kardex_i'    => 1,
            'venta_i'     => 1,
            'venta_r'     => 1,
            'compra_i'    => 1,
            'compra_r'    => 1,
            'persona_i'   => 1,
            'reporte_i'   => 1,
            'rol_id'      => 1,
        ]);

        DB::table('permisos')->insert([
            'id'          => 2,
            'catego_i'    => 1,
            'catego_r'    => 1,
            'catego_e'    => 1,
            'catego_b'    => 1,
            'subcatego_i' => 1,
            'subcatego_r' => 1,
            'subcatego_e' => 1,
            'subcatego_b' => 1,
            'producto_i'  => 1,
            'producto_r'  => 1,
            'producto_e'  => 1,
            'producto_b'  => 1,
            'gasto_i'     => 1,
            'gasto_r'     => 1,
            'gasto_e'     => 1,
            'gasto_b'     => 1,
            'kardex_i'    => 1,
            'venta_i'     => 1,
            'venta_r'     => 1,
            'compra_i'    => 1,
            'compra_r'    => 1,
            'persona_i'   => 1,
            'reporte_i'   => 1,
            'rol_id'      => 2,
        ]);

        DB::table('permisos')->insert([
            'id'          => 3,
            'catego_i'    => 1,
            'catego_r'    => 1,
            'catego_e'    => 1,
            'catego_b'    => 1,
            'subcatego_i' => 1,
            'subcatego_r' => 1,
            'subcatego_e' => 1,
            'subcatego_b' => 1,
            'producto_i'  => 1,
            'producto_r'  => 1,
            'producto_e'  => 1,
            'producto_b'  => 1,
            'gasto_i'     => 1,
            'gasto_r'     => 1,
            'gasto_e'     => 1,
            'gasto_b'     => 1,
            'kardex_i'    => 1,
            'venta_i'     => 1,
            'venta_r'     => 1,
            'compra_i'    => 1,
            'compra_r'    => 1,
            'persona_i'   => 1,
            'reporte_i'   => 1,
            'rol_id'      => 3,
        ]);

        DB::table('users')->insert([
            'id'        => 1,
            'nombre'    => "OSW",
            'apellido'  => "SCRIPT",
            'cedula'    => "12345678",
            'email'     => 'contact@oswscript.com',
            'sexo'      => 'M',
            'telefono'  => '+000000000',
            'direccion' => 'DIRECCION DE SUPER ADMIN',
            'rol_id'    => 1,
            'status'    => 1,
            'password'  => bcrypt('12345678'),
        ]);

        DB::table('users')->insert([
            'id'        => 2,
            'nombre'    => "ADMIN",
            'apellido'  => "ADMIN",
            'cedula'    => "00000000",
            'email'     => 'admin@admin.com',
            'sexo'      => "M",
            'telefono'  => '0000',
            'direccion' => '0000',
            'rol_id'    => 2,
            'status'    => 1,
            'password'  => bcrypt('123456'),
        ]);

        DB::table('tributos')->insert([
            'id'        => 1,
            'nombre'    => "IVA",
            'tipo'      => "PORCENTAJE",
            'monto'     => "12",
        ]);

    }
}
