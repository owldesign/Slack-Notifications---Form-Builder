<?php
/**
 * Slack Notifications plugin for Craft CMS
 *
 * Slack notifications for Form Builder
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://owl-design.net
 * @package   FormBuilderSlackNotifications
 * @since     1.0.0
 */

namespace Craft;

class FormBuilderSlackNotificationsPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init()
    {
        parent::init();

        require CRAFT_PLUGINS_PATH.'/formbuilderslacknotifications/vendor/autoload.php';

        craft()->templates->hook('formBuilder.formNotificationsHtml', function(&$context) {
            $template = craft()->templates->render('formbuilderslacknotifications/slack-notifications', array(
                'context' => $context,
            ));

            return $template;
        });
    }

    /**
     * @return mixed
     */
    public function getName()
    {
         return Craft::t('Slack Notifications');
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('Slack notifications for Form Builder');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/owldesign/Slack-Notifications---Form-Builder';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/owldesign/Slack-Notifications---Form-Builder/master/releases.json';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getDeveloper()
    {
        return 'Vadim Goncharov';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'http://owl-design.net';
    }

    /**
     * @return bool
     */
    public function hasCpSection()
    {
        return false;
    }

    /**
    * Plugin settings.
    *
    * @return array
    */
    protected function defineSettings()
    {
        return array(
            'webhookUrl' => array(AttributeType::String),
        );
    }

    /**
     * Required plugin fields
     *
     * @return array
     */
    public function getRequiredFields()
    {
        $required = array(
            'webhookUrl' => array(
                'empty' => Craft::t('Needs Webhook URL')
            )
        );

        return $required;
    }

    public function getSettingsUrl()
    {
        return 'settings/plugins/formbuilderslacknotifications';
    }

    public function getSettingsHtml()
    {
        return craft()->templates->render('formbuilderslacknotifications/settings', array(
            'settings' => $this->getSettings()
        ));
    }

    /**
     */
    public function onBeforeInstall()
    {
    }

    /**
     */
    public function onAfterInstall()
    {
    }

    /**
     */
    public function onBeforeUninstall()
    {
        return formbuilder()->forms->clearSlackNotifications();
    }

    /**
     */
    public function onAfterUninstall()
    {
    }
}

function slack()
{
    return Craft::app()->getComponent('formBuilderSlackNotifications');
}