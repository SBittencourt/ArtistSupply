<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveEventProductTable extends Migration
{
    public function up()
    {
        Schema::create('active_event_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('active_event_id')->constrained('active_events')->onDelete('cascade'); // Referência à tabela active_events
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Referência à tabela products (ajuste conforme o nome da tabela se for diferente)
            $table->integer('quantity_sold');
            $table->decimal('total_value', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('active_event_product');
    }
}
