<?php
/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 10-Mar-18
 * Time: 12:29 PM
 */

namespace Admin\View\Helper;


use Zend\View\Helper\AbstractHelper;

class Layout extends AbstractHelper
{
    protected $sm;
    public function __construct($sm)
    {
        $this->sm = $sm;
    }


    public function callTopMenu(){
        $linkLogout = $this->view->url('admin/verify',array('action'=>'logout'));




        $menuTop = "
            <nav class=\"navbar navbar-default navbar-static-top\" role=\"navigation\" style=\"margin-bottom: 0\">
        <div class=\"navbar-header\">
            <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
                <span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </button>
            <a class=\"navbar-brand\" href=\"index.html\">Admin ZendHoa</a>
        </div>
        <!-- /.navbar-header -->
        <ul class=\"nav navbar-nav navbar-top-links navbar-right\">
            <li class=\"dropdown nav-item\">
                <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">
                    <i class=\"fa fa-user fa-fw\"></i> <i class=\"fa fa-caret-down\"></i>
                </a>
                <ul class=\"dropdown-menu dropdown-user\">
                    <li><a href=\"#\"><i class=\"fa fa-user fa-fw\"></i> User Profile</a>
                    </li>
                    <li><a href=\"#\"><i class=\"fa fa-gear fa-fw\"></i> Settings</a>
                    </li>
                    <li class=\"divider\"></li>
                    <li><a href=\"$linkLogout\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- /.navbar-top-links -->
        ".
        $this->callLeftMenu()
            ."
        <!-- /.navbar-static-side -->
    </nav>
        ";
        return $menuTop;
    }

    public function callLeftMenu(){
        $linkCateList = $this->view->url('admin/category',array('action'=>'index'));
        $linkProductList = $this->view->url('admin/product',array('action'=>'index'));
        $leftMenu = "
        <div class=\"navbar-default sidebar\" role=\"navigation\">
            <div class=\"sidebar-nav navbar-collapse\">
                <ul class=\"nav\" id=\"side-menu\">
                    <li class=\"sidebar-search\">
                        <div class=\"input-group custom-search-form\">
                            <input type=\"text\" class=\"form-control\" placeholder=\"Search...\">
                            <span class=\"input-group-btn\">
                                <button class=\"btn btn-default\" type=\"button\">
                                    <i class=\"fa fa-search\"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href=\"index.html\"><i class=\"fa fa-dashboard fa-fw\"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href=\"#\"><i class=\"fa fa-bar-chart-o fa-fw\"></i> Charts<span class=\"fa arrow\"></span></a>
                        <ul class=\"nav nav-second-level\">
                            <li>
                                <a href=\"flot.html\">Flot Charts</a>
                            </li>
                            <li>
                                <a href=\"morris.html\">Morris.js Charts</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href=\"tables.html\"><i class=\"fa fa-table fa-fw\"></i> Tables</a>
                    </li>
                    <li>
                        <a href=\"forms.html\"><i class=\"fa fa-edit fa-fw\"></i> Forms</a>
                    </li>
                    <li>
                        <a href=\"#\"><i class=\"fa fa-wrench fa-fw\"></i> UI Elements<span class=\"fa arrow\"></span></a>
                        <ul class=\"nav nav-second-level\">
                            <li>
                                <a href=\"panels-wells.html\">Panels and Wells</a>
                            </li>
                            <li>
                                <a href=\"buttons.html\">Buttons</a>
                            </li>
                            <li>
                                <a href=\"notifications.html\">Notifications</a>
                            </li>
                            <li>
                                <a href=\"typography.html\">Typography</a>
                            </li>
                            <li>
                                <a href=\"icons.html\"> Icons</a>
                            </li>
                            <li>
                                <a href=\"grid.html\">Grid</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href=\"#\"><i class=\"fa fa-sitemap fa-fw\"></i> Multi-Level Dropdown<span class=\"fa arrow\"></span></a>
                        <ul class=\"nav nav-second-level\">
                            <li>
                                <a href=\"#\">Second Level Item</a>
                            </li>
                            <li>
                                <a href=\"#\">Second Level Item</a>
                            </li>
                            <li>
                                <a href=\"#\">Third Level <span class=\"fa arrow\"></span></a>
                                <ul class=\"nav nav-third-level\">
                                    <li>
                                        <a href=\"#\">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href=\"#\">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href=\"#\">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href=\"#\">Third Level Item</a>
                                    </li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href=\"\"><i class=\"fa fa-sitemap fa-fw\"></i> Category<span class=\"fa arrow\"></span></a>
                        <ul class=\"nav nav-second-level\">
                            <li>
                                <a href=\"$linkCateList\">List</a>
                            </li>
                            <li>
                                <a href=\"#\">Add</a>
                            </li>
                            <li>
                                <a href=\"#\">Edit</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href=\"#\"><i class=\"fa fa-files-o fa-fw\"></i> Product<span class=\"fa arrow\"></span></a>
                        <ul class=\"nav nav-second-level\">
                            <li>
                                <a href=\"$linkProductList\">List</a>
                            </li>
                            <li>
                                <a href=\"login.html\">Login Page</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        ";

        return $leftMenu;
    }
}