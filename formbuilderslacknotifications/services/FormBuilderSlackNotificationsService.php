<?php
namespace Craft;

use Owldesign\SlackClient\SlackClient;
use Owldesign\SlackClient\SlackAttachment;
use Owldesign\SlackClient\SlackAttachmentField;
use Owldesign\SlackClient\SlackMessage;

class FormBuilderSlackNotificationsService extends BaseApplicationComponent
{
    // Properties
    // =========================================================================

    private $form;
    private $entry;

    /**
     * Prepare notification
     *
     * @param FormBuilder_EntryModel $entry
     * @param $post
     */
    public function prepareNotification(FormBuilder_EntryModel $entry, $notifications, $post, $files)
    {
        $this->form = $entry->getForm();
        $this->entry = $entry;

        $settings = craft()->plugins->getPlugin('FormBuilderSlackNotifications')->getSettings();
        $webhook = $settings->webhookUrl;

        foreach ($notifications as $key => $notification) {
            $enabled = $notification['enabled'] == '1' ? true : false;

            if ($enabled && $webhook) {
                $text = isset($notification['text']) && $notification['text'] != '' ? $notification['text'] : '';

                $client = new SlackClient();
                $client->setWebhook($webhook);
                    
                $message = new SlackMessage();
                $message
                    ->setUnfurlLinks(true)
                    ->setText($text);

                if ($notification['attachments']) {

                    $attachment = new SlackAttachment();
                    $attachment->setColor('#a6e50f');

                    $field = array();

                    foreach ($post['fields'] as $key => $value) {
                        $field[$key] = new SlackAttachmentField();
                        $theField = craft()->fields->getFieldByHandle($key);

                        if ($theField->type == 'Checkboxes' || $theField->type == 'MultiSelect') {
                            $value = StringHelper::arrayToString($value, ', ');
                        }

                        $field[$key]
                            ->setTitle($theField->name)
                            ->setValue($value)
                            ->setShort(true);
                    }

                    foreach ($field as $key => $item) {
                        $attachment->addField($item);
                    }

                    $message->addAttachment($attachment);
                }

                if ($entry->id) {
                    if (isset($notification['link']) && $notification['link']) {
                        $linkAttachment = new SlackAttachment();
                        $linkAttachment->setText('<'.$this->entry->url.'>')->setColor('#4da1ff');
                        $message->addAttachment($linkAttachment);
                    }
                }

                $client->postToChannel($notification['channel'], $message);
            }
        }
    }
}