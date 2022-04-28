<?php

/**
 * Displays the index page.
 *
 * @return void
 */
function index()
{
    // We generate HTML code from the view
    require_once(DIR . '/view/frontoffice/ViewIndex.php');
    ViewIndex::DisplayIndex();
}

?>