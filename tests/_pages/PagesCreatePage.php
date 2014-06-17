<?php

class PagesCreatePage
{
    static $uri = '/admin/editorial/pages/create';
    static $uri_post = '/admin/editorial/pages/store';
	static $title = 'Create a page';
    static $submit_button = 'Submit';

    static $errorTwoPagesSameUri = 'There is already a page with the same URI';
    static $errorTwoPagesSameIdentifier = 'There is already a page with the same identifier';
    static $errorIdentifierMandatory = 'You must provide an identifier for a page';
    static $errorUriMandatory = 'You must provide a URI for a page';

	static $page_fixture_created = array('name' => 'Test Page', 'identifier' => 'test-page', 'uri' => '/test-page', 'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores, totam, optio doloribus cumque repellat architecto magni explicabo quis pariatur maxime quaerat impedit ducimus atque alias in sequi accusantium obcaecati veritatis!');
}