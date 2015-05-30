<?php
require_once 'm/BaseModel.php';
require_once 'v/BaseView.php';

class BaseController
{
    private $db;
    public function __construct()
    {
        $this->db = new BaseModel();   
    }
    /**
     * Used to display all the documents.
     * 
     * @param string $databaseName
     * @param bool $summarize If true truncate the text at $doclength 
     * @return string Echoes the document to the browser
     * @todo Make the HTML formatting more graceful
     */
    public function display_all_docs($databaseName, $summarize=false)
    {
        $resp = $this->db->fetchall_docs($databaseName);
        $doclength = 500;

        for ($i = 0; $i < count($resp); $i++) {
            $vw = new BaseView($resp[$i]);
            $vw->render();
        }   
    }

    /**
     * Displays the whole post on it's own page.
     *
     * @param string $docname The name of the document to display
     * @return string Echoes HTML to the browser
     */
    public function display_single_doc($docname)
    {
        $data = array();
        $resp = $this->db->fetch_id(basename($docname)); 
        $vw = new BaseView($resp);
        $vw->render();
    }

    /**
     * Builds an HTML ul of links to document IDs
     *
     * @return string Echoes unordered list to browser
     */
    public function docs_asmenu()
    {
        echo '<ul class="side-nav fixed" id="nav-mobile">' . "\n";
        $docs = $this->db->fetchall_ids('published');

        foreach($docs->rows as $menu_item) {
            $item_name = ucwords(str_replace('_', ' ', $menu_item->id));
            echo '<li><a class="thin" href="'.$menu_item->id.'">'.$item_name."</a></li>\n";
        }
        echo "</ul>\n";
    }

    /**
     * Builds an HTML ul of database names.
     *
     * @return string Not used
     */
    public function dbs_asmenu()
    {
        echo "<ul>\n";
        $dbs = $this->db->fetchall_dbs();   
        foreach ($dbs as $menu_item) {
            $item_name = str_replace(' ', '_', $item_name);
            echo '<li><a href="stop_using_weak_passwords">'.$item_name."</a></li>\n";
        }   
        echo "</ul><!-- end menu -->\n";
    }
}

