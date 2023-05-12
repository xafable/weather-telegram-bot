<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_ua');
            $table->string('title_ru');
            $table->string('title_en');

            $table->string('country');
            $table->string('state');

            $table->decimal('lon', 9, 6);
            $table->decimal('lat', 8, 6);
            $table->timestamps();

            $table->unique(['lon', 'lat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};

/*id       INTEGER  NOT NULL PRIMARY KEY
  ,name     VARCHAR(72) NOT NULL
  ,state    VARCHAR(2)
  ,country  VARCHAR(2)
  ,coordlon NUMERIC(11,6) NOT NULL
  ,coordlat NUMERIC(10,6) NOT NULL*/
