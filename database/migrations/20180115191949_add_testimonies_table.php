<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTestimoniesTable extends Migration
{
    public function up()
    {
        $this->schema->create('testimonies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('quote');
            $table->text('description');
            $table->string('role');
            $table->string('featured');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('testimonies');
    }
}
