<?php

namespace Hyperdrive\AdminPages\Models;

defined('ABSPATH') or die('That\'s not how the Force works!');

class AdminPage
{
    public $pageTitle;

    public $menuTitle;

    public $capability;

    public $menuSlug;

    public $callback;

    public $iconUrl;

    public $position;

    public $subPageTitle;
}
