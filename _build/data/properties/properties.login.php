<?php
/**
 * Login
 *
 * Copyright 2010 by Jason Coward <jason@modxcms.com> and Shaun McCormick
 * <shaun@modxcms.com>
 *
 * Login is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * Login is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Login; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package login
 */
/**
 * Default Login snippet properties
 *
 * @package login
 * @subpackage build
 */
$properties = array(
    array(
        'name' => 'actionKey',
        'desc' => 'The REQUEST variable that indicates what action to take.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'service',
    ),
    array(
        'name' => 'loginKey',
        'desc' => 'The login action key.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'login',
    ),
    array(
        'name' => 'logoutKey',
        'desc' => 'The logout action key.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'logout',
    ),
    array(
        'name' => 'tplType',
        'desc' => 'The type of tpls being provided.',
        'type' => 'list',
        'options' => array(
            array('name' => 'Chunk','value' => 'modChunk'),
            array('name' => 'File','value' => 'file'),
            array('name' => 'Inline','value' => 'inline'),
            array('name' => 'Embedded','value' => 'embedded'),
        ),
        'value' => 'modChunk',
    ),
    array(
        'name' => 'loginTpl',
        'desc' => 'The login form tpl.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'lgnLoginTpl',
    ),
    array(
        'name' => 'logoutTpl',
        'desc' => 'The logout tpl.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'lgnLogoutTpl',
    ),
    array(
        'name' => 'errTpl',
        'desc' => 'The error tpl.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'lgnErrTpl',
    ),
    array(
        'name' => 'errTplType',
        'desc' => 'The type of error tpl.',
        'type' => 'list',
        'options' => array(
            array('name' => 'Chunk','value' => 'modChunk'),
            array('name' => 'File','value' => 'file'),
            array('name' => 'Inline','value' => 'inline'),
        ),
        'value' => 'modChunk',
    ),
    array(
        'name' => 'logoutResourceId',
        'desc' => 'Resource ID to redirect to on successful logout. 0 will redirect to self.',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
    ),
    array(
        'name' => 'loginResourceId',
        'desc' => 'The resource to direct users to on successful login. 0 will redirect to self.',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
    ),
    array(
        'name' => 'loginMsg',
        'desc' => 'Optional label message for login action. If blank, will default to lexicon string for Login.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'logoutMsg',
        'desc' => 'Optional label message for logout action. If blank, will default to lexicon string for Logout.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'redirectToPrior',
        'desc' => 'If true, will redirect to the referring page (HTTP_REFERER) on successful login.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
    ),
);

return $properties;