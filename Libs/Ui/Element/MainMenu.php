<?php

class Ui_Element_MainMenu {

    private $id;
    private $position;
    private $menuItem;
    private $velocidade;
    private $wSubmenu;

    public function __construct($id = 'menu', $position = 'h') {
        $this->id = $id;
        $this->position = $position;
        $this->menuItem = array();
        Browser_Control::setScript('js', 'Menu', 'Menu/pluginMenu.js');
        if ($this->position == 'v') {
            Browser_Control::setScript('css', 'MenuV', 'Menu/Vertical.css');
        } else {
            Browser_Control::setScript('css', 'MenuH', 'Menu/Horizontal.css');
        }
    }

    public function setParams($wSubmenu, $velocidade = '') {
        $this->wSubmenu = $wSubmenu;
        $this->velocidade = $velocidade;
    }

    public function addMenuItem($item) {
        $this->menuItem[] = $item;
    }

    public function render() {
        $menu = '';
        foreach ($this->menuItem as $item) {
            $menu .= $item->render();
        }
        return $menu;
    }

}
