<?php

// database/migrations/[timestamp]_create_checkouts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class checkouts extends Migration
{
    // public function up()
    // {
    //     Schema::create('checkouts', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('first_name');
    //         $table->string('last_name');
    //         $table->string('email');
    //         $table->string('phone_number');
    //         $table->string('address');
    //         $table->string('city');
    //         $table->string('zip_code');
    //         $table->string('payment_method');
    //         $table->timestamps();
    //     });
    // }

    public function down()
    {
        Schema::dropIfExists('checkouts');
    }
}
