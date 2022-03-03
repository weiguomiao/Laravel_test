<?php
/**
 * Created by : PhpStorm
 * User: weigm
 * Date: 2021/11/30 0030
 * Time: 16:57
 */

use App\Models\Category;

/**
 * 所有分类
 */
if (!function_exists('categoryTree')) {
    function categoryTree($group = 'goods', $status = false)
    {
        $list = Category::select(['id', 'name', 'pid', 'level', 'status'])
            ->when($status !== false, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->where('group', $group)
            ->where('level', 1)
            ->with([
                'children' => function ($query) use ($status) {
                    $query->select([
                        'id', 'pid', 'name', 'level', 'status'
                    ])->when($status !== false, function ($query) use ($status) {
                        $query->where('status', $status);
                    });
                },
                'children.children' => function ($query) use ($status) {
                    $query->select([
                        'id', 'pid', 'name', 'level', 'status'
                    ])->when($status !== false, function ($query) use ($status) {
                        $query->where('status', $status);
                    });
                }
            ])->get();
        return $list;
    }
}

/**
 * 缓存没被禁用的分类
 */
if (!function_exists('cache_category')) {
    function cache_category()
    {
        return cache()->rememberForever('cache_category', function () {
            return categoryTree('goods', 1);
        });
    }
}

/**
 * 缓存所有分类
 */
if (!function_exists('cache_category_all')) {
    function cache_category_all()
    {
        return cache()->rememberForever('cache_category_all', function () {
            return categoryTree('goods');
        });
    }
}

/**
 * 缓存没被禁用的菜单
 */
if (!function_exists('cache_category_menu')) {
    function cache_category_menu()
    {
        return cache()->rememberForever('cache_category_menu', function () {
            return categoryTree('menu', 1);
        });
    }
}

/**
 * 缓存所有菜单
 */
if (!function_exists('cache_category_menu_all')) {
    function cache_category_menu_all()
    {
        return cache()->rememberForever('cache_category_menu_all', function () {
            return categoryTree('menu');
        });
    }
}

/**
 * 清空缓存
 */
if (!function_exists('forget_cache_category')) {
    function forget_cache_category()
    {
        cache()->forget('cache_category');
        cache()->forget('cache_category_all');
        cache()->forget('cache_category_menu');
        cache()->forget('cache_category_menu_all');
    }
}
