<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddInstructorsTable extends Migration
{
    public function up()
    {
        $this->schema->create('instructors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('avatar');
            $table->string('title');
            $table->text('bio');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('instagram');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('instructors');
    }
}
