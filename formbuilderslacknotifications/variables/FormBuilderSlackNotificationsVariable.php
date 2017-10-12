<?php
namespace Craft;

class FormBuilderSlackNotificationsVariable
{
    public function getPluginSettings()
    {
        $settings = craft()->plugins->getPlugin('formBuilderSlackNotifications')->getSettings();

        return $settings;
    }
}