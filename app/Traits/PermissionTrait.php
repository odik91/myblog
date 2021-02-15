<?php
namespace App\Traits;

use Illuminate\Support\Facades\Route;
use App\Models\Menu;

/**
 * Permission traits
 */

trait PermissionTrait {
  public function hasPermission() {
    // Route access settings
    $getMenuIds = Menu::whereNotIn('id', [1])->get();
    foreach ($getMenuIds as $getMenuId) {
      if (!isset(auth()->user()->getRole->permission['name']["$getMenuId->id"]['view']) && Route::is("")) {
        // 
      }
    }
  }
}