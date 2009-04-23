<?php

error_reporting(E_ALL);

/**
 * The Data Access Object for the identifier and member mapping.
 *
 * @author Sutra Zhou
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-120-6cf3b849:120c3f92eca:-8000:0000000000000CAE-includes begin
// section -64--88-0-120-6cf3b849:120c3f92eca:-8000:0000000000000CAE-includes end

/* user defined constants */
// section -64--88-0-120-6cf3b849:120c3f92eca:-8000:0000000000000CAE-constants begin
// section -64--88-0-120-6cf3b849:120c3f92eca:-8000:0000000000000CAE-constants end

/**
 * The Data Access Object for the identifier and member mapping.
 *
 * @access public
 * @author Sutra Zhou
 */
interface MemberIdentifierService
{


    // --- OPERATIONS ---

    /**
     * Get usernames by identifier.
     *
     * @access public
     * @author Sutra Zhou
     * @param  String identifier
     * @return String[]
     */
    public function getMembers( String $identifier);

    /**
     * Bind identifier to the member.
     *
     * @access public
     * @author Sutra Zhou
     * @param  String identifier
     * @param  String username
     * @return Boolean
     */
    public function bind( String $identifier,  String $username);

    /**
     * Short description of method unbind
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String identifier
     * @param  String username
     * @return Boolean
     */
    public function unbind( String $identifier,  String $username);

} /* end of interface MemberIdentifierService */

?>