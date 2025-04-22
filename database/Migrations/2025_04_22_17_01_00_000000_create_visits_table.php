<?php

use Bubblegum\Migrations\Blueprint;
use Bubblegum\Migrations\Migration;
use Bubblegum\Migrations\Table;


return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Table::create('visits', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->varchar('name', 64);
            $blueprint->time('open_time');
            $blueprint->time('close_time');
            $blueprint->createdAt();
            $blueprint->updatedAt();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Table::drop('visits');
    }
};
