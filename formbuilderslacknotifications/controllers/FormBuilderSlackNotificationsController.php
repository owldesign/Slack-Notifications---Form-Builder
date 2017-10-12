<?php
/**
 * Slack Notifications plugin for Craft CMS
 *
 * SlackNotifications Controller
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://owl-design.net
 * @package   SlackNotifications
 * @since     1.0.0
 */

namespace Craft;

class FormBuilderSlackNotificationsController extends BaseController
{

    protected $allowAnonymous = array('actionAddNotification');

    public function actionAddNotification()
    {
        $this->requirePostRequest();
        $this->requireAjaxRequest();

        $index = craft()->request->getPost('index');
        $context = craft()->request->getPost('context');
        $formId = craft()->request->getPost('formId');

        if (!empty($formId)) {
            $form = formbuilder()->forms->getFormRecordById($formId);
            if (!$form) {
                throw new HttpException(404);
            }
        } else {
            $form = new FormBuilder_FormModel();
        }

        $variables['form'] = $form;
        $variables['index'] = $index;
        $variables['context'] = $context;
        $variables['formId'] = $formId;

        $oldPath = craft()->templates->getTemplatesPath();
        craft()->templates->setTemplatesPath(craft()->path->getSiteTemplatesPath());

        $markup = craft()->templates->render('formbuilderslacknotifications/_includes/_notification-markup', $variables);

        craft()->templates->setTemplatesPath($oldPath);

        $this->returnJson(array(
            'success'   => true,
            'markup'    => $markup
        ));
    }
}