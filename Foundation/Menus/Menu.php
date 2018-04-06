<?php

namespace Collejo\Foundation\Menus;

class Menu
{
    private $menus;

    /**
     * Create a new menu group.
     *
     * A menu group could be initialized with just a closure
     * or could also be initialized with label, icon and closure
     *
     * @throws \Exception
     *
     * @return MenuItem
     */
    public function group()
    {
        if (func_num_args() == 3) {
            $label = func_get_arg(0);
            $icon = func_get_arg(1);
            $closure = func_get_arg(2);
            $name = $this->createMenuNameFromString($label);

            $menu = new MenuItem();
            $menu->setName($name)->setLabel($label)->setIcon($icon)->setType('g');
            $this->menus->push($menu);

            $closure($name);

            return $menu;
        } elseif (func_num_args() == 1) {
            $closure = func_get_arg(0);
            $name = microtime(true);
            $closure($name);

            $menu = new MenuItem();
            $name = microtime(true);
            $menu->setName($name)->setLabel(null)->setType('s');
            $this->menus->push($menu);

            return $menu;
        }

        throw new \Exception('Invalid Arguments');
    }

    /**
     * Returns a Menu object by name.
     *
     * @param $name
     *
     * @return \Illuminate\Support\Collection|static
     */
    public function getMenuByName($name)
    {
        return $this->menus->where('name', $this->createMenuNameFromString($name))->first();
    }

    /**
     * Create a nice name from a given string.
     *
     * @param $string
     *
     * @return mixed
     */
    private function createMenuNameFromString($string)
    {
        return strtolower($string);
    }

    /**
     * Creates a new menu item.
     *
     * @param $name
     * @param $label
     *
     * @return MenuItem
     */
    public function create($name, $label)
    {
        $menu = new MenuItem();
        $menu->setName($name)->setLabel($label)->setType('m');
        $this->menus->push($menu);

        return $menu;
    }

    /**
     * Returns a collection of menu items.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getItems()
    {
        return $this->menus;
    }

    /**
     * Returns a collection of menu items sorted and ready for rendering.
     *
     * @return static
     */
    public function getMenuBarItems()
    {
        $groups = $this->getItems()->where('type', 'g');
        $menus = $this->getItems()->where('type', 'm');
        $subGroups = $this->getItems()->where('type', 's');

        foreach ($subGroups as $subGroupItem) {
            $subGroupItem->children = $menus->where('parent', $subGroupItem->getName());
        }

        foreach ($groups as $groupsItem) {
            $groupsItem->children = $menus->where('parent', $groupsItem->getName())->union($subGroups->where('parent', $groupsItem->getName()));
        }

        return $groups->sortBy('order')->values();
    }

    public function __construct($app)
    {
        $this->app = $app;
        $this->menus = collect();
    }
}