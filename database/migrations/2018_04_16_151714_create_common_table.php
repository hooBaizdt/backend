<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('admin_user', function (Blueprint $table) {
            $table->increments('id')->comment('用户ID');
            $table->string('username', 16)->comment('用户名');
            $table->string('password', 32)->comment('密码');
            $table->string('nickname', 64)->default('')->comment('昵称');
            $table->string('email', 32)->comment('用户邮箱');
            $table->string('mobile', 15)->default('')->comment('用户手机');
            $table->bigInteger('reg_time')->default(0)->comment('注册时间');
            $table->bigInteger('reg_ip')->default(0)->comment('注册IP');
            $table->bigInteger('last_login_time')->default(0)->comment('最后登录时间');
            $table->bigInteger('last_login_ip')->default(0)->comment('最后登录IP');
            $table->bigInteger('update_time')->default(0)->comment('更新时间');
            $table->smallInteger('status')->default(0)->comment('用户状态');
        });
        \App\Service\MigrationService::addCommentToTable('admin_user', '管理员表');

        Schema::create('auth_group', function (Blueprint $table) {
            $table->increments('id')->comment('用户组ID');
            $table->string('name', 32)->comment('权限组名称');
            $table->string('description', 128)->default('')->comment('描述信息');
            $table->text('rules')->default('')
                ->comment('权限组拥有的菜单权限id列表，以逗号分隔');
            $table->tinyInteger('status')->default(1)->comment('启用状态(0-禁用，1-启用)');
            $table->bigInteger('create_time')->default(0)->comment('创建时间戳');
            $table->bigInteger('update_time')->default(0)->comment('更新时间戳');
        });
        \App\Service\MigrationService::addCommentToTable('auth_group', '权限组表');

        Schema::create('auth_group_admin_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->comment('权限组id');
            $table->integer('admin_user_id')->comment('管理员用户id');
        });
        \App\Service\MigrationService::addCommentToTable('auth_group_admin_user', '权限组-管理员 关联表');

        Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->default('')->comment('配置名称');
            $table->tinyInteger('type')->unsigned()->default(0)->comment('配置类型');
            $table->string('title', 50)->default('')->comment('配置说明');
            $table->integer('group')->default(0)->comment('配置分组');
            $table->string('extra', 255)->default('')->comment('配置值');
            $table->string('remark', 100)->comment('配置说明');
            $table->text('value')->comment('配置值');
            $table->integer('sort')->default(0)->comment('排序');
            $table->integer('status')->default(1)->comment('状态');
            $table->bigInteger('create_time')->default(0)->comment('创建时间戳');
            $table->bigInteger('update_time')->default(0)->comment('更新时间戳');
        });
        \App\Service\MigrationService::addCommentToTable('config', '配置表');

        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50)->default('')->comment('标题');
            $table->integer('pid')->default(0)->comment('上级分类ID');
            $table->string('url')->default('')->comment('链接地址');
            $table->string('icon_fa_class', 64)->default('')->comment('菜单的fa图标');
            $table->string('icon_img')->default('')->comment('菜单的图标路径');
            $table->tinyInteger('hide')->default(0)->comment('是否隐藏');
            $table->string('tip')->default('')->comment('提示');
            $table->string('group', 50)->default('')->comment('分组');
            $table->tinyInteger('is_skip_auth')->default(0)->comment('跳过检查权限（开放给所有人访问）');
            $table->tinyInteger('is_dev')->default(0)->comment('是否仅开发者模式可见');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->integer('sort_index')->default(0)->comment('排序(同级有效)');
            $table->bigInteger('create_time')->default(0)->comment('创建时间戳');
            $table->bigInteger('update_time')->default(0)->comment('更新时间戳');
        });
        \App\Service\MigrationService::addCommentToTable('menu', '菜单表');

        Schema::create('noty', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 32)->default('information')
                ->comment('消息类型（information、success、error、warning）');
            $table->string('title', 32)->default('')->comment('消息标题');
            $table->string('text', 1024)->comment('消息内容');
            $table->string('url', 256)->default('')->comment('点击消息后跳转的链接');
            $table->tinyInteger('has_alert')->default(0)->comment('是否已经弹过消息提示');
            $table->tinyInteger('has_clicked')->default(0)->comment('是否已经点击阅读了消息');
            $table->integer('auth_group_id')->default(0)->comment('权限组id（0表示不限制权限组）');
            $table->bigInteger('create_time')->default(0)->comment('创建时间戳');
            $table->bigInteger('update_time')->default(0)->comment('更新时间戳');
        });
        \App\Service\MigrationService::addCommentToTable('noty', '消息表');

        Schema::create('new_feature', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role', 64)->comment('角色');
            $table->text('desc')->comment('更新简介');
            $table->text('content')->comment('更新详情');
            $table->tinyInteger('has_content')->default(0)->comment('是否有更新详情');
            $table->tinyInteger('is_published')->default(0)->comment('是否发布更新');

            $table->tinyInteger('status')->default(1)->comment('启用状态(0-禁用,1-启用)');
            $table->tinyInteger('is_deleted')->default(0)->comment('逻辑删除标识');
            $table->bigInteger('create_time')->default(0)->comment('创建时间戳');
            $table->bigInteger('update_time')->default(0)->comment('更新时间戳');
        });
        \App\Service\MigrationService::addCommentToTable('new_feature', '新功能表');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('admin_user');
        Schema::dropIfExists('auth_group');
        Schema::dropIfExists('auth_group_admin_user');
        Schema::dropIfExists('config');
        Schema::dropIfExists('menu');
        Schema::dropIfExists('noty');
        Schema::dropIfExists('new_feature');
    }
}
