<?php

namespace Hyperdrive\AdminPages;

use Hyperdrive\AdminPages\Models\AdminPage;
use Hyperdrive\AdminPages\Models\AdminSubPage;
use Hyperdrive\Core\Interfaces\Registerable;

defined('ABSPATH') or die('That\'s not how the Force works!');

class Bootstrap implements Registerable
{
    /**
     * @var AdminPage[]
     */
    protected $pages = [];

    /**
     * @var AdminSubPage[]
     */
    protected $subPages = [];

    public function register(): void
    {
        add_action('admin_menu', [$this, 'init']);
    }

    public function init(): void
    {
        $this->buildPagesArray();
        $this->buildSubPagesArray();
        $this->registerPages();
        $this->registerSubPages();
    }

    private function buildPagesArray(): void
    {
        $this->pages = apply_filters('wp_hyperdrive_admin_pages', $this->pages);

        foreach ($this->pages as $page) {
            if (!empty($page->subPageTitle)) {
                $this->subPages[] = $this->createSubPageFrom($page, $page->subPageTitle);
            }
        }
    }

    private function buildSubPagesArray(): void
    {
        $this->subPages = apply_filters('wp_hyperdrive_admin_subpages', $this->subPages);
    }

    private function createSubPageFrom(AdminPage $original, string $title): AdminSubPage
    {
        $page = new AdminSubPage();

        $page->parentSlug = $original->menuSlug;
        $page->pageTitle  = $original->pageTitle;
        $page->menuTitle  = $title ?: $original->menuTitle;
        $page->capability = $original->capability;
        $page->menuSlug   = $original->menuSlug;
        $page->callback   = $original->callback;

        return $page;
    }

    private function registerPages(): void
    {
        if (!$this->pages) {
            return;
        }

        foreach ($this->pages as $page) {
            add_menu_page(
                $page->pageTitle,
                $page->menuTitle,
                $page->capability,
                $page->menuSlug,
                $page->callback,
                $page->iconUrl,
                $page->position
            );
        }
    }

    private function registerSubPages(): void
    {
        if (!$this->subPages) {
            return;
        }

        foreach ($this->subPages as $page) {
            add_submenu_page(
                $page->parentSlug,
                $page->pageTitle,
                $page->menuTitle,
                $page->capability,
                $page->menuSlug,
                $page->callback
            );
        }
    }
}
