<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 创建宠物信息表
     */
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id()->comment('宠物ID');
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->comment('用户ID，关联用户表');
            $table->string('title', 100)->comment('宠物标题');
            $table->text('description')->comment('详细描述');
            $table->string('species', 50)->comment('宠物种类（如：猫、狗等）');
            $table->integer('age')->comment('宠物年龄（月）');
            $table->string('photo')->comment('宠物照片路径');
            $table->boolean('is_visible')->default(true)->comment('是否可见（1:可见，0:隐藏）');
            $table->timestamps();
            
            // 添加索引
            $table->index('user_id');
            $table->index('is_visible');
        });
        
        // 添加表注释
        DB::statement("ALTER TABLE `pets` COMMENT='宠物领养信息表'");
    }

    /**
     * Reverse the migrations.
     * 回滚迁移
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
