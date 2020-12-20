<?php

namespace App\Http\Middleware;

use Closure;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $permissions = [];
        $menu_array = [[
            'url' => '/',
            'label' => 'Beranda',
            'icon' => 'activity'
        ]];
        $user_2_roles = $user->roles->map(function ($role) use (&$permissions)
        {
            foreach ($role->permissions AS $permission)
            {
                $permissions[$permission->name] = true;
            }
    
            return [
                'role_id' => $role->role_id,
                'name' => $role->name,
            ];
        });

        if (@$permissions['get_all_users'] === true) {
            array_push($menu_array, [
                'url' => '/user',
                'label' => 'User',
                'icon' => 'tag'
            ]);
        }

        if (@$permissions['get_all_category'] === true) {
            array_push($menu_array, [
                'url' => '/category',
                'label' => 'Kategori',
                'icon' => 'tag'
            ]);
        }

        if (@$permissions['get_all_product'] === true) {
            array_push($menu_array, [
                'url' => '/product',
                'label' => 'Produk',
                'icon' => 'box'
            ]);
        }

        if (@$permissions['get_all_order'] === true) {
            array_push($menu_array, [
                'url' => '/order',
                'label' => 'Pesanan',
                'icon' => 'shopping-cart'
            ]);
        }

        $request->attributes->add([
            'permissions' => $permissions,
            'menu_array' => $menu_array
        ]);

        return $next($request);
    }
}
