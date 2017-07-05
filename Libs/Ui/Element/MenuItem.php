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

                $menu .= '<li class="has_sub">';
                if ($subMenus != '') {
                    $flecha = '<span class="menu-arrow"></span>';
                }
                if ($this->badge != '') {
                    $badge .= "<span class='label label-pill label-primary float-right'>$this->badge </span>";
                }
                if ($this->img) {
                    $img = '<i class="zmdi zmdi-' . $this->img . ' "></i> ';
                }
                $menu .= '    <a href="#" class="waves-effect subdrop"> ' . $badge . $img . '<span>' . $this->title . '</span>' . $flecha . '</a>';



                if ($subMenus != '') {
                    if ($level == 2) {
                        $levelTxt = "second";
                    } elseif ($level == 3) {
                        $levelTxt = "third";
                    } elseif ($level == 4) {
                        $levelTxt = "fourth";
                    }
                    $menu .= '  <ul class="list-unstyled nav-' . $levelTxt . '-level">';
                    $menu .= $subMenus;
                    $menu .= '</ul> ';
                }
                $menu .= ' </li>';
            } else {
                if ($this->link != '#' || $this->url != '') {
                    if ($level == 1) {

                        $menu .= '<li class="has_sub" > ';
                        $menu .= '<a class="waves-effect" name="' . $this->id . '"  href="' . $this->link . '">';
                    } else {
                        $menu .= '<li > ';
                        $menu .= '<a   name="' . $this->id . '"  href="' . $this->link . '">';
                    }
                    if ($this->img) {
                        $menu .= '<i class="zmdi zmdi-' . $this->img . ' "></i> ';
                    }
                    $menu .= $this->title . '</a>';
                    $menu .= '</li> ';
                }
            }
        }
        return $menu;
    }

}
