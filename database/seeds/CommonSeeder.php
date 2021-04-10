<?php

use Illuminate\Database\Seeder;

class CommonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin_user_id = DB::table('admin_user')->insertGetId([
            'username' => 'admin',
            'password' => md5('admin' . env('APP_KEY')),
            'nickname' => 'admin',
            'email' => '',
            'mobile' => '',
            'reg_time' => time(),
            'reg_ip' => 0,
            'last_login_time' => 0,
            'last_login_ip' => 0,
            'update_time' => 0,
            'status' => 1
        ]);

        $admin_group_id = DB::table('auth_group')->insertGetId([
            'name' => 'admin',
            'description' => 'admin',
            'status' => 1,
            'create_time' => time(),
            'update_time' => time(),
        ]);

        DB::table('auth_group_admin_user')->insert([
            'group_id' => $admin_group_id,
            'admin_user_id' => $admin_user_id,
        ]);

        $this->insertConfig();

        $this->insertMenu();

        $menu_ids = DB::table('menu')->lists('id');

        DB::table('auth_group')
            ->where('id', $admin_group_id)
            ->update([
                'rules' => implode(',', $menu_ids)
            ]);
    }

    // 网站默认配置
    private function insertConfig()
    {
        $file = fopen(database_path('migrations/config.sql'), 'r');
        while (($line = fgets($file)) !== false) {
            if (!empty(trim($line))) {
                DB::select(DB::raw(trim($line)));
            }
        }
    }

    private function insertMenu()
    {
        $menus = [
            [
                'title' => '起始页',
                'url' => '/Startup/index',
                'icon_fa_class' => 'entypo-gauge',
                'sort_index' => 0,
            ],
            [
                'title' => '系统',
                'url' => '/Config/index',
                'icon_fa_class' => 'entypo-cog',

                '_child' => [
                    [
                        'title' => '配置管理',
                        'url' => '/Config/index',
                        'group' => '系统设置',

                        '_child' => [
                            [
                                'title' => '新建、编辑',
                                'url' => '/Config/config',
                            ],
                            [
                                'title' => '删除',
                                'url' => '/Config/delete',
                            ],
                        ]
                    ],
                    [
                        'title' => '权限管理',
                        'url' => '/Auth/index',
                        'group' => '系统设置',

                        '_child' => [
                            [
                                'title' => '新建、编辑',
                                'url' => '/Auth/form',
                            ],
                            [
                                'title' => '管理员列表、添加管理员到权限组',
                                'url' => '/Auth/admin-users',
                            ],
                            [
                                'title' => '删除',
                                'url' => '/Auth/delete',
                            ],
                            [
                                'title' => '权限分配',
                                'url' => '/Auth/rules',
                            ],
                        ]
                    ],
                    [
                        'title' => '菜单管理',
                        'url' => '/Config/menus',
                        'group' => '系统设置',

                        '_child' => [
                            [
                                'title' => '新建、编辑',
                                'url' => '/Config/menu',
                            ],
                            [
                                'title' => '菜单导入',
                                'url' => '/Config/import',
                            ],
                            // 删除权限在配置管理
                            [
                                'title' => '删除(同配置删除)',
                                'url' => '/Config/delete',
                            ],
                        ]
                    ]
                ]
            ]
        ];

        foreach ($menus as $menu) {
            $menu_id = DB::table('menu')->insertGetId([
                'title' => $menu['title'],
                'url' => $menu['url'],
                'icon_fa_class' => $menu['icon_fa_class'],
                'sort_index' => isset($menu['sort_index']) ? $menu['sort_index'] : 999,
                'group' => isset($menu['group']) ? $menu['group'] : '',
                'hide' => 0,
                'status' => 1,
//                'pid' => $system_menu_id,
                'create_time' => time(),
                'update_time' => time(),
            ]);

            if (isset($menu['_child'])) {
                foreach ($menu['_child'] as $sub_menu) {
                    $sub_menu_id = DB::table('menu')->insertGetId([
                        'title' => $sub_menu['title'],
                        'pid' => $menu_id,
                        'url' => $sub_menu['url'],
                        'icon_fa_class' => '',
                        'sort_index' => 999,
                        'group' => isset($sub_menu['group']) ? $sub_menu['group'] : '',
                        'hide' => 0,
                        'status' => 1,
                        'create_time' => time(),
                        'update_time' => time(),
                    ]);

                    // 最多三级
                    if (isset($sub_menu['_child'])) {
                        foreach ($sub_menu['_child'] as $m) {
                            DB::table('menu')->insert([
                                'title' => $m['title'],
                                'pid' => $sub_menu_id,
                                'url' => $m['url'],
                                'icon_fa_class' => '',
                                'sort_index' => 999,
                                'group' => isset($m['group']) ? $m['group'] : '',
                                'hide' => 1, // 三级菜单全部隐藏
                                'status' => 1,
                                'create_time' => time(),
                                'update_time' => time(),
                            ]);
                        }
                    }
                }
            }
        }

        // 删除权限缓存
        Cache::forget('auth_groups');
    }
}
