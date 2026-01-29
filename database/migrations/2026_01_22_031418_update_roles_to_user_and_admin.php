<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {

            /**
             * 1️⃣ Mandar TODOS los usuarios al rol usuario (id = 2)
             */
            DB::table('users')->update([
                'role_id' => 2
            ]);

            /**
             * 2️⃣ Limpiar tabla roles
             *    Dejamos solo admin (1) y usuario (2)
             */
            DB::table('roles')->whereNotIn('id', [1, 2])->delete();

            /**
             * 3️⃣ Normalizar nombres
             */
            DB::table('roles')->where('id', 1)->update([
                'name' => 'admin'
            ]);

            DB::table('roles')->where('id', 2)->update([
                'name' => 'usuario'
            ]);
        });
    }

    public function down(): void
    {
        // ⚠️ No se puede revertir automáticamente sin perder lógica
        // Si quieres rollback real, tendría que ser manual
    }
};

