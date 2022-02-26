<?php
require_once('plugins/designs.php');

/**
 * @param array URL in key, name in value
 */
return new AdminerDesigns(
        $designs = $_ENV['ADMINER_DESIGN']
);
