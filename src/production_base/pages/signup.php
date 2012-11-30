<?
/********************************************************************************
 * The contents of this file are subject to the Common Public Attribution License
 * Version 1.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at
 * http://www.wikiarguments.net/license/. The License is based on the Mozilla
 * Public License Version 1.1 but Sections 14 and 15 have been added to cover
 * use of software over a computer network and provide for limited attribution
 * for the Original Developer. In addition, Exhibit A has been modified to be
 * consistent with Exhibit B.
 *
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 *
 * The Original Code is Wikiarguments. The Original Developer is the Initial
 * Developer and is Wikiarguments GbR. All portions of the code written by
 * Wikiarguments GbR are Copyright (c) 2012. All Rights Reserved.
 * Contributor(s):
 *     Andreas Wierz (andreas.wierz@gmail.com).
 *
 * Attribution Information
 * Attribution Phrase (not exceeding 10 words): Powered by Wikiarguments
 * Attribution URL: http://www.wikiarguments.net
 *
 * This display should be, at a minimum, the Attribution Phrase displayed in the
 * footer of the page and linked to the Attribution URL. The link to the Attribution
 * URL must not contain any form of 'nofollow' attribute.
 *
 * Display of Attribution Information is required in Larger Works which are
 * defined in the CPAL as a work which combines Covered Code or portions
 * thereof with code not governed by the terms of the CPAL.
 *******************************************************************************/

class PageSignup extends Page
{
    public function PageSignup($row)
    {
        global $sDB, $sRequest;
        parent::Page($row);

        $this->view = VIEW_SIGNUP;

        if($sRequest->getInt("login"))
        {
            $this->handleLogin();
        }else if($sRequest->getInt("signup"))
        {
            $this->handleSignup();
        }if($sRequest->getInt("passRequest"))
        {
            $this->handlePassRequest();
        }
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getView()
    {
        return $this->view;
    }

    public function handleLogin()
    {
        global $sRequest, $sTemplate, $sQuery, $sUser, $sPermissions, $sSession;

        $username = $sRequest->getString("login_username");
        $password = $sRequest->getString("login_password");

        if($sUser->isLoggedIn())
        {
            $this->setError($sTemplate->getString("LOGIN_ERROR_ALREADY_LOGGED_IN"));
            return false;
        }

        $user = $sQuery->getUser("userName=".$username);
        if(!$user)
        {
            $user = $sQuery->getUser("userEmail=".$username);
        }
        if(!$user)
        {
            $this->setError($sTemplate->getString("LOGIN_ERROR_INVALID_USERNAME"));
            return false;
        }

        if($sPermissions->getPermission($user, ACTION_LOGIN) == PERMISSION_DISALLOWED)
        {
            $this->setError($sTemplate->getString("LOGIN_ERROR_ACCOUNT_PENDING"));
            return false;
        }

        if($user->login($password))
        {
            $sUser = $user;
            $sSession->setVal('notification', $sTemplate->getString("LOGIN_SUCCESS"));
            $sSession->serialize();

            header("Location: ".$sTemplate->getRoot());
            exit;
        }else
        {
            $this->setError($sTemplate->getString("LOGIN_ERROR_INVALID_PASSWORD"));
            return false;
        }
    }

    public function handleSignup()
    {
        global $sRequest, $sDB, $sQuery, $sTemplate, $sUser;

        $username   = $sRequest->getString("signup_username");
        $password   = $sRequest->getString("signup_password");
        $password2  = $sRequest->getString("signup_password_2");
        $email      = $sRequest->getString("signup_email");

        if($sUser->isLoggedIn())
        {
            $this->setError($sTemplate->getString("SIGNUP_ERROR_ALREADY_LOGGED_IN"));
        }else
        {
            if(!isValidUsername($username))
            {
                return false;
            }

            $user = $sQuery->getUser("userName=".$username);
            if($user)
            {
                $this->setError($sTemplate->getString("SIGNUP_ERROR_USERNAME_EXISTS"));
                return false;
            }

            $user = $sQuery->getUser("userEmail=".$email);
            if($user)
            {
                $this->setError($sTemplate->getString("SIGNUP_ERROR_EMAIL_IN_USE"));
                return false;
            }

            if($password != $password2)
            {
                $this->setError($sTemplate->getString("SIGNUP_ERROR_PASSWORD_MISMATCH"));
                return false;
            }

            $user = new User();

            if($user->create($username, $email, $password))
            {
                $this->setNotice($sTemplate->getString("SIGNUP_SUCCESS"));
                return true;
            }else
            {
                $this->setError($sTemplate->getString("SIGNUP_ERROR_GENERAL"));
                return false;
            }

            return false;
        }
    }

    public function handlePassRequest()
    {
        global $sRequest, $sTemplate, $sQuery, $sUser, $sPermissions, $sSession;

        $username = $sRequest->getString("login_username");
        $password = $sRequest->getString("login_password");

        if($sUser->isLoggedIn())
        {
            $this->setError($sTemplate->getString("LOGIN_ERROR_ALREADY_LOGGED_IN"));
            return false;
        }

        $user = $sQuery->getUser("userName=".$username);
        if(!$user)
        {
            $user = $sQuery->getUser("userEmail=".$username);
        }
        if(!$user)
        {
            $this->setError($sTemplate->getString("LOGIN_ERROR_INVALID_USERNAME"));
            return false;
        }

        $user->reqPass();

        $sSession->setVal('notification', $sTemplate->getString("PASS_REQUEST_SUCCESS"));
        $sSession->serialize();

        header("Location: ".$sTemplate->getRoot());
        exit;
    }

    public function title()
    {
        global $sTemplate;
        return $sTemplate->getString("HTML_META_TITLE_SIGNUP");
    }

    private $view;
};
?>