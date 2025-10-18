<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void {
    Schema::table('products', function (Blueprint $t) {
        $t->string('slug')->unique()->after('name');
    });
}

protected $fillable = ['name','slug','category_id','stock','price','is_active','image_path'];

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('slug');
    });
}

};
