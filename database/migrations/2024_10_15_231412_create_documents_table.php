<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id(); // Primary key 'id'
            $table->string('title');
            $table->text('content');
            $table->string('format')->nullable();
            $table->string('file_path')->nullable();
            
            // Foreign key columns
            $table->unsignedBigInteger('category_id')->nullable(); // Define category_id as an unsigned big integer
            $table->unsignedBigInteger('user_id')->nullable(); // Define user_id as an unsigned big integer

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('category_id')->references('id_category')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
