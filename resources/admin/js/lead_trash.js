var LeadTrash = {
    url        : null,
    init       : function (url) {
        this.url  = url;

        $(document).on('click', '.lead-trash-button', function () {
            var initiator = $(this);
            LeadTrash.toggleTrash(initiator)
        });
    },
    setUrl     : function (url) {
        this.url = url;
    },
    toggleTrash: function (initiator) {
        var is_trash = Number(initiator.data('is-trash')),
            lead_id  = Number(initiator.data('lead-id')),
            icon     = initiator.find('i');

        if (!this.url) {
            alert('Не задан url для смены trash статуса лида.');
            return false;
        }

        $.post(this.url, {id: lead_id, is_trash: is_trash ? 0 : 1, _csrf: this.csrf}, function (response) {
            if (response.success) {
                if (is_trash) {
                    initiator.data('is-trash', 0);
                    icon.removeClass('fa-times text-success').addClass('fa-trash-o text-danger');
                } else {
                    initiator.data('is-trash', 1);
                    icon.removeClass('fa-trash-o text-danger').addClass('fa-times text-success');
                }
            }
        }, 'json');
    }
};