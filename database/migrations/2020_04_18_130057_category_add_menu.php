<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CategoryAddMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->unsignedInteger(NestedSet::PARENT_ID)->nullable()->change(); // parent_id nullable olması gerekiyor. Sizin yapıda nullable değil, burada değiştiriyoruz
            $table->unsignedInteger(NestedSet::LFT)->default(0);
            $table->unsignedInteger(NestedSet::RGT)->default(0);
            $table->unsignedInteger("parent_id")->nullable();
            $table->string('name');
            $table->index(NestedSet::getDefaultColumns());
            $table->increments("id");
            $table->date("updated_at");
            $table->date("created_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
        $table->dropIndex(NestedSet::getDefaultColumns());
        $table->dropColumn([NestedSet::LFT, NestedSet::RGT]);
        });
    }
}
