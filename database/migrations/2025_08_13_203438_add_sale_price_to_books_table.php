<?php

// database/migrations/[timestamp]_add_sale_price_to_books_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalePriceToBooksTable extends Migration
{
    public function up()
    {
        // Schema::table('books', function (Blueprint $table) {
        //     $table->decimal('sale_price', 10, 2)->nullable();
        // });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('sale_price');
        });
    }
}
