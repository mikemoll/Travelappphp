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

                $menu .= '<li class="">';
                if ($subMenus != '') {
                    $flecha = '<span class="arrow"></span>';
                }
                if ($this->badge != '') {
                    $details .= " <span class='details'>$this->badge</span>";
                }
                //== img ==
                if ($this->img) {
                    $img = '<i class="pg-' . $this->img . '"></i>';
                } else {
                    $img = substr($this->title, 0, 1);
                }
                $img = '<span class="icon-thumbnail">' . $img . '</span>  ';
                //== /img ==
                //              <li>
//                 <a href="javascript:;">
//                 <span class="title">Calendar</span>
//                            <span class=" arrow"></span></a>
//                        <span class="icon-thumbnail"><i class="pg-calender"></i></span>
//                        <ul class="sub-menu">
//                            <li class="">
                $menu .= '    <a href="javascript:;" ><span class="title">' . $this->title . '</span>' . $flecha . '</a>';
                $menu .= $img;

                if ($subMenus != '') {
                    if ($level == 2) {
                        $levelTxt = "second";
                    } elseif ($level == 3) {
                        $levelTxt = "third";
                    } elseif ($level == 4) {
                        $levelTxt = "fourth";
                    }
                    $menu .= '  <ul class="sub-menu nav-' . $levelTxt . '-level">';
                    $menu .= $subMenus;
                    $menu .= '</ul> ';
                }
                $menu .= ' </li>';
            } else {
                if ($this->link != '#' || $this->url != '') {
                    if ($this->img) {
                        $img = '<i class="pg-' . $this->img . '"></i>';
                    } else {
                        $img = substr($this->title, 0, 1);
                    }
                    $img = '<span class="icon-thumbnail">' . $img . '</span>  ';
                    if ($level == 1) {
                        if ($this->badge != '') {
                            $details = " <span class='details'>$this->badge</span>";
                        }
                        $menu .= '<li class="">';
                        $menu .= ' <a href="' . $this->link . '" ' . ($details != '' ? 'class="detailed"' : '') . '>
                             <span class="title">' . $this->title . '</span>
                             ' . $details . '
                         </a>' . $img . '';
                    } else {
                        $menu .= '<li > ';
                        $menu .= '<a   name="' . $this->id . '"  href="' . $this->link . '">' . $this->title;
                        $menu .= '</a>';
                        $menu .= $img;
                    }

                    $menu .= '</li> ';
                }
            }
        }
        return $menu;
    }

}
