<?php

Menu::group(trans('acl::menu.user_manage'), 'fa-user', function ($parent) {

    Menu::create('users.manage', trans('acl::menu.users'))->setParent($parent)->setPath('users.manage');

})->setOrder(0)->setPosition('right');
