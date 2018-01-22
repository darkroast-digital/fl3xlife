<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSchedulesTable extends Migration
{
    public function up()
    {
        $this->schema->create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('file');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('schedules');
    }
}
