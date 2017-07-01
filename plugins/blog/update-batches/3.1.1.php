<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Schema::table('relations', function (Blueprint $table) {
    $table->integer('category_id')->unsigned()->nullable();
    $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
});
