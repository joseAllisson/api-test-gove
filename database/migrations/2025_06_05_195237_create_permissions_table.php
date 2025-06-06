<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('permissions', function (Blueprint $table) {
      $table->id();
      $table->string('name');           // nome da permissão
      $table->unsignedBigInteger('parent_id')->nullable();  // para permissão pai (hierarquia)
      $table->timestamps();
      $table->softDeletes();

      // FK para permissão pai
      $table->foreign('parent_id')->references('id')->on('permissions')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('permissions');
  }
};
