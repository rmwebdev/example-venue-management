<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTypeVenuePivotTable extends Migration
{
    public function up()
    {
        Schema::create('event_type_venue', function (Blueprint $table) {
            $table->unsignedBigInteger('venue_id');
            $table->foreign('venue_id', 'venue_id_fk_3840037')->references('id')->on('venues')->onDelete('cascade');
            $table->unsignedBigInteger('event_type_id');
            $table->foreign('event_type_id', 'event_type_id_fk_3840037')->references('id')->on('event_types')->onDelete('cascade');
        });
    }
}