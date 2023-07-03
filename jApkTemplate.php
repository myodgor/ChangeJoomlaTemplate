<?php
/**
 * @brief 	Открыть страницу Joomla в другом шаблоне через GET-запрос
 * @author 	Максим Ёдгоров
 * @version 	1.0.0
 * @copyright 	Copyright (C) 2023 Максим Ёдгоров
 * @license 	Licensed under GNU/GPLv3, see https://www.gnu.org/licenses/gpl-3.0.html
 */

// no direct access
defined("_JEXEC") or die();

class plgSystemjApkTemplate extends JPlugin
{
    function onAfterRoute()
    {
        $app = JFactory::getApplication();
        $input = $app->input;
        $apk = $input->get("apk", "off", "string");
        if (!$app->isAdmin() && $apk == "on") {
            $tmlpid = $this->params->get("tmlpid", "16");
            $db = JFactory::getDbo();
            $query = $db
                ->getQuery(true)
                ->select("template, params")
                ->from("#__template_styles")
                ->where("id=" . $tmlpid);
            $db->setQuery($query);
            $template = $db->loadObject();
            $app->setTemplate(
                $template->template,
                new JRegistry($template->params)
            );
        }
    }
}

?>
