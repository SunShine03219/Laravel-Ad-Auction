<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class DatabaseImport extends Seeder
{
    /**
     * Run the database seeds.
     * Import database from file
     * php artisan db:seed --class=DatabaseImport
     */
    public function run(): void
    {
        $this->drop_all_tables();

        $path = database_path('larabid.sql');
        $sql = File::get($path);
        DB::unprepared($sql);
    }

    public function drop_all_tables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $table_array = get_object_vars($table);
            Schema::dropIfExists($table_array[key($table_array)]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
