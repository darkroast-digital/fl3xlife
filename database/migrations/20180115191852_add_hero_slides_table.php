<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddHeroSlidesTable extends Migration
{
    public function up()
    {
        $this->schema->create('hero_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->string('heading');
            $table->string('subtitle');
            $table->text('description');
            $table->string('link_name');
            $table->string('link');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('hero_slides');
    }
}
