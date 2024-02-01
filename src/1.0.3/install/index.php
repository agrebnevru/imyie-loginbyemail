<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class imyie_loginbyemail extends CModule
{
    public $MODULE_ID = "imyie.loginbyemail";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_CSS;
    public $MODULE_GROUP_RIGHTS = "Y";

    public function __construct()
    {
        $arModuleVersion = array();
        include(dirname(__FILE__) . "/version.php");
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = GetMessage('VIAMODO_TSN_INSTALL_NAME');
        $this->MODULE_DESCRIPTION = GetMessage('VIAMODO_TSN_INSTALL_DESCRIPTION');
        $this->PARTNER_NAME = GetMessage('VIAMODO_TSN_INSTALL_COMPANY_NAME');
        $this->PARTNER_URI = 'https://agrebnev.ru/';
    }

    public function InstallDB()
    {
        ModuleManager::registerModule("imyie.loginbyemail");

        return true;
    }

    public function InstallFiles()
    {
        return true;
    }

    public function InstallPublic()
    {
        return true;
    }

    public function InstallEvents()
    {
        COption::SetOptionString("imyie.loginbyemail", "auth_by_email", "Y");
        COption::SetOptionString("imyie.loginbyemail", "loginbylink_onoff", "N");
        COption::SetOptionString("imyie.loginbyemail", "loginbylink_link", "/auth/");

        RegisterModuleDependences(
            "main",
            "OnBeforeUserLogin",
            "imyie.loginbyemail",
            "CIMYIELoginByEmail",
            "OnBeforeUserLoginHandler"
        );

        return true;
    }

    public function UnInstallDB($arParams = array())
    {
        ModuleManager::unRegisterModule("imyie.loginbyemail");

        return true;
    }

    public function UnInstallFiles()
    {
        return true;
    }

    public function UnInstallPublic()
    {
        return true;
    }

    public function UnInstallEvents()
    {
        COption::RemoveOption("imyie.loginbyemail");

        UnRegisterModuleDependences(
            "main",
            "OnBeforeUserLogin",
            "imyie.loginbyemail",
            "CIMYIELoginByEmail",
            "OnBeforeUserLoginHandler"
        );

        return true;
    }

    public function DoInstall()
    {
        global $APPLICATION, $step;

        $this->InstallFiles();
        $this->InstallDB();
        $this->InstallEvents();
        $this->InstallPublic();

        $APPLICATION->IncludeAdminFile(
            GetMessage("SPER_INSTALL_TITLE"),
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/imyie.loginbyemail/install/install.php"
        );
    }

    public function DoUninstall()
    {
        global $APPLICATION, $step;

        $this->UnInstallFiles();
        $this->UnInstallDB();
        $this->UnInstallEvents();
        $this->UnInstallPublic();

        $APPLICATION->IncludeAdminFile(
            GetMessage("SPER_UNINSTALL_TITLE"),
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/imyie.loginbyemail/install/uninstall.php"
        );
    }
}
