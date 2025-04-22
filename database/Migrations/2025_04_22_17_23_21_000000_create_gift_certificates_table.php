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
        Table::create('gift_certificates', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->varchar('code', 64);
            $blueprint->bool('used');
            $blueprint->createdAt();
            $blueprint->updatedAt();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Table::drop('gift_certificates');
    }
};
