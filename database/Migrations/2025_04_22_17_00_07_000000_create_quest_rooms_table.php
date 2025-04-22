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
        Table::create('quest_rooms', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->varchar('name', 64);
            $blueprint->int2('open_hour');
            $blueprint->int2('close_hour');
            $blueprint->int('price');
            $blueprint->int('max_players');
            $blueprint->createdAt();
            $blueprint->updatedAt();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Table::drop('quest_rooms');
    }
};
