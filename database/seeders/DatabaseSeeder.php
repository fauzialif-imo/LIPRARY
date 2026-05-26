<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Category, Book};

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create(['username'=>'admin','email'=>'admin@yomulib.com','password'=>Hash::make('password'),'role'=>'admin','alamat'=>'Bogor','is_active'=>true]);
        User::create(['username'=>'petugas','email'=>'petugas@yomulib.com','password'=>Hash::make('password'),'role'=>'petugas','alamat'=>'Jakarta','is_active'=>true]);
        User::create(['username'=>'budi','email'=>'budi@example.com','password'=>Hash::make('password'),'role'=>'user','alamat'=>'Depok','is_active'=>true]);

        $cats = [
            ['name'=>'Fiksi','slug'=>'fiksi','icon'=>'📖'],['name'=>'Non-Fiksi','slug'=>'non-fiksi','icon'=>'📚'],
            ['name'=>'Sains & Teknologi','slug'=>'sains-teknologi','icon'=>'🔬'],['name'=>'Sejarah','slug'=>'sejarah','icon'=>'🏛️'],
            ['name'=>'Pendidikan','slug'=>'pendidikan','icon'=>'🎓'],['name'=>'Novel','slug'=>'novel','icon'=>'📕'],
            ['name'=>'Komik & Manga','slug'=>'komik-manga','icon'=>'🎨'],['name'=>'Pemrograman','slug'=>'pemrograman','icon'=>'💻'],
        ];
        foreach ($cats as $c) Category::create($c);

        $books = [
            ['category_id'=>1,'title'=>'Laskar Pelangi','author'=>'Andrea Hirata','publisher'=>'Bentang Pustaka','publish_date'=>'2005-09-01','isbn'=>'9789793062792','pages'=>529,'synopsis'=>'Novel tentang semangat anak-anak Belitung.','stock'=>3],
            ['category_id'=>6,'title'=>'Bumi Manusia','author'=>'Pramoedya Ananta Toer','publisher'=>'Hasta Mitra','publish_date'=>'1980-01-01','isbn'=>'9789799731234','pages'=>535,'synopsis'=>'Kisah cinta di masa penjajahan Belanda.','stock'=>2],
            ['category_id'=>3,'title'=>'A Brief History of Time','author'=>'Stephen Hawking','publisher'=>'Bantam Books','publish_date'=>'1988-04-01','isbn'=>'9780553380163','pages'=>212,'language'=>'Inggris','synopsis'=>'Eksplorasi alam semesta.','stock'=>1],
            ['category_id'=>8,'title'=>'Laravel: Up & Running','author'=>'Matt Stauffer','publisher'=>'O\'Reilly','publish_date'=>'2019-01-01','isbn'=>'9781492041214','pages'=>620,'language'=>'Inggris','synopsis'=>'Panduan lengkap Laravel.','stock'=>4],
            ['category_id'=>2,'title'=>'Atomic Habits','author'=>'James Clear','publisher'=>'Avery','publish_date'=>'2018-10-01','isbn'=>'9780735211292','pages'=>320,'language'=>'Inggris','synopsis'=>'Cara membangun kebiasaan baik.','stock'=>3],
            ['category_id'=>5,'title'=>'Matematika SMK Kelas XI','author'=>'Kemendikbud','publisher'=>'Kementerian Pendidikan','publish_date'=>'2020-01-01','isbn'=>'9786020099512','pages'=>250,'synopsis'=>'Buku ajar matematika SMK.','stock'=>5],
        ];
        foreach ($books as $b) Book::create($b);
    }
}
