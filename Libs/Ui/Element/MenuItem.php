<?php

/**
 * O MENU
 *
 * @author ismael
 *
 */
class Ui_Element_MenuItem {

    private $id;
    private $title;
    private $link;
    private $img;
    private $dest;
    private $event;
    private $url;
    private $subMenu;
    private $badge;
    private $visible = true;

    /**
     *
     * @param <type> $id
     * @param <type> $title
     * @param <type> $link
     * @param <type> $dest
     * @param <type> $img
     */
    public function __construct($id, $title, $link = '#', $dest = '', $img = '', $badge = '') {
        $this->id = $id;
        $this->title = $title;
        $this->link = $link;
        $this->dest = $dest;
        $this->img = $img;
        $this->badge = $badge;
        $this->visible = true;
    }

    public function setEvent($event, $url) {
        $this->event = $event;
        $this->url = $url;
    }

    public function addSubMenu($menu) {
        $this->subMenu[] = $menu;
    }

    public function setVisible($processo, $acao) {
        $this->visible = Usuario::verificaAcesso($processo, $acao);
    }

    public function render($level = 1) {
        $subMenus = '';
        $menu = '';
        if ($this->visible) {
//            print '<pre>';
//            die(print_r($this));

            if ($this->subMenu) {
                $level++;
                foreach ($this->subMenu as $subMenu) {
                    $subMenus .= $subMenu->render($level);
                }

                $menu .= '<li>';
                if ($subMenus != '') {
                    $flecha = '<span class="fa arrow"></span>';
                }
                if ($this->badge != '') {
                    $flecha .= "<span class='badge alert-info pull-right'>$this->badge </span>";
                }
                if ($this->img) {
                    $img = '<i class="fa fa-' . $this->img . ' fa-fw"></i> ';
                }
                $menu .= '    <a href="#"> ' . $img . $this->title . $flecha . '</a>';



                if ($subMenus != '') {
                    if ($level == 2) {
                        $levelTxt = "second";
                    } elseif ($level == 3) {
                        $levelTxt = "third";
                    } elseif ($level == 4) {
                        $levelTxt = "fourth";
                    }
                    $menu .= '  <ul class="nav nav-' . $levelTxt . '-level">';
                    $menu .= $subMenus;
                    $menu .= '</ul> ';
                }
                $menu .= ' </li>';
            } else {
                if ($this->link != '#' || $this->url != '') {

                    $menu .= '<li  > ';
                    $menu .= '<a name="' . $this->id . '" onclick="abortAjax();" href="' . $this->link . '">';
                    if ($this->img) {
                        $menu .= '<i class="fa fa-' . $this->img . ' fa-fw"></i> ';
                    }
                    $menu .= $this->title . '</a>';
                    $menu .= '</li> ';
                }
            }
        }
        return $menu;
    }

}
