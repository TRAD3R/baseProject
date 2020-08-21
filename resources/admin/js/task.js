var CpaTask = {
    params:  null,
    type: null,
    csrf: null,
    init: function(params) {
        this.setParams(params);

        $('#create-task-btn').on('click', function() {
            $('#task-modal').modal('show');
        });

        $('#task-create-confirm').on('click', function() {
            CpaTask.create();
        });
    },
    setType: function(type) {
        this.type = type;
    },
    setUrl: function (url) {
        this.url = url
    },
    setParams: function(params) {
        this.params = params;
    },
    create: function() {
        $.post(this.url, {type: this.type, params: this.params}, function(response){
            if(response['success']) {
                alert('Задание "' + response['name'] + '" успешно создано.');
            } else if(response['error']) {
                alert('Ошибка: ' + response['error'] + '');
            }

            $('#task-modal').modal('hide');
        }, 'json');
    }
};