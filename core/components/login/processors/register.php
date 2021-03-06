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
 * Handle register form
 *
 * @package login
 * @subpackage processors
 */
/* create user and profile */
$user = $modx->newObject('modUser');
$user->fromArray($fields);
$user->set('active',0);
$user->set('password',md5($fields['password']));
$profile = $modx->newObject('modUserProfile');
$profile->fromArray($fields);

if (!$user->save()) {
    return $modx->lexicon('register.user_err_save');
}
$profile->set('internalKey',$user->get('id'));
$profile->save();

/* if usergroups set */
$usergroups = $modx->getOption('usergroups',$scriptProperties,'');
if (!empty($usergroups)) {
    $usergroups = explode(',',$usergroups);

    foreach ($usergroups as $usergroupPk) {
        $pk = array();
        if (is_numeric($usergroupPk)) {
            $pk['id'] = $usergroupPk;
        } else {
            $pk['name'] = $usergroupPk;
        }
        $usergroup = $modx->getObject('modUserGroup',$pk);
        if (!$usergroup) continue;

        $member = $modx->newObject('modUserGroupMember');
        $member->set('member',$user->get('id'));
        $member->set('user_group',$usergroup->get('id'));
        $member->save();
    }
}

/* send activation email (if chosen) */
$email = $user->get('email');
$activation = $modx->getOption('activation',$scriptProperties,true);
$activateResourceId = $modx->getOption('activationResourceId',$scriptProperties,'');
if ($activation && !empty($email) && !empty($activateResourceId)) {

    /* generate a password and encode it and the username into the url */
    $pword = $login->generatePassword();
    $confirmParams = 'lp='.urlencode(base64_encode($pword));
    $confirmParams .= '&lu='.urlencode(base64_encode($user->get('username')));
    $confirmUrl = $modx->makeUrl($activateResourceId,'',$confirmParams,'full');

    /* set the email properties */
    $emailTpl = $modx->getOption('activationEmailTpl',$scriptProperties,'lgnActivateEmail');
    $emailTplType = $modx->getOption('activationEmailTplType',$scriptProperties,'modChunk');
    $emailProperties = $user->toArray();
    $emailProperties['confirmUrl'] = $confirmUrl;
    $emailProperties['tpl'] = $emailTpl;
    $emailProperties['tplType'] = $emailTplType;
    $emailProperties['password'] = $fields['password'];

    /* now set new password to registry to prevent middleman attacks.
     * Will read from the registry on the confirmation page. */

    $modx->getService('registry', 'registry.modRegistry');
    $modx->registry->addRegister('login','registry.modFileRegister');
    $modx->registry->login->connect();
    $modx->registry->login->subscribe('/useractivation/');
    $modx->registry->login->send('/useractivation/',array($user->get('username') => $pword),array(
        'ttl' => ($modx->getOption('activationttl',$scriptProperties,180)*60),
    ));

    $subject = $modx->getOption('activationEmailSubject',$scriptProperties,$modx->lexicon('login.activation_email_subject'));
    $login->sendEmail($user->get('email'),$user->get('username'),$subject,$emailProperties);

} else {
    $user->set('active',1);
    $user->save();
}

/* if provided a redirect id, will redirect to that resource, with the
 * GET params `username` and `email` for you to use */
$submittedResourceId = $modx->getOption('submittedResourceId',$scriptProperties,'');
if (!empty($submittedResourceId)) {
    $url = $modx->makeUrl($submittedResourceId).'?username='.$user->get('username').'&email='.$profile->get('email');
    $modx->sendRedirect($url);
} else {
    $successMsg = $modx->getOption('successMsg',$scriptProperties,'');
    $modx->toPlaceholder('error.message',$successMsg);
}

return true;
