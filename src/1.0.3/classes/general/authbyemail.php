<?php

class CIMYIELoginByEmail
{
    public static function On()
    {
        COption::SetOptionString("imyie.loginbyemail", "auth_by_email", "Y");

        RegisterModuleDependences(
            "main",
            "OnBeforeUserLogin",
            "imyie.loginbyemail",
            "CIMYIELoginByEmail",
            "OnBeforeUserLoginHandler"
        );
    }

    public static function Off()
    {
        COption::SetOptionString("imyie.loginbyemail", "auth_by_email", "N");

        UnRegisterModuleDependences(
            "main",
            "OnBeforeUserLogin",
            "imyie.loginbyemail",
            "CIMYIELoginByEmail",
            "OnBeforeUserLoginHandler"
        );
    }

    public static function OnBeforeUserLoginHandler(&$arFields)
    {
        $userLogin = $_POST["USER_LOGIN"];
        if (isset($userLogin)) {
            $isEmail = strpos($userLogin, "@");
            if ($isEmail > 0) {
                $arFilter = ["EMAIL" => $userLogin];
                $rsUsers = CUser::GetList(($by = "id"), ($order = "desc"), $arFilter);
                if ($res = $rsUsers->Fetch()) {
                    if ($res["EMAIL"] == $arFields["LOGIN"]) {
                        $arFields["LOGIN"] = $res["LOGIN"];
                    }
                }
            }
        }
    }
}
