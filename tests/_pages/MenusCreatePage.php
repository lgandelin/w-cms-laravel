<?php

class MenusCreatePage
{
    static $uri = '/admin/editorial/menus/create';
    static $uri_post = '/admin/editorial/menus/store';
    static $uri_add_item_post = '/admin/editorial/menus/add_item';
    static $title = 'Create a menu';
    static $submit_button = 'Submit';

    static $errorTwoMenusSameIdentifier = 'There is already a menu with the same identifier';
    static $errorIdentifierMandatory = 'You must provide an identifier for a menu';

    static $menu_fixture_created = array('name' => 'Test Menu', 'identifier' => 'test-menu');
}