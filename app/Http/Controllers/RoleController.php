<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataRole;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $dtRole = DataRole::with('rolemenu')->get();
        return view('role.role', compact('dtRole'));
    }

    public function create()
    {
        $menu = DataMenu::all();
        return view('role.create', compact('menu'));
    }

    public function store(Request $request)
    {
        $dataRole = DataRole::create([
            'Role_name' => $request->name
        ]);

        $menu_id = $request->menu;

        foreach ($menu_id as $id) {
            DataRoleMenu::create([
                'Role_id' => $dataRole->id,
                'Menu_id' => $id,
            ]);
        }

        return redirect()->route('role')->with('success', 'Data stored successfully');
    }

    public function edit($Role_id)
    {
        $selectedMenuIds = DataRoleMenu::where('Role_id', $Role_id)->pluck('Menu_id')->toArray();
        $menu = DataMenu::all();
        $role = DataRole::where('Role_id', $Role_id)->first();
        return view('role.edit', compact('menu','role', 'selectedMenuIds'));
    }

    public function update(Request $request, $Role_id)
    {

        DataRoleMenu::where('Role_id', $Role_id)->delete();
        DataRole::where('Role_id', $Role_id)->update([
            'Role_name' => $request->name
        ]);

        $menu_id = $request->menu;

        foreach ($menu_id as $id) {
            DataRoleMenu::create([
                'Role_id' => $Role_id,
                'Menu_id' => $id,
            ]);
        }

        return redirect()->route('role')->with('success', 'Data stored successfully');
    }

    public function destroy($Role_id)
    {
        $role = DataRole::where('Role_id', $Role_id);
        $rolemenu = DataRoleMenu::where('Role_id', $Role_id);
        $role->delete();
        $rolemenu->delete();
        return redirect()->route('role')->with('success', 'Role deleted successfully');
    }
}
