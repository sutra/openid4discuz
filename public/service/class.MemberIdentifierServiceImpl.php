<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.MemberIdentifierServiceImpl.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 23.04.2009, 21:38:08 with ArgoUML PHP module 
 * (last revised $Date: 2008-04-19 08:22:08 +0200 (Sat, 19 Apr 2008) $)
 *
 * @author firstname and lastname of author, <author@example.org>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * The Data Access Object for the identifier and member mapping.
 *
 * @author Sutra Zhou
 */
require_once('interface.MemberIdentifierService.php');

/* user defined includes */
// section -64--88-0-120--5bf85a08:120c888ef91:-8000:0000000000000E6B-includes begin
// section -64--88-0-120--5bf85a08:120c888ef91:-8000:0000000000000E6B-includes end

/* user defined constants */
// section -64--88-0-120--5bf85a08:120c888ef91:-8000:0000000000000E6B-constants begin
// section -64--88-0-120--5bf85a08:120c888ef91:-8000:0000000000000E6B-constants end

/**
 * Short description of class MemberIdentifierServiceImpl
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 */
class MemberIdentifierServiceImpl
        implements MemberIdentifierService
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    // --- OPERATIONS ---

    /**
     * Get usernames by identifier.
     *
     * @access public
     * @author Sutra Zhou
     * @param  String identifier
     * @return String[]
     */
    public function getMembers( String $identifier)
    {
        $returnValue = null;

        // section -64--88-0-120-6cf3b849:120c3f92eca:-8000:0000000000000CBD begin
        // section -64--88-0-120-6cf3b849:120c3f92eca:-8000:0000000000000CBD end

        return $returnValue;
    }

    /**
     * Bind identifier to the member.
     *
     * @access public
     * @author Sutra Zhou
     * @param  String identifier
     * @param  String username
     * @return Boolean
     */
    public function bind( String $identifier,  String $username)
    {
        $returnValue = null;

        // section -64--88-0-120-6cf3b849:120c3f92eca:-8000:0000000000000CC0 begin
        // section -64--88-0-120-6cf3b849:120c3f92eca:-8000:0000000000000CC0 end

        return $returnValue;
    }

    /**
     * Short description of method unbind
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String identifier
     * @param  String username
     * @return Boolean
     */
    public function unbind( String $identifier,  String $username)
    {
        $returnValue = null;

        // section -64--88-0-120--5bf85a08:120c888ef91:-8000:0000000000000E6E begin
        // section -64--88-0-120--5bf85a08:120c888ef91:-8000:0000000000000E6E end

        return $returnValue;
    }

} /* end of class MemberIdentifierServiceImpl */

?>