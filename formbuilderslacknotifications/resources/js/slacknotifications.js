var SlackNotification;

if ($ && window.Garnish) {
  SlackNotification = Garnish.Base.extend({
    index: null,
    context: null,
    formId: null,
    $notificationContainer: null,
    init: function(context, formId) {
      this.index = Math.floor((Math.random() * 10000) + 1);
      this.context = context;
      this.formId = formId;
      this.$notificationContainer = $('#formbuilder-slack-notifications-container');
      return this.getMarkup();
    },
    getMarkup: function() {
      var data;
      data = {
        index: this.index,
        context: this.context,
        formId: this.formId
      };
      return Craft.postActionRequest('formBuilderSlackNotifications/addNotification', data, $.proxy((function(response, textStatus) {
        var $element, $options, markup;
        if (textStatus === 'success') {
          markup = response.markup;
          this.$notificationContainer.append(markup);
          $element = $('#slack-notification-' + this.index);
          $options = $element.find('.option-item');
          new FormBuilderSection($element);
          return $options.each(function(i, el) {
            return new Option(el);
          });
        }
      }), this));
    }
  });
  Garnish.$doc.ready(function() {
    var context, el, formId;
    if ($('.add-slack-notification').length) {
      el = $('.add-slack-notification');
      context = el.data('context');
      formId = el.data('form-id');
      return el.on('click', function(e) {
        e.preventDefault();
        return new SlackNotification(context, formId);
      });
    }
  });
}
