<?php

namespace Hyperdrive\AdminPages\Models;

defined('ABSPATH') or die('That\'s not how the Force works!');

class AdminSubPage
{
    public $parentSlug;

    public $pageTitle;

    public $menuTitle;

    public $capability;

    public $menuSlug;

    public $callback;
}
