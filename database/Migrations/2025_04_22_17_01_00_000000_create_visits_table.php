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
            $blueprint->int('quest_room_id');
            $blueprint->int('user_id');
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
