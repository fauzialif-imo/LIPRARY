<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });
        $now = now();
        DB::table('settings')->insert([
            ['key'=>'hero_bg_image',    'value'=>null,        'created_at'=>$now,'updated_at'=>$now],
            ['key'=>'hero_title',       'value'=>'Pintu Gerbang Digital Anda ke Ilmu Pengetahuan','created_at'=>$now,'updated_at'=>$now],
            ['key'=>'hero_subtitle',    'value'=>'Akses Buku dan Modul SMK di sini','created_at'=>$now,'updated_at'=>$now],
            ['key'=>'about_image',      'value'=>null,        'created_at'=>$now,'updated_at'=>$now],
            ['key'=>'navbar_logo',      'value'=>null,        'created_at'=>$now,'updated_at'=>$now],
            ['key'=>'navbar_site_name', 'value'=>'YOMULIB',   'created_at'=>$now,'updated_at'=>$now],
            ['key'=>'feature_1_image',  'value'=>null,        'created_at'=>$now,'updated_at'=>$now],
            ['key'=>'feature_2_image',  'value'=>null,        'created_at'=>$now,'updated_at'=>$now],
            ['key'=>'feature_3_image',  'value'=>null,        'created_at'=>$now,'updated_at'=>$now],
            ['key'=>'category_1_image', 'value'=>null,        'created_at'=>$now,'updated_at'=>$now],
            ['key'=>'category_2_image', 'value'=>null,        'created_at'=>$now,'updated_at'=>$now],
            ['key'=>'category_3_image', 'value'=>null,        'created_at'=>$now,'updated_at'=>$now],
            ['key'=>'category_4_image', 'value'=>null,        'created_at'=>$now,'updated_at'=>$now],
        ]);
    }
    public function down(): void { Schema::dropIfExists('settings'); }
};
