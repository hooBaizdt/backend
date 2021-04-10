<?php

namespace App\Service;

use DB;

class MigrationService
{
    // 数据库迁移添加通用字段方法
    public static function addCommonFieldsToTable($table)
    {
        /** @var \Illuminate\Database\Schema\Blueprint $table */
        $table->float('sort_index')->default(999)->comment('排序索引');
        $table->tinyInteger('is_deleted')->default(0)->comment('是否已被删除');
        $table->tinyInteger('status')->default(1)->comment('启用状态(0-禁用, 1-启用)');
        $table->bigInteger('create_time')->default(0)->comment('创建时间戳');
        $table->bigInteger('update_time')->default(0)->comment('更新时间戳');
    }

    // 添加表注释
    public static function addCommentToTable($table, $comment = '')
    {
        $table = DB::getTablePrefix() . $table;
        DB::statement("alter table {$table} comment = '{$comment}'");
    }
}